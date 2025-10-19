<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use App\Models\Shop\Order;
use Illuminate\Support\Facades\Log;

class PayPalService
{
    private $httpClient;
    private $mode;
    private $clientId;
    private $clientSecret;
    private $baseUrl;
    private $accessToken;

    public function __construct()
    {
        $this->mode = config('paypal.mode');
        $paypalConfig = config("paypal.{$this->mode}");

        $this->clientId = $paypalConfig['client_id'];
        $this->clientSecret = $paypalConfig['client_secret'];

        // Set base URL based on mode
        $this->baseUrl = $this->mode === 'live'
            ? 'https://api.paypal.com'
            : 'https://api.sandbox.paypal.com';

        $this->httpClient = new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
        ]);
    }

    /**
     * Get PayPal access token
     */
    private function getAccessToken(): ?string
    {
        if ($this->accessToken) {
            return $this->accessToken;
        }

        try {
            $response = $this->httpClient->post('/v1/oauth2/token', [
                'headers' => [
                    'Accept' => 'application/json',
                    'Accept-Language' => 'en_US',
                ],
                'auth' => [$this->clientId, $this->clientSecret],
                'form_params' => [
                    'grant_type' => 'client_credentials'
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            $this->accessToken = $data['access_token'] ?? null;

            return $this->accessToken;

        } catch (GuzzleException $e) {
            Log::error('PayPal Access Token Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Create PayPal payment for an order
     */
    public function createPayment(Order $order): ?array
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Unable to get PayPal access token');
            }

            $totalUSD = $this->convertToUSD($order->total_price ?? 0);

            $paymentData = [
                'intent' => 'sale',
                'payer' => [
                    'payment_method' => 'paypal'
                ],
                'transactions' => [
                    [
                        'amount' => [
                            'total' => $totalUSD,
                            'currency' => config('paypal.currency', 'USD')
                        ],
                        'description' => "Order #{$order->id} - Total: " . number_format($order->total_price) . " VND",
                        'invoice_number' => $order->order_number ?? "ORDER-{$order->id}"
                    ]
                ],
                'redirect_urls' => [
                    'return_url' => config('paypal.return_url') . '?order_id=' . $order->id,
                    'cancel_url' => config('paypal.cancel_url') . '?order_id=' . $order->id
                ]
            ];

            Log::info('Creating PayPal payment', [
                'order_id' => $order->id,
                'total_vnd' => $order->total_price,
                'total_usd' => $totalUSD
            ]);

            $response = $this->httpClient->post('/v1/payments/payment', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => $paymentData
            ]);

            $result = json_decode($response->getBody(), true);

            Log::info('PayPal payment created successfully', [
                'payment_id' => $result['id'] ?? 'unknown',
                'state' => $result['state'] ?? 'unknown'
            ]);

            return $result;

        } catch (GuzzleException $e) {
            Log::error('PayPal Payment Creation Error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id ?? 'unknown'
            ]);
            return null;
        } catch (\Exception $e) {
            Log::error('General Payment Creation Error', [
                'error' => $e->getMessage(),
                'order_id' => $order->id ?? 'unknown'
            ]);
            return null;
        }
    }

    /**
     * Execute PayPal payment
     */
    public function executePayment(string $paymentId, string $payerId): ?array
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Unable to get PayPal access token');
            }

            $executionData = [
                'payer_id' => $payerId
            ];

            $response = $this->httpClient->post("/v1/payments/payment/{$paymentId}/execute", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => $executionData
            ]);

            $result = json_decode($response->getBody(), true);

            Log::info('PayPal payment executed successfully', [
                'payment_id' => $paymentId,
                'payer_id' => $payerId,
                'state' => $result['state'] ?? 'unknown'
            ]);

            return $result;

        } catch (GuzzleException $e) {
            Log::error('PayPal Payment Execution Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get payment details
     */
    public function getPayment(string $paymentId): ?array
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Unable to get PayPal access token');
            }

            $response = $this->httpClient->get("/v1/payments/payment/{$paymentId}", [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                ]
            ]);

            return json_decode($response->getBody(), true);

        } catch (GuzzleException $e) {
            Log::error('PayPal Get Payment Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Get approval URL from payment response
     */
    public function getApprovalUrl(array $payment): ?string
    {
        if (!isset($payment['links'])) {
            return null;
        }

        foreach ($payment['links'] as $link) {
            if ($link['rel'] === 'approval_url') {
                return $link['href'];
            }
        }

        return null;
    }

    /**
     * Convert VND to USD (approximate conversion)
     * You should use a real currency conversion API
     */
    private function convertToUSD($vndAmount): string
    {
        // Ensure we have a numeric value
        $vndAmount = is_numeric($vndAmount) ? (float)$vndAmount : 0;

        // Simple conversion rate - you should use real-time rates
        $usdAmount = $vndAmount / 24000; // Approximate VND to USD
        return number_format($usdAmount, 2, '.', '');
    }

    /**
     * Convert USD back to VND
     */
    private function convertToVND($usdAmount): float
    {
        // Ensure we have a numeric value
        $usdAmount = is_numeric($usdAmount) ? (float)$usdAmount : 0;
        return $usdAmount * 24000; // Approximate USD to VND
    }

    /**
     * Refund a PayPal payment
     */
    public function refundPayment(string $paymentId): ?array
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Unable to get PayPal access token');
            }

            $response = $this->httpClient->post(
                "/v1/payments/payment/{$paymentId}/refund",
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'Authorization' => 'Bearer ' . $accessToken,
                    ],
                ]
            );

            $refund = json_decode($response->getBody(), true);

            Log::info('PayPal refund successful', [
                'payment_id' => $paymentId,
                'refund_id' => $refund['id'] ?? null,
            ]);

            return $refund;

        } catch (\Exception $e) {
            Log::error('PayPal refund failed', [
                'payment_id' => $paymentId,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Create PayPal payment for wallet deposit
     */
    public function createDepositPayment(\App\Models\Shop\WalletDeposit $deposit): ?array
    {
        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                throw new \Exception('Unable to get PayPal access token');
            }

            $totalUSD = $this->convertToUSD($deposit->amount);

            $paymentData = [
                'intent' => 'sale',
                'payer' => [
                    'payment_method' => 'paypal'
                ],
                'transactions' => [
                    [
                        'amount' => [
                            'total' => $totalUSD,
                            'currency' => config('paypal.currency', 'USD')
                        ],
                        'description' => "Nạp tiền vào ví - " . number_format($deposit->amount) . " VND",
                        'invoice_number' => "DEPOSIT-{$deposit->id}"
                    ]
                ],
                'redirect_urls' => [
                    'return_url' => route('wallet.deposit.paypal.success', $deposit->id),
                    'cancel_url' => route('wallet.deposit.paypal.cancel', $deposit->id)
                ]
            ];

            Log::info('Creating PayPal deposit payment', [
                'deposit_id' => $deposit->id,
                'amount_vnd' => $deposit->amount,
                'amount_usd' => $totalUSD
            ]);

            $response = $this->httpClient->post('/v1/payments/payment', [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Authorization' => 'Bearer ' . $accessToken,
                ],
                'json' => $paymentData
            ]);

            $payment = json_decode($response->getBody(), true);

            Log::info('PayPal deposit payment created successfully', [
                'deposit_id' => $deposit->id,
                'payment_id' => $payment['id'] ?? null,
            ]);

            return $payment;

        } catch (\Exception $e) {
            Log::error('PayPal deposit payment creation failed', [
                'deposit_id' => $deposit->id,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Verify payment webhook
     */
    public function verifyWebhook(array $headers, string $payload): bool
    {
        // Implement PayPal webhook verification
        // This is important for security
        return true; // Placeholder
    }
}
