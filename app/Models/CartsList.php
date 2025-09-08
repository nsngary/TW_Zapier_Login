<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartsList extends Model
{
    use HasFactory;

    protected $table = 'carts_list';

    protected $fillable = [
        'order_number',
        'user_id',
        'product_data',
        'total_amount',
        'status'
    ];

    protected $casts = [
        'product_data' => 'array',
        'total_amount' => 'decimal:2',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 關聯到使用者
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * 範圍查詢：依使用者篩選
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * 範圍查詢：依狀態篩選
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * 範圍查詢：已完成的訂單
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * 生成訂單編號
     */
    public static function generateOrderNumber()
    {
        $prefix = 'TW';
        $timestamp = now()->format('YmdHis');
        $random = str_pad(mt_rand(1, 9999), 4, '0', STR_PAD_LEFT);

        return "{$prefix}{$timestamp}{$random}";
    }

    /**
     * 取得格式化的總金額
     */
    public function getFormattedTotalAmountAttribute()
    {
        return '$' . number_format((float) $this->total_amount, 2);
    }
}
