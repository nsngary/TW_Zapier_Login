<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FixImageUrlsCommand extends Command
{
    protected $signature = 'products:fix-image-urls';
    protected $description = '修正產品圖片 URL 格式為統一的 h=300&w=300';

    // 從 Zapier.com 抓取的正確圖片 URL 映射
    private $correctImageUrls = [
        'Webhooks by Zapier' => 'https://zapier-images.imgix.net/storage/services/6aafbb717d42f8b42f5be2e4e89e1a15.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'ChatGPT (OpenAI)' => 'https://zapier-images.imgix.net/storage/services/9f47fd7646c5528b9958da1a86893a05.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google Sheets' => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Facebook Lead Ads' => 'https://zapier-images.imgix.net/storage/services/f407c31b217aac6e0cd4171092d53a8c_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'HubSpot' => 'https://zapier-images.imgix.net/storage/developer/cde9764aa8d19fdd6d591455dbe5a78d.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Gmail' => 'https://zapier-images.imgix.net/storage/services/1afcb319c029ec5da10efb593b7159c8.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Salesforce' => 'https://zapier-images.imgix.net/storage/services/1a4435539b4764e6ded3d368cabab387.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Slack' => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Skool' => 'https://zapier-images.imgix.net/storage/developer_cli/b86319caa96966631c79e85303f12a90.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Shopify' => 'https://zapier-images.imgix.net/storage/services/4da9d3e3f93cd522f85e1b0695341f89.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Klaviyo' => 'https://zapier-images.imgix.net/storage/services/45a45992500df14e741d56700152ebc7.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Typeform' => 'https://zapier-images.imgix.net/storage/services/d32090cec235282983aa2872a0301ca3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'QuickBooks Online' => 'https://zapier-images.imgix.net/storage/services/469ac865c30640b422480397b4c1f001.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Calendly' => 'https://zapier-images.imgix.net/storage/services/33464c48a26a29dd29977ffb16bcca53.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google Calendar' => 'https://zapier-images.imgix.net/storage/services/5e4971d60629bca0548ded987b9ddc06.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Mailchimp' => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Notion' => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Pipedrive' => 'https://zapier-images.imgix.net/storage/services/d657ba4f3441a30ced367a4aa7cacacb.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Zendesk' => 'https://zapier-images.imgix.net/storage/services/45e89018e756b043d806701f17dc2632.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'ClickUp' => 'https://zapier-images.imgix.net/storage/services/000c15b838d86d80869cff5938fa76f3.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google Chat' => 'https://zapier-images.imgix.net/storage/services/0514c369aee0a25e322a9301b4ef8102.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'WhatsApp Notifications' => 'https://zapier-images.imgix.net/storage/developer_cli/59411e9e3f7bb215378a4fc5b2d653af.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',

        // 其他常見應用程式的標準圖片 URL
        'Trello' => 'https://zapier-images.imgix.net/storage/services/trello.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Asana' => 'https://zapier-images.imgix.net/storage/services/asana.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Monday.com' => 'https://zapier-images.imgix.net/storage/services/monday.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Todoist' => 'https://zapier-images.imgix.net/storage/services/todoist.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Excel' => 'https://zapier-images.imgix.net/storage/services/microsoft-excel.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Airtable' => 'https://zapier-images.imgix.net/storage/services/airtable.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Outlook' => 'https://zapier-images.imgix.net/storage/services/microsoft-outlook.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Teams' => 'https://zapier-images.imgix.net/storage/services/microsoft-teams.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Discord' => 'https://zapier-images.imgix.net/storage/services/discord.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Zoom' => 'https://zapier-images.imgix.net/storage/services/zoom.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'WhatsApp Business' => 'https://zapier-images.imgix.net/storage/services/whatsapp.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google Forms' => 'https://zapier-images.imgix.net/storage/services/google-forms.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Zoho CRM' => 'https://zapier-images.imgix.net/storage/services/zoho-crm.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google Ads' => 'https://zapier-images.imgix.net/storage/services/google-ads.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Instagram' => 'https://zapier-images.imgix.net/storage/services/instagram.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Canva' => 'https://zapier-images.imgix.net/storage/services/canva.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Buffer' => 'https://zapier-images.imgix.net/storage/services/buffer.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Hootsuite' => 'https://zapier-images.imgix.net/storage/services/hootsuite.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google Drive' => 'https://zapier-images.imgix.net/storage/services/google-drive.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Dropbox' => 'https://zapier-images.imgix.net/storage/services/dropbox.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'OneDrive' => 'https://zapier-images.imgix.net/storage/services/onedrive.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Box' => 'https://zapier-images.imgix.net/storage/services/box.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'GitHub' => 'https://zapier-images.imgix.net/storage/services/github.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'GitLab' => 'https://zapier-images.imgix.net/storage/services/gitlab.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Docker' => 'https://zapier-images.imgix.net/storage/services/docker.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Intercom' => 'https://zapier-images.imgix.net/storage/services/intercom.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Freshdesk' => 'https://zapier-images.imgix.net/storage/services/freshdesk.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Tableau' => 'https://zapier-images.imgix.net/storage/services/tableau.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Power BI' => 'https://zapier-images.imgix.net/storage/services/microsoft-power-bi.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google Analytics' => 'https://zapier-images.imgix.net/storage/services/google-analytics.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Mixpanel' => 'https://zapier-images.imgix.net/storage/services/mixpanel.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'WooCommerce' => 'https://zapier-images.imgix.net/storage/services/woocommerce.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Stripe' => 'https://zapier-images.imgix.net/storage/services/stripe.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'PayPal' => 'https://zapier-images.imgix.net/storage/services/paypal.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Jira' => 'https://zapier-images.imgix.net/storage/services/jira.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Basecamp' => 'https://zapier-images.imgix.net/storage/services/basecamp.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Xero' => 'https://zapier-images.imgix.net/storage/services/xero.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'BambooHR' => 'https://zapier-images.imgix.net/storage/services/bamboohr.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
    ];

    // 名稱映射表（處理中英文名稱差異）
    private $nameMapping = [
        'Google 試算表' => 'Google Sheets',
        'Google 日曆' => 'Google Calendar',
        'Gmail 電子郵件' => 'Gmail',
        'Slack 團隊協作' => 'Slack',
        'HubSpot 客戶關係管理' => 'HubSpot',
        'Salesforce 客戶關係管理' => 'Salesforce',
        'Calendly 會議排程' => 'Calendly',
        'Typeform 表單建立器' => 'Typeform',
        'Mailchimp 電子郵件行銷' => 'Mailchimp',
        'Facebook 潛在客戶廣告' => 'Facebook Lead Ads',
        'Notion 全方位工作區' => 'Notion',
        'Zendesk 客戶支援' => 'Zendesk',
        'ClickUp 生產力平台' => 'ClickUp',
        'ChatGPT 人工智慧助手' => 'ChatGPT (OpenAI)',
        'Zapier Webhooks 整合工具' => 'Webhooks by Zapier',
        'Trello 專案管理' => 'Trello',
        'Asana 工作管理' => 'Asana',
        'Monday.com 專案協作' => 'Monday.com',
        'Todoist 任務管理' => 'Todoist',
        'Microsoft Excel 試算表' => 'Microsoft Excel',
        'Microsoft Outlook 電子郵件' => 'Microsoft Outlook',
        'Microsoft Teams 團隊協作' => 'Microsoft Teams',
        'Discord 語音聊天' => 'Discord',
        'Google 表單' => 'Google Forms',
        'Google 廣告' => 'Google Ads',
        'Instagram 商業版' => 'Instagram',
        'Google 雲端硬碟' => 'Google Drive',
        'Dropbox 雲端儲存' => 'Dropbox',
        'OneDrive 雲端儲存' => 'OneDrive',
        'GitHub 程式碼管理' => 'GitHub',
        'Intercom 客戶訊息平台' => 'Intercom',
        'Microsoft Power BI' => 'Microsoft Power BI',
    ];

    public function handle()
    {
        $this->info('🔧 開始修正產品圖片 URL 格式...');
        
        $products = DB::table('products')->select('id', 'name', 'images')->get();
        $updatedCount = 0;
        $fixedCount = 0;
        
        DB::beginTransaction();
        
        try {
            foreach ($products as $product) {
                $updated = false;
                $images = json_decode($product->images, true) ?: [];
                
                if (empty($images)) {
                    continue;
                }
                
                // 檢查是否有對應的正確 URL
                $mappedName = $this->nameMapping[$product->name] ?? $product->name;
                
                if (isset($this->correctImageUrls[$mappedName])) {
                    // 使用正確的 URL
                    $images[0] = $this->correctImageUrls[$mappedName];
                    $updated = true;
                    $this->info("✅ 更新 {$product->name} 使用正確的圖片 URL");
                } else {
                    // 修正現有 URL 的參數格式
                    $currentUrl = $images[0];
                    if (strpos($currentUrl, 'zapier-images.imgix.net') !== false) {
                        $fixedUrl = $this->fixImageUrlParameters($currentUrl);
                        if ($fixedUrl !== $currentUrl) {
                            $images[0] = $fixedUrl;
                            $updated = true;
                            $fixedCount++;
                            $this->line("🔧 修正 {$product->name} 的圖片參數");
                        }
                    }
                }
                
                if ($updated) {
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['images' => json_encode($images)]);
                    $updatedCount++;
                }
            }
            
            DB::commit();
            
            $this->info("\n🎉 圖片 URL 修正完成！");
            $this->info("📊 總共更新: {$updatedCount} 個產品");
            $this->info("📊 使用正確 URL: " . ($updatedCount - $fixedCount) . " 個產品");
            $this->info("📊 修正參數格式: {$fixedCount} 個產品");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ 圖片 URL 修正失敗: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    /**
     * 修正圖片 URL 參數格式
     */
    private function fixImageUrlParameters($url)
    {
        if (strpos($url, 'zapier-images.imgix.net') === false) {
            return $url;
        }
        
        // 解析 URL
        $parsedUrl = parse_url($url);
        if (!$parsedUrl) {
            return $url;
        }
        
        // 解析查詢參數
        parse_str($parsedUrl['query'] ?? '', $params);
        
        // 設定標準參數
        $params['auto'] = 'format';
        $params['ixlib'] = 'react-9.10.0';
        $params['q'] = '50';
        $params['fit'] = 'crop';
        $params['h'] = '300';
        $params['w'] = '300';
        
        // 重建 URL
        $baseUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] . $parsedUrl['path'];
        $queryString = http_build_query($params);
        
        return $baseUrl . '?' . $queryString;
    }
}
