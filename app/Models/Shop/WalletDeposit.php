<?php

namespace App\Models\Shop;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WalletDeposit extends Model
{
    protected $table = 'wallet_deposits';

    protected $fillable = [
        'user_id',
        'amount',
        'payment_method',
        'status',
        'transaction_reference',
        'transfer_proof',
        'payment_data',
        'submitted_at',
        'verified_at',
        'verified_by',
        'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_data' => 'array',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifiedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    /**
     * Check if deposit is pending
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Check if deposit is completed
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Mark deposit as completed and add funds to wallet
     */
    public function markAsCompleted(User $verifier = null): void
    {
        $this->update([
            'status' => 'completed',
            'verified_at' => now(),
            'verified_by' => $verifier?->id,
        ]);
    }
}
