<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommissionWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
        'withdrawal_code',
        'user_id',
        'amount',
        'fee',
        'net_amount',
        'status',
        'payment_method',
        'payment_info',
        'reason',
        'admin_notes',
        'requested_at',
        'approved_at',
        'completed_at',
        'approved_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'payment_info' => 'array',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Helpers
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Chờ duyệt',
            'approved' => 'Đã duyệt',
            'processing' => 'Đang xử lý',
            'completed' => 'Hoàn thành',
            'rejected' => 'Từ chối',
            default => 'Không xác định'
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'warning',
            'approved' => 'info',
            'processing' => 'primary',
            'completed' => 'success',
            'rejected' => 'danger',
            default => 'secondary'
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return match($this->payment_method) {
            'bank_transfer' => 'Chuyển khoản ngân hàng',
            'e_wallet' => 'Ví điện tử',
            'cash' => 'Tiền mặt',
            default => 'Không xác định'
        };
    }

    // Generate unique withdrawal code
    public static function generateWithdrawalCode(): string
    {
        do {
            $code = 'WD' . date('Ymd') . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('withdrawal_code', $code)->exists());
        
        return $code;
    }
}
