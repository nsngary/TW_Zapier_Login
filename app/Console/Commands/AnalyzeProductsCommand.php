<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class AnalyzeProductsCommand extends Command
{
    protected $signature = 'products:analyze';
    protected $description = '分析 products 資料表的當前狀態';

    public function handle()
    {
        $this->info('🔍 分析 products 資料表...');
        
        // 1. 總數統計
        $totalProducts = DB::table('products')->count();
        $this->info("📊 總產品數量: {$totalProducts}");
        
        // 2. 分類統計
        $this->info("\n📂 分類統計:");
        $categories = DB::table('products')
            ->select('category', DB::raw('COUNT(*) as count'))
            ->groupBy('category')
            ->orderBy('count', 'desc')
            ->get();
            
        foreach ($categories as $category) {
            $this->line("  • {$category->category}: {$category->count} 個產品");
        }
        
        // 3. 價格分析
        $this->info("\n💰 價格分析:");
        $priceStats = DB::table('products')
            ->selectRaw('
                COUNT(*) as total,
                COUNT(CASE WHEN price = 0 THEN 1 END) as free,
                COUNT(CASE WHEN price > 0 THEN 1 END) as paid,
                MIN(price) as min_price,
                MAX(price) as max_price,
                AVG(price) as avg_price
            ')
            ->first();
            
        $this->line("  • 免費產品: {$priceStats->free} 個");
        $this->line("  • 付費產品: {$priceStats->paid} 個");
        $this->line("  • 價格範圍: \${$priceStats->min_price} - \${$priceStats->max_price}");
        $this->line("  • 平均價格: \$" . number_format($priceStats->avg_price, 2));
        
        // 4. 評分分析
        if (DB::getSchemaBuilder()->hasColumn('products', 'rating')) {
            $this->info("\n⭐ 評分分析:");
            $ratingStats = DB::table('products')
                ->selectRaw('
                    COUNT(*) as total,
                    MIN(rating) as min_rating,
                    MAX(rating) as max_rating,
                    AVG(rating) as avg_rating
                ')
                ->first();
                
            $this->line("  • 評分範圍: {$ratingStats->min_rating} - {$ratingStats->max_rating}");
            $this->line("  • 平均評分: " . number_format($ratingStats->avg_rating, 1));
        }
        
        // 5. 檢查重複產品
        $this->info("\n🔍 檢查重複產品:");
        $duplicates = DB::table('products')
            ->select('name', DB::raw('COUNT(*) as count'))
            ->groupBy('name')
            ->having('count', '>', 1)
            ->get();
            
        if ($duplicates->count() > 0) {
            $this->warn("  發現 {$duplicates->count()} 個重複產品名稱:");
            foreach ($duplicates as $duplicate) {
                $this->line("    • {$duplicate->name}: {$duplicate->count} 筆記錄");
            }
        } else {
            $this->info("  ✅ 沒有發現重複產品");
        }
        
        // 6. 檢查圖片連結
        $this->info("\n🖼️  檢查圖片連結:");
        $imageStats = DB::table('products')
            ->selectRaw('
                COUNT(*) as total,
                COUNT(CASE WHEN images IS NULL OR images = "" OR images = "[]" THEN 1 END) as no_images,
                COUNT(CASE WHEN images IS NOT NULL AND images != "" AND images != "[]" THEN 1 END) as has_images
            ')
            ->first();
            
        $this->line("  • 有圖片: {$imageStats->has_images} 個產品");
        $this->line("  • 無圖片: {$imageStats->no_images} 個產品");
        
        // 7. 顯示所有產品清單
        $this->info("\n📋 產品清單:");
        $products = DB::table('products')
            ->select('id', 'name', 'category', 'price', 'rating')
            ->orderBy('category')
            ->orderBy('name')
            ->get();
            
        foreach ($products as $product) {
            $rating = $product->rating ?? 'N/A';
            $this->line("  {$product->id}. {$product->name} [{$product->category}] - \${$product->price} (⭐{$rating})");
        }
        
        $this->info("\n✅ 分析完成!");
        return 0;
    }
}
