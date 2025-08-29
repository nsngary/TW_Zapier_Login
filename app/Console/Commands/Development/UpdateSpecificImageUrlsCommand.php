<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateSpecificImageUrlsCommand extends Command
{
    protected $signature = 'products:update-specific-images';
    protected $description = '為使用備用圖片的 70 個應用程式更新專屬圖片 URL';

    public function handle()
    {
        $this->info('🔧 開始為使用備用圖片的應用程式更新專屬圖片 URL...');
        
        // 備用圖片 URL
        $backupImageUrl = 'https://zapier-images.imgix.net/storage/services/6aafbb717d42f8b42f5be2e4e89e1a15.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300';
        
        // 定義專屬圖片 URL 映射
        $specificImageUrls = [
            // Microsoft 系列
            9 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Excel (使用 Google Sheets 的圖片作為替代)
            12 => 'https://zapier-images.imgix.net/storage/services/1afcb319c029ec5da10efb593b7159c8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Outlook (使用 Gmail 的圖片作為替代)
            13 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Teams (使用 Slack 的圖片作為替代)
            45 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Teams (重複)
            89 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Word
            90 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft PowerPoint
            
            // Google 系列
            19 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google 表單
            24 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google 雲端硬碟
            39 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google Analytics
            80 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Google Classroom
            
            // AI 工具
            33 => 'https://zapier-images.imgix.net/storage/services/9f47fd7646c5528b9958da1a86893a05.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // OpenAI GPT-4 (使用 ChatGPT 圖片)
            34 => 'https://zapier-images.imgix.net/storage/services/9f47fd7646c5528b9958da1a86893a05.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Anthropic Claude 3 (使用 ChatGPT 圖片)
            35 => 'https://zapier-images.imgix.net/storage/services/9f47fd7646c5528b9958da1a86893a05.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Midjourney
            36 => 'https://zapier-images.imgix.net/storage/services/9f47fd7646c5528b9958da1a86893a05.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Jasper AI
            
            // 商業智慧
            37 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Tableau
            38 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Power BI
            40 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Mixpanel
            
            // 電商平台
            42 => 'https://zapier-images.imgix.net/storage/services/4da9d3e3f93cd522f85e1b0695341f89.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // WooCommerce (使用 Shopify 圖片)
            43 => 'https://zapier-images.imgix.net/storage/services/4da9d3e3f93cd522f85e1b0695341f89.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Stripe
            44 => 'https://zapier-images.imgix.net/storage/services/4da9d3e3f93cd522f85e1b0695341f89.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // PayPal
            
            // 溝通工具
            46 => 'https://zapier-images.imgix.net/storage/services/ad3d7962908c17bcbe753928e8786b4a.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Discord
            47 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Zoom (使用 Slack 圖片)
            48 => 'https://zapier-images.imgix.net/storage/developer_cli/59411e9e3f7bb215378a4fc5b2d653af.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // WhatsApp Business
            
            // 專案管理
            49 => 'https://zapier-images.imgix.net/storage/services/d208a8b5b9b2b7b8b8b8b8b8b8b8b8b8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Trello
            50 => 'https://zapier-images.imgix.net/storage/services/b19117604393526d300c8a75f47f9cad.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Monday.com
            52 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Airtable
            64 => 'https://zapier-images.imgix.net/storage/services/000c15b838d86d80869cff5938fa76f3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Jira (使用 ClickUp 圖片)
            65 => 'https://zapier-images.imgix.net/storage/services/000c15b838d86d80869cff5938fa76f3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Basecamp
            
            // 其他重要應用程式
            23 => 'https://zapier-images.imgix.net/storage/services/f407c31b217aac6e0cd4171092d53a8c_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Instagram 商業版 (使用 Facebook 圖片)
            29 => 'https://zapier-images.imgix.net/storage/services/c7ed9691c53b602419408c5eba12dd58.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Zapier Webhooks (使用 Zapier Interfaces 圖片)
            32 => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Intercom (使用 Zendesk 圖片)
            60 => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Intercom (重複)

            // 第二批 - 剩餘的 38 個應用程式
            55 => 'https://zapier-images.imgix.net/storage/services/1a4435539b4764e6ded3d368cabab387.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Zoho CRM (使用 Salesforce 圖片)
            57 => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Buffer (使用 Mailchimp 圖片)
            58 => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Hootsuite
            61 => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Freshdesk (使用 Zendesk 圖片)
            62 => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Dropbox
            63 => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Box (使用 Dropbox 圖片)
            67 => 'https://zapier-images.imgix.net/storage/services/469ac865c30640b422480397b4c1f001.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Xero (使用 QuickBooks 圖片)
            68 => 'https://zapier-images.imgix.net/storage/services/cde9764aa8d19fdd6d591455dbe5a78d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // BambooHR (使用 HubSpot 圖片)
            69 => 'https://zapier-images.imgix.net/storage/services/e6c82d55e682fbb6f94fa5bd9d5026d3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // GitHub
            70 => 'https://zapier-images.imgix.net/storage/services/e6c82d55e682fbb6f94fa5bd9d5026d3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // GitLab (使用 GitHub 圖片)
            71 => 'https://zapier-images.imgix.net/storage/services/e6c82d55e682fbb6f94fa5bd9d5026d3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Docker
            72 => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // WordPress (使用 Notion 圖片)
            73 => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Webflow
            74 => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Squarespace
            75 => 'https://zapier-images.imgix.net/storage/services/c7ed9691c53b602419408c5eba12dd58.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // IFTTT (使用 Zapier Interfaces 圖片)
            76 => 'https://zapier-images.imgix.net/storage/services/c7ed9691c53b602419408c5eba12dd58.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // SmartThings
            77 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Spotify (使用 Canva 圖片)
            78 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Netflix
            79 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Strava
            81 => 'https://zapier-images.imgix.net/storage/services/5e4971d60629bca0548ded987b9ddc06.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Coursera (使用 Google Calendar 圖片)
            82 => 'https://zapier-images.imgix.net/storage/services/5e4971d60629bca0548ded987b9ddc06.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Khan Academy
            83 => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // 1Password (使用 Zendesk 圖片)
            84 => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // LastPass
            85 => 'https://zapier-images.imgix.net/storage/services/e6c82d55e682fbb6f94fa5bd9d5026d3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // MongoDB (使用 GitHub 圖片)
            86 => 'https://zapier-images.imgix.net/storage/services/e6c82d55e682fbb6f94fa5bd9d5026d3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // PostgreSQL
            87 => 'https://zapier-images.imgix.net/storage/services/e6c82d55e682fbb6f94fa5bd9d5026d3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Redis
            88 => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Microsoft Excel (重複)
            91 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Adobe Photoshop (使用 Canva 圖片)
            92 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Adobe Illustrator
            93 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Figma
            94 => 'https://zapier-images.imgix.net/storage/services/8102f502fb446273b80f08ce98a6c527.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Sketch
            95 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Twilio (使用 Slack 圖片)
            96 => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // SendGrid (使用 Mailchimp 圖片)
            97 => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // ConvertKit
            98 => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // ActiveCampaign
            99 => 'https://zapier-images.imgix.net/storage/services/000c15b838d86d80869cff5938fa76f3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Linear (使用 ClickUp 圖片)
            100 => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Loom (使用 Slack 圖片)
            101 => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300', // Miro (使用 Notion 圖片)
        ];
        
        $updatedCount = 0;
        $totalToUpdate = count($specificImageUrls);
        
        DB::beginTransaction();
        
        try {
            foreach ($specificImageUrls as $productId => $newImageUrl) {
                $product = DB::table('products')->where('id', $productId)->first();
                
                if (!$product) {
                    $this->warn("⚠️  找不到 ID {$productId} 的產品");
                    continue;
                }
                
                $currentImages = json_decode($product->images, true) ?: [];
                $currentImageUrl = $currentImages[0] ?? '';
                
                // 檢查是否使用備用圖片
                if ($currentImageUrl === $backupImageUrl) {
                    $currentImages[0] = $newImageUrl;
                    
                    DB::table('products')
                        ->where('id', $productId)
                        ->update(['images' => json_encode($currentImages)]);
                    
                    $this->line("✅ 更新 ID {$productId}: {$product->name}");
                    $this->line("   新圖片: {$newImageUrl}");
                    $this->line("");
                    
                    $updatedCount++;
                } else {
                    $this->info("⏭️  跳過 ID {$productId}: {$product->name} (不是備用圖片)");
                }
            }
            
            DB::commit();
            
            $this->info("\n🎉 專屬圖片更新完成！");
            $this->info("📊 成功更新: {$updatedCount} 個產品");
            $this->info("📊 計劃更新: {$totalToUpdate} 個產品");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ 更新失敗: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
