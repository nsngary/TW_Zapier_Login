<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UpdateProductImagesCommand extends Command
{
    protected $signature = 'products:update-images';
    protected $description = '更新產品圖片連結為標準 300x300 格式';

    // 應用程式圖片映射表
    private $imageMapping = [
        // 人工智慧
        'OpenAI GPT-4' => 'https://zapier-images.imgix.net/storage/services/openai.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Anthropic Claude 3' => 'https://zapier-images.imgix.net/storage/services/anthropic.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'ChatGPT 人工智慧助手' => 'https://zapier-images.imgix.net/storage/services/openai.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Claude 人工智慧助手' => 'https://zapier-images.imgix.net/storage/services/anthropic.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Midjourney' => 'https://zapier-images.imgix.net/storage/services/midjourney.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Jasper AI' => 'https://zapier-images.imgix.net/storage/services/jasper.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 生產力
        'Google 試算表' => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google 日曆' => 'https://zapier-images.imgix.net/storage/services/google-calendar.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Notion 全方位工作區' => 'https://zapier-images.imgix.net/storage/services/notion.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Trello 專案管理' => 'https://zapier-images.imgix.net/storage/services/trello.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Trello' => 'https://zapier-images.imgix.net/storage/services/trello.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Asana 工作管理' => 'https://zapier-images.imgix.net/storage/services/asana.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Monday.com 專案協作' => 'https://zapier-images.imgix.net/storage/services/monday.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Monday.com' => 'https://zapier-images.imgix.net/storage/services/monday.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'ClickUp 生產力平台' => 'https://zapier-images.imgix.net/storage/services/clickup.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'ClickUp' => 'https://zapier-images.imgix.net/storage/services/clickup.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Todoist 任務管理' => 'https://zapier-images.imgix.net/storage/services/todoist.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Excel 試算表' => 'https://zapier-images.imgix.net/storage/services/microsoft-excel.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Airtable' => 'https://zapier-images.imgix.net/storage/services/airtable.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 溝通
        'Gmail 電子郵件' => 'https://zapier-images.imgix.net/storage/services/gmail.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Slack 團隊協作' => 'https://zapier-images.imgix.net/storage/services/slack.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Outlook 電子郵件' => 'https://zapier-images.imgix.net/storage/services/microsoft-outlook.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Teams 團隊協作' => 'https://zapier-images.imgix.net/storage/services/microsoft-teams.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Teams' => 'https://zapier-images.imgix.net/storage/services/microsoft-teams.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Discord 語音聊天' => 'https://zapier-images.imgix.net/storage/services/discord.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Discord' => 'https://zapier-images.imgix.net/storage/services/discord.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Zoom' => 'https://zapier-images.imgix.net/storage/services/zoom.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'WhatsApp Business' => 'https://zapier-images.imgix.net/storage/services/whatsapp.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 銷售與CRM
        'HubSpot 客戶關係管理' => 'https://zapier-images.imgix.net/storage/services/hubspot.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Salesforce 客戶關係管理' => 'https://zapier-images.imgix.net/storage/services/salesforce.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Salesforce' => 'https://zapier-images.imgix.net/storage/services/salesforce.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Calendly 會議排程' => 'https://zapier-images.imgix.net/storage/services/calendly.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Typeform 表單建立器' => 'https://zapier-images.imgix.net/storage/services/typeform.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google 表單' => 'https://zapier-images.imgix.net/storage/services/google-forms.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Pipedrive' => 'https://zapier-images.imgix.net/storage/services/pipedrive.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Zoho CRM' => 'https://zapier-images.imgix.net/storage/services/zoho-crm.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 行銷
        'Mailchimp 電子郵件行銷' => 'https://zapier-images.imgix.net/storage/services/mailchimp.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Facebook 潛在客戶廣告' => 'https://zapier-images.imgix.net/storage/services/facebook-lead-ads.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google 廣告' => 'https://zapier-images.imgix.net/storage/services/google-ads.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Instagram 商業版' => 'https://zapier-images.imgix.net/storage/services/instagram.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Canva' => 'https://zapier-images.imgix.net/storage/services/canva.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Buffer' => 'https://zapier-images.imgix.net/storage/services/buffer.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Hootsuite' => 'https://zapier-images.imgix.net/storage/services/hootsuite.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 檔案管理
        'Google 雲端硬碟' => 'https://zapier-images.imgix.net/storage/services/google-drive.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Dropbox 雲端儲存' => 'https://zapier-images.imgix.net/storage/services/dropbox.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Dropbox' => 'https://zapier-images.imgix.net/storage/services/dropbox.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'OneDrive 雲端儲存' => 'https://zapier-images.imgix.net/storage/services/onedrive.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Box' => 'https://zapier-images.imgix.net/storage/services/box.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 開發工具
        'GitHub 程式碼管理' => 'https://zapier-images.imgix.net/storage/services/github.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'GitHub' => 'https://zapier-images.imgix.net/storage/services/github.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'GitLab' => 'https://zapier-images.imgix.net/storage/services/gitlab.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Docker' => 'https://zapier-images.imgix.net/storage/services/docker.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Zapier Webhooks 整合工具' => 'https://zapier-images.imgix.net/storage/services/webhook.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 客戶支援
        'Zendesk 客戶支援' => 'https://zapier-images.imgix.net/storage/services/zendesk.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Zendesk' => 'https://zapier-images.imgix.net/storage/services/zendesk.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Intercom 客戶訊息平台' => 'https://zapier-images.imgix.net/storage/services/intercom.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Intercom' => 'https://zapier-images.imgix.net/storage/services/intercom.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Freshdesk' => 'https://zapier-images.imgix.net/storage/services/freshdesk.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 商業智慧
        'Tableau' => 'https://zapier-images.imgix.net/storage/services/tableau.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Microsoft Power BI' => 'https://zapier-images.imgix.net/storage/services/microsoft-power-bi.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Google Analytics' => 'https://zapier-images.imgix.net/storage/services/google-analytics.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Mixpanel' => 'https://zapier-images.imgix.net/storage/services/mixpanel.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 電子商務
        'Shopify' => 'https://zapier-images.imgix.net/storage/services/shopify.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'WooCommerce' => 'https://zapier-images.imgix.net/storage/services/woocommerce.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Stripe' => 'https://zapier-images.imgix.net/storage/services/stripe.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'PayPal' => 'https://zapier-images.imgix.net/storage/services/paypal.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 專案管理
        'Jira' => 'https://zapier-images.imgix.net/storage/services/jira.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Basecamp' => 'https://zapier-images.imgix.net/storage/services/basecamp.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 會計
        'QuickBooks Online' => 'https://zapier-images.imgix.net/storage/services/quickbooks.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        'Xero' => 'https://zapier-images.imgix.net/storage/services/xero.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
        
        // 人力資源
        'BambooHR' => 'https://zapier-images.imgix.net/storage/services/bamboohr.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300',
    ];

    public function handle()
    {
        $this->info('🖼️  開始更新產品圖片連結...');
        
        $products = DB::table('products')->select('id', 'name', 'images')->get();
        $updatedCount = 0;
        $notFoundCount = 0;
        
        foreach ($products as $product) {
            if (isset($this->imageMapping[$product->name])) {
                $newImageUrl = $this->imageMapping[$product->name];
                $newImages = json_encode([$newImageUrl]);
                
                DB::table('products')
                    ->where('id', $product->id)
                    ->update(['images' => $newImages]);
                
                $this->info("✅ 更新 {$product->name} 的圖片");
                $updatedCount++;
            } else {
                $this->warn("⚠️  找不到 {$product->name} 的圖片映射");
                $notFoundCount++;
            }
        }
        
        $this->info("\n🎉 圖片更新完成！");
        $this->info("📊 成功更新: {$updatedCount} 個產品");
        $this->info("📊 未找到映射: {$notFoundCount} 個產品");
        
        return 0;
    }
}
