<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateZapierAppsCommand extends Command
{
    protected $signature = 'migrate:zapier-apps';
    protected $description = '將 Zapier 應用程式資料移植到產品資料表，並轉換為繁體中文';

    // Zapier 應用程式資料（從 zapier.com/apps 獲取，擴展版本）
    private $zapierApps = [
        [
            'name' => 'Google Sheets',
            'description' => 'Create, edit, and share spreadsheets wherever you are with Google Sheets, and get automated insights from your data.',
            'category' => 'Productivity',
            'subcategory' => 'Spreadsheets',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png',
            'is_premium' => false,
            'external_url' => 'http://sheets.google.com/'
        ],
        [
            'name' => 'Gmail',
            'description' => 'One of the most popular email services, Gmail keeps track of all your emails with threaded conversations, tags, and Google-powered search to find any message you need.',
            'category' => 'Communication',
            'subcategory' => 'Email',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/1afcb319c029ec5da10efb593b7159c8.png',
            'is_premium' => false,
            'external_url' => 'https://mail.google.com/'
        ],
        [
            'name' => 'Slack',
            'description' => 'Slack is a platform for team communication: everything in one place, instantly searchable, available wherever you go. Offering instant messaging, document sharing and knowledge search for modern teams.',
            'category' => 'Communication',
            'subcategory' => 'Team Chat',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png',
            'is_premium' => false,
            'external_url' => 'https://slack.com/'
        ],
        [
            'name' => 'Google Calendar',
            'description' => 'Google Calendar lets you organize your schedule and share events with co-workers and friends. With Google\'s free online calendar, it\'s easy to keep track of your daily schedule.',
            'category' => 'Productivity',
            'subcategory' => 'Calendar',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/5e4971d60629bca0548ded987b9ddc06.png',
            'is_premium' => false,
            'external_url' => 'https://calendar.google.com/'
        ],
        [
            'name' => 'HubSpot',
            'description' => 'HubSpot is your all-in-one stop for all of your marketing software needs.',
            'category' => 'Sales & CRM',
            'subcategory' => 'CRM',
            'logo_url' => 'https://zapier-images.imgix.net/storage/developer/cde9764aa8d19fdd6d591455dbe5a78d.png',
            'is_premium' => false,
            'external_url' => 'http://www.hubspot.com/'
        ],
        [
            'name' => 'Notion',
            'description' => 'A new tool that blends your everyday work apps into one. It\'s the all-in-one workspace for you and your team.',
            'category' => 'Productivity',
            'subcategory' => 'Notes',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png',
            'is_premium' => false,
            'external_url' => 'https://www.notion.so/'
        ],
        [
            'name' => 'Mailchimp',
            'description' => 'Mailchimp is an email and marketing automation platform built for growing businesses. Turn email and SMS into revenue.',
            'category' => 'Marketing',
            'subcategory' => 'Email Marketing',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png',
            'is_premium' => false,
            'external_url' => 'https://mailchimp.com/'
        ],
        [
            'name' => 'Calendly',
            'description' => 'Calendly is an elegant and simple scheduling tool for businesses that eliminates email back and forth. It helps save time so that businesses can provide great service and increase sales.',
            'category' => 'Sales & CRM',
            'subcategory' => 'Scheduling',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/33464c48a26a29dd29977ffb16bcca53.png',
            'is_premium' => false,
            'external_url' => 'https://calendly.com/'
        ],
        [
            'name' => 'ChatGPT (OpenAI)',
            'description' => 'ChatGPT is an AI tool built by OpenAI that enables conversational automation.',
            'category' => 'Artificial Intelligence',
            'subcategory' => 'AI Tools',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/9f47fd7646c5528b9958da1a86893a05.png',
            'is_premium' => false,
            'external_url' => 'https://chat.openai.com/chat'
        ],
        [
            'name' => 'Microsoft Outlook',
            'description' => 'Microsoft Outlook is a web-based suite of webmail, contacts, tasks, and calendaring services.',
            'category' => 'Communication',
            'subcategory' => 'Email',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/17b8fae71a30cf910b73ed0eda8b1443.png',
            'is_premium' => false,
            'external_url' => 'https://outlook.live.com/'
        ],
        [
            'name' => 'Typeform',
            'description' => 'Typeform helps you ask awesomely online! If you ever need to run a survey, questionnaire, form, contest etc. Typeform will help you achieve it beautifully across all devices, every time, using its next generation platform.',
            'category' => 'Sales & CRM',
            'subcategory' => 'Forms & Surveys',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/03da9e9775e821e3a591e56c0b1e17b3.png',
            'is_premium' => false,
            'external_url' => 'http://typeform.com/'
        ],
        [
            'name' => 'Google Drive',
            'description' => 'Google Drive is Google\'s file sync app that lets you store all of your files online alongside your Google Docs documents, and keep them synced with all of your devices.',
            'category' => 'Content & Files',
            'subcategory' => 'File Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png',
            'is_premium' => false,
            'external_url' => 'https://www.google.com/drive/'
        ],
        [
            'name' => 'Google Forms',
            'description' => 'Google Forms is an easy way to collect data from the web with a simple UI and powerful editor. Works hand-in-hand with Google Sheets!',
            'category' => 'Sales & CRM',
            'subcategory' => 'Forms & Surveys',
            'logo_url' => 'https://zapier-images.imgix.net/storage/developer_cli/82ee79efa898e62c2c8b71187e09fb91.png',
            'is_premium' => false,
            'external_url' => 'http://google.com/'
        ],
        [
            'name' => 'Facebook Lead Ads',
            'description' => 'Facebook lead ads make signing up for business information easy for people and more valuable for businesses. The Facebook lead ad app is useful for marketers who want to automate actions on their leads.',
            'category' => 'Marketing',
            'subcategory' => 'Ads & Conversion',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/f407c31b217aac6e0cd4171092d53a8c_3.png',
            'is_premium' => true,
            'external_url' => 'https://www.facebook.com/business/ads/lead-ads'
        ],
        [
            'name' => 'Webhooks by Zapier',
            'description' => 'Webhooks simply POST data (or JSON) to a specific URL every time we see something new. Webhooks can also accept data (or JSON) to kick off a workflow in Zapier.',
            'category' => 'IT Operations',
            'subcategory' => 'Developer Tools',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/6aafbb717d42f8b42f5be2e4e89e1a15.png',
            'is_premium' => true,
            'external_url' => 'https://zapier.com/blog/what-are-webhooks/'
        ]
    ];

    // 繁體中文翻譯對照表
    private $translations = [
        // 應用程式名稱翻譯
        'Google Sheets' => 'Google 試算表',
        'Gmail' => 'Gmail 電子郵件',
        'Slack' => 'Slack 團隊協作',
        'Google Calendar' => 'Google 日曆',
        'HubSpot' => 'HubSpot 客戶關係管理',
        'Notion' => 'Notion 全方位工作區',
        'Mailchimp' => 'Mailchimp 電子郵件行銷',
        'Calendly' => 'Calendly 會議排程',
        'ChatGPT (OpenAI)' => 'ChatGPT 人工智慧助手',
        'Microsoft Outlook' => 'Microsoft Outlook 電子郵件',
        'Typeform' => 'Typeform 表單建立器',
        'Google Drive' => 'Google 雲端硬碟',
        'Google Forms' => 'Google 表單',
        'Facebook Lead Ads' => 'Facebook 潛在客戶廣告',
        'Webhooks by Zapier' => 'Zapier Webhooks 整合工具',

        // 分類翻譯
        'Productivity' => '生產力工具',
        'Communication' => '通訊協作',
        'Sales & CRM' => '銷售與客戶關係管理',
        'Marketing' => '行銷推廣',
        'Artificial Intelligence' => '人工智慧',
        'Content & Files' => '內容與檔案管理',
        'IT Operations' => 'IT 營運工具',

        // 子分類翻譯
        'Spreadsheets' => '試算表',
        'Email' => '電子郵件',
        'Team Chat' => '團隊聊天',
        'Calendar' => '日曆排程',
        'CRM' => '客戶關係管理',
        'Notes' => '筆記工具',
        'Email Marketing' => '電子郵件行銷',
        'Scheduling' => '會議排程',
        'AI Tools' => 'AI 工具',
        'Forms & Surveys' => '表單與問卷',
        'File Management' => '檔案管理',
        'Ads & Conversion' => '廣告與轉換',
        'Developer Tools' => '開發者工具'
    ];

    public function handle()
    {
        $this->info('開始移植 Zapier 應用程式資料...');

        try {
            DB::beginTransaction();

            // 清空現有產品資料
            $this->info('清空現有產品資料...');
            DB::table('products')->truncate();

            $this->info('開始移植應用程式資料...');
            
            foreach ($this->zapierApps as $index => $app) {
                $this->migrateApp($app, $index + 1);
            }

            DB::commit();
            $this->info('✅ 成功移植 ' . count($this->zapierApps) . ' 個 Zapier 應用程式！');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ 移植失敗：' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    private function migrateApp($app, $id)
    {
        // 翻譯應用程式名稱和描述
        $chineseName = $this->translations[$app['name']] ?? $app['name'];
        $chineseDescription = $this->translateDescription($app['description']);
        $chineseCategory = $this->translations[$app['category']] ?? $app['category'];
        
        // 生成詳細內容
        $detailContent = $this->generateDetailContent($app);
        
        // 下載並儲存應用程式圖示
        $imagePath = $this->downloadAppIcon($app['logo_url'], $app['name']);

        $productData = [
            'id' => $id,
            'name' => $chineseName,
            'description' => $chineseDescription,
            'detail' => $detailContent,
            'price' => $app['is_premium'] ? 99.00 : 0.00, // 付費應用設為 $99，免費應用設為 $0
            'stock' => 999, // 數位產品庫存設為 999
            'category' => $chineseCategory,
            'sku' => 'APP-' . str_pad($id, 6, '0', STR_PAD_LEFT),
            'status' => 'active',
            'images' => $imagePath ? json_encode([$imagePath]) : json_encode([]),
            'created_by' => 'system',
            'updated_by' => 'system',
            'created_at' => now(),
            'updated_at' => now()
        ];

        DB::table('products')->insert($productData);
        
        $this->info("✓ 已移植：{$chineseName} ({$app['name']})");
    }

    private function translateDescription($description)
    {
        // 簡單的英文到繁體中文翻譯對照
        $translations = [
            'Create, edit, and share spreadsheets wherever you are with Google Sheets, and get automated insights from your data.' =>
                '使用 Google 試算表隨時隨地建立、編輯和分享試算表，並從您的資料中獲得自動化洞察。',

            'One of the most popular email services, Gmail keeps track of all your emails with threaded conversations, tags, and Google-powered search to find any message you need.' =>
                '作為最受歡迎的電子郵件服務之一，Gmail 透過對話串、標籤和 Google 強大的搜尋功能來追蹤您的所有電子郵件，幫助您找到所需的任何訊息。',

            'Slack is a platform for team communication: everything in one place, instantly searchable, available wherever you go. Offering instant messaging, document sharing and knowledge search for modern teams.' =>
                'Slack 是團隊溝通平台：所有內容集中在一處，可即時搜尋，隨時隨地可用。為現代團隊提供即時訊息、文件分享和知識搜尋功能。',

            'Google Calendar lets you organize your schedule and share events with co-workers and friends. With Google\'s free online calendar, it\'s easy to keep track of your daily schedule.' =>
                'Google 日曆讓您整理行程並與同事和朋友分享活動。透過 Google 的免費線上日曆，輕鬆追蹤您的每日行程。',

            'HubSpot is your all-in-one stop for all of your marketing software needs.' =>
                'HubSpot 是滿足您所有行銷軟體需求的一站式解決方案。',

            'A new tool that blends your everyday work apps into one. It\'s the all-in-one workspace for you and your team.' =>
                '一個將您日常工作應用程式融合為一體的新工具。這是您和您團隊的全方位工作區。',

            'Mailchimp is an email and marketing automation platform built for growing businesses. Turn email and SMS into revenue.' =>
                'Mailchimp 是專為成長中企業打造的電子郵件和行銷自動化平台。將電子郵件和簡訊轉化為收益。',

            'Calendly is an elegant and simple scheduling tool for businesses that eliminates email back and forth. It helps save time so that businesses can provide great service and increase sales.' =>
                'Calendly 是一個優雅簡潔的企業排程工具，消除了來回電子郵件的麻煩。它幫助節省時間，讓企業能夠提供優質服務並增加銷售。',

            'ChatGPT is an AI tool built by OpenAI that enables conversational automation.' =>
                'ChatGPT 是由 OpenAI 開發的 AI 工具，能夠實現對話式自動化。',

            'Microsoft Outlook is a web-based suite of webmail, contacts, tasks, and calendaring services.' =>
                'Microsoft Outlook 是基於網路的電子郵件、聯絡人、任務和日曆服務套件。',

            'Typeform helps you ask awesomely online! If you ever need to run a survey, questionnaire, form, contest etc. Typeform will help you achieve it beautifully across all devices, every time, using its next generation platform.' =>
                'Typeform 幫助您在線上進行出色的問卷調查！無論您需要進行調查、問卷、表單、競賽等，Typeform 都能透過其次世代平台，在所有裝置上為您提供美觀的解決方案。',

            'Google Drive is Google\'s file sync app that lets you store all of your files online alongside your Google Docs documents, and keep them synced with all of your devices.' =>
                'Google 雲端硬碟是 Google 的檔案同步應用程式，讓您將所有檔案與 Google 文件一起儲存在線上，並與所有裝置保持同步。',

            'Google Forms is an easy way to collect data from the web with a simple UI and powerful editor. Works hand-in-hand with Google Sheets!' =>
                'Google 表單是從網路收集資料的簡單方式，具有簡潔的使用者介面和強大的編輯器。與 Google 試算表完美搭配使用！',

            'Facebook lead ads make signing up for business information easy for people and more valuable for businesses. The Facebook lead ad app is useful for marketers who want to automate actions on their leads.' =>
                'Facebook 潛在客戶廣告讓人們輕鬆註冊商業資訊，為企業創造更多價值。Facebook 潛在客戶廣告應用程式對於想要自動化潛在客戶操作的行銷人員非常有用。',

            'Webhooks simply POST data (or JSON) to a specific URL every time we see something new. Webhooks can also accept data (or JSON) to kick off a workflow in Zapier.' =>
                'Webhooks 只需在每次看到新內容時將資料（或 JSON）POST 到特定 URL。Webhooks 也可以接受資料（或 JSON）來啟動 Zapier 中的工作流程。'
        ];

        return $translations[$description] ?? $description;
    }

    private function generateDetailContent($app)
    {
        $chineseCategory = $this->translations[$app['category']] ?? $app['category'];
        $chineseSubcategory = $this->translations[$app['subcategory']] ?? $app['subcategory'];

        $features = $this->getAppFeatures($app['name']);
        $useCases = $this->getAppUseCases($app['name']);
        $integrationInfo = $this->getIntegrationInfo($app['name']);

        return "<h3>應用程式概述</h3>
<p>這是一個專業的{$chineseCategory}工具，屬於{$chineseSubcategory}類別。透過 TW_Zapier 平台，您可以輕鬆將此應用程式與其他工具整合，建立強大的自動化工作流程。</p>

<h3>主要功能特色</h3>
<ul>
{$features}
</ul>

<h3>常見使用場景</h3>
<ul>
{$useCases}
</ul>

<h3>整合資訊</h3>
<div class=\"integration-info\">
{$integrationInfo}
</div>

<h3>定價方案</h3>
<p>" . ($app['is_premium'] ? '此為付費應用程式，需要訂閱或購買授權才能使用完整功能。' : '此為免費應用程式，您可以立即開始使用基本功能。') . "</p>

<h3>開始使用</h3>
<p>要開始使用此應用程式，請先在 <a href=\"{$app['external_url']}\" target=\"_blank\">官方網站</a> 註冊帳號，然後透過 TW_Zapier 平台建立自動化工作流程。</p>";
    }

    private function getAppFeatures($appName)
    {
        $features = [
            'Google Sheets' => [
                '即時協作編輯試算表',
                '強大的公式和函數支援',
                '自動資料分析和圖表生成',
                '與其他 Google 服務無縫整合',
                '雲端儲存，隨時隨地存取'
            ],
            'Gmail' => [
                '強大的垃圾郵件過濾功能',
                '智慧分類和標籤系統',
                '整合 Google 搜尋技術',
                '支援多個帳戶管理',
                '行動裝置完美支援'
            ],
            'Slack' => [
                '頻道式團隊溝通',
                '檔案分享和協作',
                '豐富的第三方應用整合',
                '語音和視訊通話功能',
                '強大的搜尋和歷史記錄'
            ],
            'Google Calendar' => [
                '多日曆管理',
                '智慧會議排程建議',
                '跨平台同步',
                '會議室預訂功能',
                '提醒和通知設定'
            ],
            'HubSpot' => [
                '完整的客戶關係管理',
                '銷售漏斗追蹤',
                '行銷自動化工具',
                '詳細的分析報告',
                '客戶服務管理'
            ]
        ];

        $appFeatures = $features[$appName] ?? [
            '專業的工作流程自動化',
            '直觀易用的使用者介面',
            '強大的整合能力',
            '可靠的資料安全保護',
            '24/7 技術支援服務'
        ];

        return implode("\n", array_map(function($feature) {
            return "<li>{$feature}</li>";
        }, $appFeatures));
    }

    private function getAppUseCases($appName)
    {
        $useCases = [
            'Google Sheets' => [
                '專案進度追蹤和報告',
                '財務預算和費用管理',
                '客戶資料整理和分析',
                '庫存管理和訂單處理',
                '團隊績效評估'
            ],
            'Gmail' => [
                '客戶服務郵件自動回覆',
                '行銷郵件發送和追蹤',
                '重要郵件自動分類',
                '團隊內部溝通協調',
                '商務郵件管理'
            ],
            'Slack' => [
                '專案團隊即時溝通',
                '跨部門協作討論',
                '緊急事件快速通知',
                '檔案共享和版本控制',
                '遠端工作團隊管理'
            ]
        ];

        $appUseCases = $useCases[$appName] ?? [
            '提升工作效率和生產力',
            '簡化重複性任務流程',
            '改善團隊協作體驗',
            '優化客戶服務品質',
            '加強資料管理和分析'
        ];

        return implode("\n", array_map(function($useCase) {
            return "<li>{$useCase}</li>";
        }, $appUseCases));
    }

    private function getIntegrationInfo($appName)
    {
        return "<p><strong>支援的觸發器：</strong>新資料建立、資料更新、狀態變更等</p>
<p><strong>支援的動作：</strong>建立記錄、更新資料、發送通知、生成報告等</p>
<p><strong>整合難度：</strong>簡單 - 只需幾分鐘即可完成設定</p>
<p><strong>更新頻率：</strong>即時同步，確保資料一致性</p>";
    }

    private function downloadAppIcon($logoUrl, $appName)
    {
        try {
            // 建立應用程式圖示目錄
            $iconDir = 'apps/icons';
            if (!Storage::disk('public')->exists($iconDir)) {
                Storage::disk('public')->makeDirectory($iconDir);
            }

            // 生成檔案名稱
            $fileName = Str::slug($appName) . '.png';
            $filePath = $iconDir . '/' . $fileName;

            // 下載圖示
            $imageContent = file_get_contents($logoUrl);
            if ($imageContent !== false) {
                Storage::disk('public')->put($filePath, $imageContent);
                return $filePath;
            }
        } catch (\Exception $e) {
            $this->warn("無法下載 {$appName} 的圖示：" . $e->getMessage());
        }

        return null;
    }
}
