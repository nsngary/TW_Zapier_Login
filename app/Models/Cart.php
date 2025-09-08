<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    protected $casts = [
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
     * 關聯到產品
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * 範圍查詢：依使用者篩選
     */
    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * 範圍查詢：包含產品資訊
     */
    public function scopeWithProduct($query)
    {
        return $query->with(['product' => function($query) {
            $query->where('status', 'active');
        }]);
    }
}
