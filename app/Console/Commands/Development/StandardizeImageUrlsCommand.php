<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StandardizeImageUrlsCommand extends Command
{
    protected $signature = 'products:standardize-image-urls';
    protected $description = '將所有產品圖片 URL 標準化為 ChatGPT 的格式 (h=300&w=300)';

    public function handle()
    {
        $this->info('🔧 開始標準化所有產品圖片 URL...');
        
        // 獲取 ChatGPT 的圖片 URL 作為範本
        $chatgptProduct = DB::table('products')->where('id', 27)->first();
        if (!$chatgptProduct) {
            $this->error('找不到 ChatGPT 產品 (ID: 27)');
            return 1;
        }
        
        $chatgptImages = json_decode($chatgptProduct->images, true);
        $templateUrl = $chatgptImages[0];
        
        $this->info("範本 URL: {$templateUrl}");
        $this->info("標準格式: ?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300");
        
        $products = DB::table('products')->select('id', 'name', 'images')->orderBy('id')->get();
        $updatedCount = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($products as $product) {
                $images = json_decode($product->images, true) ?: [];
                
                if (empty($images)) {
                    continue;
                }
                
                $currentUrl = $images[0];
                $standardizedUrl = $this->standardizeImageUrl($currentUrl);
                
                // 檢查是否需要更新
                if ($currentUrl !== $standardizedUrl) {
                    $images[0] = $standardizedUrl;
                    
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['images' => json_encode($images)]);
                    
                    $this->line("✅ 更新 ID {$product->id}: {$product->name}");
                    $this->line("   舊: {$currentUrl}");
                    $this->line("   新: {$standardizedUrl}");
                    $this->line("");
                    
                    $updatedCount++;
                } else {
                    $this->info("⏭️  跳過 ID {$product->id}: {$product->name} (已是標準格式)");
                }
            }
            
            DB::commit();
            
            $this->info("\n🎉 圖片 URL 標準化完成！");
            $this->info("📊 總共更新: {$updatedCount} 個產品");
            $this->info("📊 跳過: " . ($products->count() - $updatedCount) . " 個產品 (已是標準格式)");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ 標準化失敗: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    /**
     * 標準化圖片 URL 格式
     */
    private function standardizeImageUrl($url)
    {
        // 如果不是 zapier-images.imgix.net 的 URL，保持不變
        if (strpos($url, 'zapier-images.imgix.net') === false) {
            return $url;
        }
        
        // 解析 URL
        $parsedUrl = parse_url($url);
        if (!$parsedUrl) {
            return $url;
        }
        
        // 獲取基礎 URL (不含查詢參數)
        $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
        
        // 設定標準查詢參數 (與 ChatGPT 相同)
        $standardParams = [
            'auto' => 'format',
            'ixlib' => 'react-9.10.0',
            'q' => '50',
            'fit' => 'crop',
            'h' => '300',
            'w' => '300'
        ];
        
        // 重建標準化的 URL
        $queryString = http_build_query($standardParams);
        return $baseUrl . '?' . $queryString;
    }
}
