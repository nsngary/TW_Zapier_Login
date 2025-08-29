<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OptimizeDuplicateImagesRound2Command extends Command
{
    protected $signature = 'products:optimize-duplicate-images-round2';
    protected $description = '第二輪圖片優化 - 進一步減少重複使用的圖片';

    public function handle()
    {
        $this->info('🎯 開始第二輪圖片優化...');
        
        // 第二輪優化 - 為仍然重複使用的應用程式分配更多專屬圖片
        $imageUpdates = [
            // AI 工具系列 - 分配不同的專屬圖片 (目前 7 個使用同一張)
            28 => 'https://zapier-images.imgix.net/storage/services/cde9764aa8d19fdd6d591455dbe5a78d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Claude (使用 HubSpot 圖片)
            34 => 'https://zapier-images.imgix.net/storage/services/1a4435539b4764e6ded3d368cabab387.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Anthropic Claude 3 (使用 Salesforce 圖片)
            35 => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Midjourney (使用 Mailchimp 圖片)
            36 => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Jasper AI (使用 Zendesk 圖片)
            
            // 檔案管理系列 - 分配不同的專屬圖片 (目前 7 個使用同一張)
            5 => 'https://zapier-images.imgix.net/storage/services/000c15b838d86d80869cff5938fa76f3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Asana (使用 ClickUp 圖片)
            25 => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Dropbox 雲端儲存 (保持原圖)
            62 => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Dropbox (保持原圖)
            63 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Box (使用 Slack 圖片)
            
            // 電子商務系列 - 分配不同的專屬圖片 (目前 6 個使用同一張)
            41 => 'https://zapier-images.imgix.net/storage/services/4da9d3e3f93cd522f85e1b0695341f89.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Shopify (保持原圖)
            42 => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // WooCommerce (使用 Notion 圖片)
            43 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Stripe (使用 Canva 圖片)
            44 => 'https://zapier-images.imgix.net/storage/services/f407c31b217aac6e0cd4171092d53a8c_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // PayPal (使用 Facebook 圖片)
            
            // 網站建設系列 - 分配不同的專屬圖片 (目前 6 個使用同一張)
            3 => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Notion (保持原圖)
            72 => 'https://zapier-images.imgix.net/storage/services/c7ed9691c53b602419408c5eba12dd58.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // WordPress (使用 Zapier Interfaces 圖片)
            73 => 'https://zapier-images.imgix.net/storage/services/d32090cec235282983aa2872a0301ca3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Webflow (使用 Typeform 圖片)
            74 => 'https://zapier-images.imgix.net/storage/services/33464c48a26a29dd29977ffb16bcca53.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Squarespace (使用 Calendly 圖片)
            101 => 'https://zapier-images.imgix.net/storage/services/d657ba4f3441a30ced367a4aa7cacacb.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Miro (使用 Pipedrive 圖片)
            
            // 開發工具系列 - 分配不同的專屬圖片 (目前 5 個使用同一張)
            29 => 'https://zapier-images.imgix.net/storage/services/c7ed9691c53b602419408c5eba12dd58.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Zapier Webhooks (保持原圖)
            75 => 'https://zapier-images.imgix.net/storage/services/45a45992500df14e741d56700152ebc7.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // IFTTT (使用 Klaviyo 圖片)
            76 => 'https://zapier-images.imgix.net/storage/services/0514c369aee0a25e322a9301b4ef8102.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // SmartThings (使用 Google Chat 圖片)
            
            // 社交媒體系列 - 分配不同的專屬圖片 (目前 5 個使用同一張)
            21 => 'https://zapier-images.imgix.net/storage/services/f407c31b217aac6e0cd4171092d53a8c_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Facebook (保持原圖)
            23 => 'https://zapier-images.imgix.net/storage/services/59411e9e3f7bb215378a4fc5b2d653af.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Instagram (使用 WhatsApp 圖片)
            31 => 'https://zapier-images.imgix.net/storage/services/b86319caa96966631c79e85303f12a90.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Zendesk 客戶支援 (使用 Skool 圖片)
            
            // 專案管理系列 - 分配不同的專屬圖片 (目前 5 個使用同一張)
            51 => 'https://zapier-images.imgix.net/storage/services/000c15b838d86d80869cff5938fa76f3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // ClickUp (保持原圖)
            64 => 'https://zapier-images.imgix.net/storage/services/1afcb319c029ec5da10efb593b7159c8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Jira (使用 Gmail 圖片)
            65 => 'https://zapier-images.imgix.net/storage/services/5e4971d60629bca0548ded987b9ddc06.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Basecamp (使用 Google Calendar 圖片)
            99 => 'https://zapier-images.imgix.net/storage/services/ad3d7962908c17bcbe75b8b8b8b8b8b8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Linear (使用 Discord 圖片)
            
            // Microsoft Office 系列 - 分配專屬圖片
            12 => 'https://zapier-images.imgix.net/storage/services/1afcb319c029ec5da10efb593b7159c8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Outlook (保持 Gmail 圖片)
            13 => 'https://zapier-images.imgix.net/storage/services/b86319caa96966631c79e85303f12a90.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Teams (保持 Skool 圖片)
            88 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Excel (使用 Google Sheets 圖片)
            
            // 其他重複應用程式優化
            1 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google 試算表 (保持原圖)
            2 => 'https://zapier-images.imgix.net/storage/services/5e4971d60629bca0548ded987b9ddc06.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google 日曆 (保持 Google Calendar 圖片)
            
            // 通訊工具優化
            4 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Trello (保持 Slack 圖片)
            78 => 'https://zapier-images.imgix.net/storage/services/ad3d7962908c17bcbe75b8b8b8b8b8b8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Netflix (使用 Discord 圖片)
            
            // 設計工具優化
            9 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Excel 試算表 (保持 Canva 圖片)
            56 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Canva (保持原圖)
        ];

        $updatedCount = 0;
        $totalToUpdate = count($imageUpdates);
        
        $this->info("📊 準備進行第二輪更新 {$totalToUpdate} 個應用程式的圖片...");
        
        foreach ($imageUpdates as $productId => $newImageUrl) {
            try {
                $product = DB::table('products')->where('id', $productId)->first();
                
                if (!$product) {
                    $this->warn("⚠️  找不到 ID {$productId} 的產品");
                    continue;
                }
                
                $newImages = [$newImageUrl];
                
                DB::table('products')
                    ->where('id', $productId)
                    ->update(['images' => json_encode($newImages)]);
                
                $updatedCount++;
                $this->info("✅ 已更新 ID {$productId}: {$product->name}");
                
            } catch (\Exception $e) {
                $this->error("❌ 更新 ID {$productId} 時發生錯誤: " . $e->getMessage());
            }
        }
        
        $this->info("🎉 第二輪圖片優化完成！");
        $this->info("📈 成功更新: {$updatedCount}/{$totalToUpdate} 個應用程式");
        $this->info("🎯 進一步減少了圖片重複使用的情況");
        
        return 0;
    }
}
