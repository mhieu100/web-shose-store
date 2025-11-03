<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use App\Models\Shop\Product;
use App\Models\Shop\Category;
use App\Models\Shop\Brand;

class GeminiChatService
{
    private Client $client;
    private string $apiKey;
    private string $apiUrl;

    public function __construct()
    {
        $this->client = new Client();
        $this->apiKey = config('gemini.api_key');
        $this->apiUrl = config('gemini.api_url');
    }

    /**
     * Generate AI response for customer queries
     */
    public function generateResponse(string $message, array $context = []): array
    {
        try {
            $systemPrompt = $this->buildSystemPrompt();
            $userMessage = $this->enhanceUserMessage($message, $context);

            $response = $this->client->post($this->apiUrl . '?key=' . $this->apiKey, [
                'json' => [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $systemPrompt . "\n\nUser: " . $userMessage]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => config('gemini.temperature', 0.7),
                        'maxOutputTokens' => config('gemini.max_tokens', 1000),
                    ]
                ],
                'headers' => [
                    'Content-Type' => 'application/json',
                ]
            ]);

            $data = json_decode($response->getBody(), true);
            
            if (isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                $aiResponse = $data['candidates'][0]['content']['parts'][0]['text'];
                return [
                    'success' => true,
                    'message' => $aiResponse,
                    'suggestions' => $this->extractSuggestions($aiResponse)
                ];
            }

            return [
                'success' => false,
                'message' => 'Xin lỗi, tôi không thể trả lời câu hỏi này lúc này. Vui lòng thử lại sau.',
                'suggestions' => []
            ];

        } catch (RequestException $e) {
            Log::error('Gemini API Error: ' . $e->getMessage());
            
            return [
                'success' => false,
                'message' => 'Xin lỗi, hệ thống đang bận. Vui lòng thử lại sau hoặc liên hệ với chúng tôi qua số hotline.',
                'suggestions' => $this->getFallbackSuggestions()
            ];
        }
    }

    /**
     * Build system prompt for the AI assistant
     */
    private function buildSystemPrompt(): string
    {
        $storeInfo = $this->getStoreInformation();
        
        return "Bạn là trợ lý AI thông minh của cửa hàng giày online. Nhiệm vụ của bạn là hỗ trợ khách hàng mua sắm một cách tốt nhất.

THÔNG TIN CỬA HÀNG:
{$storeInfo}

NGUYÊN TẮC HOẠT ĐỘNG:
1. Luôn thân thiện, nhiệt tình và chuyên nghiệp
2. Trả lời bằng tiếng Việt tự nhiên, dễ hiểu
3. Tập trung vào việc giúp khách hàng tìm được sản phẩm phù hợp
4. Đưa ra gợi ý cụ thể về sản phẩm khi có thể
5. Hướng dẫn khách hàng qua các bước mua hàng
6. Cung cấp thông tin chính xác về sản phẩm, giá cả, khuyến mãi
7. Nếu không biết thông tin, hãy thành thật và gợi ý liên hệ trực tiếp

CHỨC NĂNG CHÍNH:
- Tư vấn sản phẩm dựa trên nhu cầu khách hàng
- Giải đáp thắc mắc về sản phẩm, giá cả, khuyến mãi
- Hướng dẫn quy trình đặt hàng, thanh toán, giao hàng
- Hỗ trợ tìm kiếm sản phẩm phù hợp
- Giới thiệu các sản phẩm mới, bán chạy

Hãy trả lời một cách ngắn gọn, súc tích nhưng đầy đủ thông tin. Luôn kết thúc bằng câu hỏi để tiếp tục hỗ trợ khách hàng.";
    }

    /**
     * Get store information for context
     */
    private function getStoreInformation(): string
    {
        $productCount = Product::where('is_visible', true)->count();
        $categoryCount = Category::count();
        $brandCount = Brand::count();
        
        $categories = Category::take(10)->pluck('name')->implode(', ');
        $brands = Brand::take(10)->pluck('name')->implode(', ');
        
        $featuredProducts = Product::where('featured', true)
            ->where('is_visible', true)
            ->take(5)
            ->get()
            ->map(function($product) {
                return "- {$product->name} (₫" . number_format($product->price) . ")";
            })
            ->implode("\n");

        return "
- Tên cửa hàng: Shoe Store
- Chuyên kinh doanh: Giày dép các loại
- Số lượng sản phẩm: {$productCount} sản phẩm
- Số danh mục: {$categoryCount} danh mục
- Số thương hiệu: {$brandCount} thương hiệu

DANH MỤC CHÍNH: {$categories}
THƯƠNG HIỆU: {$brands}

SÃN PHẨM NỔI BẬT:
{$featuredProducts}

CHÍNH SÁCH:
- Miễn phí giao hàng cho đơn từ 500.000đ
- Đổi trả trong 7 ngày
- Bảo hành sản phẩm theo quy định
- Thanh toán: COD, PayPal, Ví điện tử";
    }

    /**
     * Enhance user message with context
     */
    private function enhanceUserMessage(string $message, array $context): string
    {
        $enhanced = $message;
        
        if (isset($context['current_product'])) {
            $product = Product::find($context['current_product']);
            if ($product) {
                $enhanced .= "\n\n[Khách hàng đang xem sản phẩm: {$product->name} - ₫" . number_format($product->price) . "]";
            }
        }

        if (isset($context['current_category'])) {
            $category = Category::find($context['current_category']);
            if ($category) {
                $enhanced .= "\n\n[Khách hàng đang duyệt danh mục: {$category->name}]";
            }
        }

        if (isset($context['cart_items']) && count($context['cart_items']) > 0) {
            $enhanced .= "\n\n[Khách hàng có " . count($context['cart_items']) . " sản phẩm trong giỏ hàng]";
        }

        return $enhanced;
    }

    /**
     * Extract suggestions from AI response
     */
    private function extractSuggestions(string $response): array
    {
        $suggestions = [];
        
        // Common product-related suggestions
        if (stripos($response, 'sản phẩm') !== false) {
            $suggestions[] = 'Xem sản phẩm tương tự';
            $suggestions[] = 'So sánh giá cả';
        }
        
        if (stripos($response, 'size') !== false || stripos($response, 'kích cỡ') !== false) {
            $suggestions[] = 'Hướng dẫn chọn size';
            $suggestions[] = 'Bảng size chi tiết';
        }
        
        if (stripos($response, 'giao hàng') !== false) {
            $suggestions[] = 'Thời gian giao hàng';
            $suggestions[] = 'Phí vận chuyển';
        }
        
        return array_slice($suggestions, 0, 3); // Limit to 3 suggestions
    }

    /**
     * Get fallback suggestions when AI fails
     */
    private function getFallbackSuggestions(): array
    {
        return [
            'Xem sản phẩm bán chạy',
            'Tìm hiểu khuyến mãi',
            'Liên hệ tư vấn viên'
        ];
    }

    /**
     * Get product recommendations based on query
     */
    public function getProductRecommendations(string $query, int $limit = 4): array
    {
        // Simple keyword-based search for recommendations
        $products = Product::where('is_visible', true)
            ->where(function($q) use ($query) {
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->take($limit)
            ->get();

        if ($products->isEmpty()) {
            // Fallback to featured products
            $products = Product::where('featured', true)
                ->where('is_visible', true)
                ->take($limit)
                ->get();
        }

        return $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'image' => $product->getFirstMediaUrl('product-images'),
                'url' => route('product.show', $product->id)
            ];
        })->toArray();
    }
}