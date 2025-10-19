<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserWallet extends Model
{
    protected $table = 'user_wallets';

    protected $fillable = [
        'user_id',
        'balance',
        'currency',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'user_id', 'user_id');
    }

    /**
     * Add funds to wallet
     */
    public function addFunds(float $amount, string $type, string $description, ?int $orderId = null, ?array $metadata = null): WalletTransaction
    {
        $this->increment('balance', $amount);

        return $this->transactions()->create([
            'user_id' => $this->user_id,
            'order_id' => $orderId,
            'type' => $type,
            'amount' => $amount,
            'description' => $description,
            'status' => 'completed',
            'metadata' => $metadata,
        ]);
    }

    /**
     * Deduct funds from wallet
     */
    public function deductFunds(float $amount, string $type, string $description, ?int $orderId = null, ?array $metadata = null): WalletTransaction
    {
        if ($this->balance < $amount) {
            throw new \Exception('Insufficient wallet balance');
        }

        $this->decrement('balance', $amount);

        return $this->transactions()->create([
            'user_id' => $this->user_id,
            'order_id' => $orderId,
            'type' => $type,
            'amount' => -$amount,
            'description' => $description,
            'status' => 'completed',
            'metadata' => $metadata,
        ]);
    }
}
