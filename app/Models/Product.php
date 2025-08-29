<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'detail',
        'price',
        'stock',
        'category',
        'sku',
        'status',
        'images',
        'attributes',
        'created_by',
        'updated_by'
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'images' => 'array',
        'attributes' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * 範圍查詢：只顯示啟用的產品
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * 範圍查詢：依名稱搜尋
     */
    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'LIKE', "%{$name}%");
    }

    /**
     * 範圍查詢：依分類篩選
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * 範圍查詢：依狀態篩選
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * 範圍查詢：有庫存的產品
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * 取得產品簡介（限制字數）
     */
    public function getShortDescriptionAttribute($length = 100)
    {
        return mb_substr($this->description, 0, $length, "utf-8");
    }

    /**
     * 取得主要圖片
     */
    public function getMainImageAttribute()
    {
        $images = $this->images;
        if (!$images || count($images) === 0) {
            return null;
        }

        $firstImage = $images[0];

        // 如果是完整的 URL，直接返回
        if (str_starts_with($firstImage, 'http://') || str_starts_with($firstImage, 'https://')) {
            return $firstImage;
        }

        // 如果是相對路徑，使用 asset() 函數
        return asset($firstImage);
    }

    /**
     * 取得處理過的圖片陣列
     */
    public function getProcessedImagesAttribute()
    {
        $images = $this->images;
        if (!$images || count($images) === 0) {
            return [];
        }

        return array_map(function($image) {
            // 如果是完整的 URL，直接返回
            if (str_starts_with($image, 'http://') || str_starts_with($image, 'https://')) {
                return $image;
            }

            // 如果是相對路徑，使用 asset() 函數
            return asset($image);
        }, $images);
    }

    /**
     * 取得格式化價格
     */
    public function getFormattedPriceAttribute()
    {
        return '$' . number_format($this->price, 2);
    }

    /**
     * 取得庫存狀態
     */
    public function getStockStatusAttribute()
    {
        if ($this->stock <= 0) {
            return 'out_of_stock';
        } elseif ($this->stock <= 10) {
            return 'low_stock';
        } else {
            return 'in_stock';
        }
    }

    /**
     * 取得狀態標籤
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'active' => '啟用',
            'inactive' => '停用',
            'discontinued' => '停產'
        ];

        return $labels[$this->status] ?? $this->status;
    }
}
