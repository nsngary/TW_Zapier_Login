<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;

    protected $table = 'product_img';
    protected $primaryKey = 'img_id';
    
    protected $fillable = [
        'p_id',
        'img_file',
        'sort'
    ];

    protected $casts = [
        'sort' => 'integer'
    ];

    /**
     * 關聯到產品
     */
    public function product()
    {
        return $this->belongsTo(Product::class, 'p_id', 'p_id');
    }

    /**
     * 範圍查詢：主要圖片
     */
    public function scopeMain($query)
    {
        return $query->where('sort', 1);
    }

    /**
     * 取得圖片完整路徑
     */
    public function getImageUrlAttribute()
    {
        return asset('product_img/' . $this->img_file);
    }
}
