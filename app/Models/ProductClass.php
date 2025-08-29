<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductClass extends Model
{
    use HasFactory;

    protected $table = 'pyclass';
    protected $primaryKey = 'classid';
    
    protected $fillable = [
        'cname',
        'uplink',
        'sort'
    ];

    protected $casts = [
        'uplink' => 'integer',
        'sort' => 'integer'
    ];

    /**
     * 關聯到產品
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'classid', 'classid');
    }

    /**
     * 關聯到父分類
     */
    public function parent()
    {
        return $this->belongsTo(ProductClass::class, 'uplink', 'classid');
    }

    /**
     * 關聯到子分類
     */
    public function children()
    {
        return $this->hasMany(ProductClass::class, 'uplink', 'classid');
    }

    /**
     * 範圍查詢：頂層分類
     */
    public function scopeTopLevel($query)
    {
        return $query->whereNull('uplink')->orWhere('uplink', 0);
    }

    /**
     * 範圍查詢：子分類
     */
    public function scopeChildren($query, $parentId)
    {
        return $query->where('uplink', $parentId);
    }
}
