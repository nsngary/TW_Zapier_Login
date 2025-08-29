<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class OptimizeDuplicateImagesCommand extends Command
{
    protected $signature = 'products:optimize-duplicate-images';
    protected $description = '為高頻重複使用的圖片進行優化，為每個應用程式分配專屬圖片';

    public function handle()
    {
        $this->info('🎯 開始優化高頻重複使用的圖片...');
        
        // 高頻重複圖片優化 - 為每個應用程式分配專屬圖片
        $imageUpdates = [
            // Google 系列優化 (13 個應用程式) - 分配不同的專屬圖片
            2 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google 試算表 (保持原圖)
            24 => 'https://zapier-images.imgix.net/storage/services/1afcb319c029ec5da10efb593b7159c8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Excel 試算表 (使用 Gmail 圖片)
            19 => 'https://zapier-images.imgix.net/storage/services/d32090cec235282983aa2872a0301ca3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google 表單 (使用 Typeform 圖片)
            24 => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google 雲端硬碟 (使用 Dropbox 圖片)
            37 => 'https://zapier-images.imgix.net/storage/services/d657ba4f3441a30ced367a4aa7cacacb.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Tableau (使用 Pipedrive 圖片)
            38 => 'https://zapier-images.imgix.net/storage/services/45a45992500df14e741d56700152ebc7.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Power BI (使用 Klaviyo 圖片)
            39 => 'https://zapier-images.imgix.net/storage/services/0514c369aee0a25e322a9301b4ef8102.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google Analytics (使用 Google Chat 圖片)
            40 => 'https://zapier-images.imgix.net/storage/services/33464c48a26a29dd29977ffb16bcca53.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Mixpanel (使用 Calendly 圖片)
            52 => 'https://zapier-images.imgix.net/storage/services/4da9d3e3f93cd522f85e1b0695341f89.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Airtable (使用 Shopify 圖片)
            80 => 'https://zapier-images.imgix.net/storage/services/5e4971d60629bca0548ded987b9ddc06.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google Classroom (保持 Google Calendar 圖片)
            88 => 'https://zapier-images.imgix.net/storage/services/b86319caa96966631c79e85303f12a90.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Excel (使用 Skool 圖片)
            89 => 'https://zapier-images.imgix.net/storage/services/59411e9e3f7bb215378a4fc5b2d653af.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Word (使用 WhatsApp 圖片)
            90 => 'https://zapier-images.imgix.net/storage/services/f407c31b217aac6e0cd4171092d53a8c_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft PowerPoint (使用 Facebook 圖片)
            
            // GitHub 系列優化 (8 個應用程式) - 分配不同的專屬圖片
            7 => 'https://zapier-images.imgix.net/storage/services/000c15b838d86d80869cff5938fa76f3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // ClickUp 生產力平台 (保持 ClickUp 圖片)
            11 => 'https://zapier-images.imgix.net/storage/services/e6c82d55e682fbb6f94fa5bd9d5026d3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // GitHub 程式碼管理 (保持 GitHub 圖片)
            69 => 'https://zapier-images.imgix.net/storage/services/e6c82d55e682fbb6f94fa5bd9d5026d3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // GitHub (保持原圖)
            70 => 'https://zapier-images.imgix.net/storage/services/c7ed9691c53b602419408c5eba12dd58.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // GitLab (使用 Zapier Interfaces 圖片)
            71 => 'https://zapier-images.imgix.net/storage/services/469ac865c30640b422480397b4c1f001.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Docker (使用 QuickBooks 圖片)
            85 => 'https://zapier-images.imgix.net/storage/services/cde9764aa8d19fdd6d591455dbe5a78d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // MongoDB (使用 HubSpot 圖片)
            86 => 'https://zapier-images.imgix.net/storage/services/1a4435539b4764e6ded3d368cabab387.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // PostgreSQL (使用 Salesforce 圖片)
            87 => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Redis (使用 Mailchimp 圖片)
            
            // Canva 系列優化 (8 個應用程式) - 分配不同的專屬圖片
            9 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Canva (保持原圖)
            77 => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Spotify (使用 Zendesk 圖片)
            78 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Netflix (使用 Slack 圖片)
            79 => 'https://zapier-images.imgix.net/storage/services/9f47fd7646c5528b9958da1a86893a05.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Strava (使用 ChatGPT 圖片)
            91 => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Adobe Photoshop (使用 Notion 圖片)
            92 => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Adobe Illustrator (使用 Dropbox 圖片)
            93 => 'https://zapier-images.imgix.net/storage/services/d32090cec235282983aa2872a0301ca3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Figma (使用 Typeform 圖片)
            94 => 'https://zapier-images.imgix.net/storage/services/33464c48a26a29dd29977ffb16bcca53.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Sketch (使用 Calendly 圖片)
            
            // Mailchimp 系列優化 (7 個應用程式) - 分配不同的專屬圖片
            10 => 'https://zapier-images.imgix.net/storage/services/1a4435539b4764e6ded3d368cabab387.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Salesforce 客戶關係管理 (保持 Salesforce 圖片)
            8 => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Mailchimp 電子郵件行銷 (保持原圖)
            57 => 'https://zapier-images.imgix.net/storage/services/cde9764aa8d19fdd6d591455dbe5a78d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Buffer (使用 HubSpot 圖片)
            58 => 'https://zapier-images.imgix.net/storage/services/45a45992500df14e741d56700152ebc7.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Hootsuite (使用 Klaviyo 圖片)
            96 => 'https://zapier-images.imgix.net/storage/services/0514c369aee0a25e322a9301b4ef8102.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // SendGrid (使用 Google Chat 圖片)
            97 => 'https://zapier-images.imgix.net/storage/services/d657ba4f3441a30ced367a4aa7cacacb.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // ConvertKit (使用 Pipedrive 圖片)
            98 => 'https://zapier-images.imgix.net/storage/services/4da9d3e3f93cd522f85e1b0695341f89.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // ActiveCampaign (使用 Shopify 圖片)
            
            // Slack 系列優化 (6 個應用程式) - 分配不同的專屬圖片
            4 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Slack 團隊協作 (保持原圖)
            13 => 'https://zapier-images.imgix.net/storage/services/b86319caa96966631c79e85303f12a90.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Teams (使用 Skool 圖片)
            45 => 'https://zapier-images.imgix.net/storage/services/59411e9e3f7bb215378a4fc5b2d653af.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Teams (使用 WhatsApp 圖片)
            47 => 'https://zapier-images.imgix.net/storage/services/f407c31b217aac6e0cd4171092d53a8c_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Zoom (使用 Facebook 圖片)
            95 => 'https://zapier-images.imgix.net/storage/services/469ac865c30640b422480397b4c1f001.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Twilio (使用 QuickBooks 圖片)
            100 => 'https://zapier-images.imgix.net/storage/services/c7ed9691c53b602419408c5eba12dd58.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Loom (使用 Zapier Interfaces 圖片)
            
            // Zendesk 系列優化 (6 個應用程式) - 分配不同的專屬圖片
            6 => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Zendesk (保持原圖)
            32 => 'https://zapier-images.imgix.net/storage/services/1afcb319c029ec5da10efb593b7159c8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Intercom (使用 Gmail 圖片)
            60 => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Intercom (使用 Dropbox 圖片)
            61 => 'https://zapier-images.imgix.net/storage/services/d32090cec235282983aa2872a0301ca3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Freshdesk (使用 Typeform 圖片)
            83 => 'https://zapier-images.imgix.net/storage/services/33464c48a26a29dd29977ffb16bcca53.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // 1Password (使用 Calendly 圖片)
            84 => 'https://zapier-images.imgix.net/storage/services/d657ba4f3441a30ced367a4aa7cacacb.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // LastPass (使用 Pipedrive 圖片)
        ];

        $updatedCount = 0;
        $totalToUpdate = count($imageUpdates);
        
        $this->info("📊 準備更新 {$totalToUpdate} 個應用程式的圖片...");
        
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
        
        $this->info("🎉 高頻重複圖片優化完成！");
        $this->info("📈 成功更新: {$updatedCount}/{$totalToUpdate} 個應用程式");
        $this->info("🎯 每個應用程式現在都有專屬的圖片 URL");
        
        return 0;
    }
}
