<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ValidateImageUrlsCommand extends Command
{
    protected $signature = 'products:validate-image-urls';
    protected $description = '驗證產品圖片 URL 是否有效，並為無效的 URL 設置備用圖片';

    // 備用圖片 URL（使用通用的應用程式圖標）
    private $fallbackImageUrl = 'https://zapier-images.imgix.net/storage/services/6aafbb717d42f8b42f5be2e4e89e1a15.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300';

    public function handle()
    {
        $this->info('🔍 開始驗證產品圖片 URL...');
        
        $products = DB::table('products')->select('id', 'name', 'images')->get();
        $validCount = 0;
        $invalidCount = 0;
        $updatedCount = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($products as $product) {
                $images = json_decode($product->images, true) ?: [];
                
                if (empty($images)) {
                    continue;
                }
                
                $imageUrl = $images[0];
                $this->line("檢查 {$product->name}: {$imageUrl}");
                
                // 檢查圖片 URL 是否有效
                try {
                    $response = Http::timeout(10)->head($imageUrl);
                    
                    if ($response->successful()) {
                        $this->info("✅ {$product->name} - 圖片有效");
                        $validCount++;
                    } else {
                        $this->warn("❌ {$product->name} - 圖片無效 (HTTP {$response->status()})");
                        
                        // 使用備用圖片
                        $images[0] = $this->fallbackImageUrl;
                        DB::table('products')
                            ->where('id', $product->id)
                            ->update(['images' => json_encode($images)]);
                        
                        $invalidCount++;
                        $updatedCount++;
                        $this->info("🔄 已更新為備用圖片");
                    }
                } catch (\Exception $e) {
                    $this->error("❌ {$product->name} - 檢查失敗: " . $e->getMessage());
                    
                    // 使用備用圖片
                    $images[0] = $this->fallbackImageUrl;
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['images' => json_encode($images)]);
                    
                    $invalidCount++;
                    $updatedCount++;
                    $this->info("🔄 已更新為備用圖片");
                }
                
                // 避免請求過於頻繁
                usleep(200000); // 0.2 秒延遲
            }
            
            DB::commit();
            
            $this->info("\n🎉 圖片 URL 驗證完成！");
            $this->info("📊 有效圖片: {$validCount}");
            $this->info("📊 無效圖片: {$invalidCount}");
            $this->info("📊 已更新: {$updatedCount}");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ 驗證失敗: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
