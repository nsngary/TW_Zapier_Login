<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MigrateExtendedZapierAppsCommand extends Command
{
    protected $signature = 'migrate:extended-zapier-apps';
    protected $description = '移植更多 Zapier 應用程式資料到產品資料表，並建立應用程式分類表';

    // 擴展的 Zapier 應用程式資料
    private $zapierApps = [
        // 生產力工具
        [
            'name' => 'Google Sheets',
            'description' => 'Create, edit, and share spreadsheets wherever you are with Google Sheets, and get automated insights from your data.',
            'category' => 'Productivity',
            'subcategory' => 'Spreadsheets',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/8913a06feb7556d01285c052e4ad59d0.png',
            'is_premium' => false,
            'external_url' => 'http://sheets.google.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Google Calendar',
            'description' => 'Google Calendar lets you organize your schedule and share events with co-workers and friends. With Google\'s free online calendar, it\'s easy to keep track of your daily schedule.',
            'category' => 'Productivity',
            'subcategory' => 'Calendar',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/5e4971d60629bca0548ded987b9ddc06.png',
            'is_premium' => false,
            'external_url' => 'https://calendar.google.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Notion',
            'description' => 'A new tool that blends your everyday work apps into one. It\'s the all-in-one workspace for you and your team.',
            'category' => 'Productivity',
            'subcategory' => 'Notes',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/0de44c7d5f0046873886168b9b498f66_3.png',
            'is_premium' => false,
            'external_url' => 'https://www.notion.so/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Trello',
            'description' => 'Trello is a team collaboration tool that lets you organize anything and everything to keep your projects on task.',
            'category' => 'Productivity',
            'subcategory' => 'Project Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/da3ff465abd3a3e1b687c52ff803af74.png',
            'is_premium' => false,
            'external_url' => 'https://trello.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Asana',
            'description' => 'Asana is a leading work management platform that helps teams orchestrate their work, from daily tasks to strategic initiatives.',
            'category' => 'Productivity',
            'subcategory' => 'Project Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/8a7b28de359dd07048ac9153f797fa5d.png',
            'is_premium' => false,
            'external_url' => 'http://asana.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Monday.com',
            'description' => 'monday.com helps you move projects forward fast, letting everyone know what\'s been done on a task—and what needs finished right now.',
            'category' => 'Productivity',
            'subcategory' => 'Project Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/developer/2663f19cb1a591e113356c9ba376a567.png',
            'is_premium' => false,
            'external_url' => 'https://monday.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'ClickUp',
            'description' => 'ClickUp is a productivity platform that allows you to manage your work and personal tasks in a beautifully intuitive environment.',
            'category' => 'Productivity',
            'subcategory' => 'Project Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/000c15b838d86d80869cff5938fa76f3.png',
            'is_premium' => false,
            'external_url' => 'https://clickup.com/zapier',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Todoist',
            'description' => 'Managing millions of tasks, Todoist is an online task management app and todo list.',
            'category' => 'Productivity',
            'subcategory' => 'Task Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/developer/965784dd0a38a1e338b61b8b89ceaf78.png',
            'is_premium' => false,
            'external_url' => 'https://todoist.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Microsoft Excel',
            'description' => 'Microsoft\'s Excel is a spreadsheet application used by millions of users across the world.',
            'category' => 'Productivity',
            'subcategory' => 'Spreadsheets',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/296388d714e0dcd78105c9b165ca751e.png',
            'is_premium' => false,
            'external_url' => 'https://zapier.com/office.com',
            'partner_tier' => 'PLATINUM'
        ],

        // 通訊協作
        [
            'name' => 'Gmail',
            'description' => 'One of the most popular email services, Gmail keeps track of all your emails with threaded conversations, tags, and Google-powered search.',
            'category' => 'Communication',
            'subcategory' => 'Email',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/1afcb319c029ec5da10efb593b7159c8.png',
            'is_premium' => false,
            'external_url' => 'https://mail.google.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Slack',
            'description' => 'Slack is a platform for team communication: everything in one place, instantly searchable, available wherever you go.',
            'category' => 'Communication',
            'subcategory' => 'Team Chat',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/6cf3f5a461feadfba7abc93c4c395b33_2.png',
            'is_premium' => false,
            'external_url' => 'https://slack.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Microsoft Outlook',
            'description' => 'Microsoft Outlook is a web-based suite of webmail, contacts, tasks, and calendaring services.',
            'category' => 'Communication',
            'subcategory' => 'Email',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/17b8fae71a30cf910b73ed0eda8b1443.png',
            'is_premium' => false,
            'external_url' => 'https://outlook.live.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Microsoft Teams',
            'description' => 'Microsoft Teams is the hub for team collaboration in Microsoft 365 that integrates the people, content, and tools your team needs.',
            'category' => 'Communication',
            'subcategory' => 'Team Chat',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/f35c5b8b8b8b8b8b8b8b8b8b8b8b8b8b.png',
            'is_premium' => false,
            'external_url' => 'https://teams.microsoft.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Discord',
            'description' => 'Discord is the easiest way to talk over voice, video, and text. Talk, chat, hang out, and stay close with your friends and communities.',
            'category' => 'Communication',
            'subcategory' => 'Team Chat',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/discord-logo.png',
            'is_premium' => false,
            'external_url' => 'https://discord.com/',
            'partner_tier' => 'GOLD'
        ],

        // 銷售與客戶關係管理
        [
            'name' => 'HubSpot',
            'description' => 'HubSpot is your all-in-one stop for all of your marketing software needs.',
            'category' => 'Sales & CRM',
            'subcategory' => 'CRM',
            'logo_url' => 'https://zapier-images.imgix.net/storage/developer/cde9764aa8d19fdd6d591455dbe5a78d.png',
            'is_premium' => false,
            'external_url' => 'http://www.hubspot.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Salesforce',
            'description' => 'Salesforce is the world\'s leading customer relationship management (CRM) platform.',
            'category' => 'Sales & CRM',
            'subcategory' => 'CRM',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/salesforce-logo.png',
            'is_premium' => false,
            'external_url' => 'https://www.salesforce.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Calendly',
            'description' => 'Calendly is an elegant and simple scheduling tool for businesses that eliminates email back and forth.',
            'category' => 'Sales & CRM',
            'subcategory' => 'Scheduling',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/33464c48a26a29dd29977ffb16bcca53.png',
            'is_premium' => false,
            'external_url' => 'https://calendly.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Typeform',
            'description' => 'Typeform helps you ask awesomely online! If you ever need to run a survey, questionnaire, form, contest etc.',
            'category' => 'Sales & CRM',
            'subcategory' => 'Forms & Surveys',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/03da9e9775e821e3a591e56c0b1e17b3.png',
            'is_premium' => false,
            'external_url' => 'http://typeform.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Google Forms',
            'description' => 'Google Forms is an easy way to collect data from the web with a simple UI and powerful editor.',
            'category' => 'Sales & CRM',
            'subcategory' => 'Forms & Surveys',
            'logo_url' => 'https://zapier-images.imgix.net/storage/developer_cli/82ee79efa898e62c2c8b71187e09fb91.png',
            'is_premium' => false,
            'external_url' => 'http://google.com/',
            'partner_tier' => 'PLATINUM'
        ],

        // 行銷推廣
        [
            'name' => 'Mailchimp',
            'description' => 'Mailchimp is an email and marketing automation platform built for growing businesses.',
            'category' => 'Marketing',
            'subcategory' => 'Email Marketing',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/d4a87a6bccbd4490512fb02638086f9b.png',
            'is_premium' => false,
            'external_url' => 'https://mailchimp.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Facebook Lead Ads',
            'description' => 'Facebook lead ads make signing up for business information easy for people and more valuable for businesses.',
            'category' => 'Marketing',
            'subcategory' => 'Ads & Conversion',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/f407c31b217aac6e0cd4171092d53a8c_3.png',
            'is_premium' => true,
            'external_url' => 'https://www.facebook.com/business/ads/lead-ads',
            'partner_tier' => 'GOLD'
        ],
        [
            'name' => 'Google Ads',
            'description' => 'Google Ads is an online advertising platform developed by Google, where advertisers pay to display brief advertisements.',
            'category' => 'Marketing',
            'subcategory' => 'Ads & Conversion',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/google-ads-logo.png',
            'is_premium' => true,
            'external_url' => 'https://ads.google.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Instagram for Business',
            'description' => 'Instagram for Business helps you reach the people who matter to your business.',
            'category' => 'Marketing',
            'subcategory' => 'Social Media Marketing',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/instagram-logo.png',
            'is_premium' => false,
            'external_url' => 'https://business.instagram.com/',
            'partner_tier' => 'GOLD'
        ],

        // 內容與檔案管理
        [
            'name' => 'Google Drive',
            'description' => 'Google Drive is Google\'s file sync app that lets you store all of your files online alongside your Google Docs documents.',
            'category' => 'Content & Files',
            'subcategory' => 'File Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/a5b8a9920e9dae8a73711590e7090d3d.png',
            'is_premium' => false,
            'external_url' => 'https://www.google.com/drive/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Dropbox',
            'description' => 'Dropbox is a file hosting service that offers cloud storage, file synchronization, personal cloud, and client software.',
            'category' => 'Content & Files',
            'subcategory' => 'File Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/dropbox-logo.png',
            'is_premium' => false,
            'external_url' => 'https://www.dropbox.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'OneDrive',
            'description' => 'Microsoft OneDrive is a file hosting service and synchronization service operated by Microsoft.',
            'category' => 'Content & Files',
            'subcategory' => 'File Management',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/onedrive-logo.png',
            'is_premium' => false,
            'external_url' => 'https://onedrive.live.com/',
            'partner_tier' => 'PLATINUM'
        ],

        // 人工智慧
        [
            'name' => 'ChatGPT (OpenAI)',
            'description' => 'ChatGPT is an AI tool built by OpenAI that enables conversational automation.',
            'category' => 'Artificial Intelligence',
            'subcategory' => 'AI Tools',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/9f47fd7646c5528b9958da1a86893a05.png',
            'is_premium' => false,
            'external_url' => 'https://chat.openai.com/chat',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Claude (Anthropic)',
            'description' => 'Claude is an AI assistant created by Anthropic to be helpful, harmless, and honest.',
            'category' => 'Artificial Intelligence',
            'subcategory' => 'AI Tools',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/claude-logo.png',
            'is_premium' => false,
            'external_url' => 'https://claude.ai/',
            'partner_tier' => 'GOLD'
        ],

        // IT 營運工具
        [
            'name' => 'Webhooks by Zapier',
            'description' => 'Webhooks simply POST data (or JSON) to a specific URL every time we see something new.',
            'category' => 'IT Operations',
            'subcategory' => 'Developer Tools',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/6aafbb717d42f8b42f5be2e4e89e1a15.png',
            'is_premium' => true,
            'external_url' => 'https://zapier.com/blog/what-are-webhooks/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'GitHub',
            'description' => 'GitHub is a development platform inspired by the way you work. From open source to business.',
            'category' => 'IT Operations',
            'subcategory' => 'Developer Tools',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/github-logo.png',
            'is_premium' => false,
            'external_url' => 'https://github.com/',
            'partner_tier' => 'PLATINUM'
        ],

        // 客戶支援
        [
            'name' => 'Zendesk',
            'description' => 'Zendesk builds software for better customer relationships. It empowers organizations to improve customer engagement.',
            'category' => 'Support',
            'subcategory' => 'Customer Support',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/zendesk-logo.png',
            'is_premium' => false,
            'external_url' => 'https://www.zendesk.com/',
            'partner_tier' => 'PLATINUM'
        ],
        [
            'name' => 'Intercom',
            'description' => 'Intercom is a customer messaging platform that helps businesses build better customer relationships.',
            'category' => 'Support',
            'subcategory' => 'Customer Support',
            'logo_url' => 'https://zapier-images.imgix.net/storage/services/intercom-logo.png',
            'is_premium' => false,
            'external_url' => 'https://www.intercom.com/',
            'partner_tier' => 'GOLD'
        ]
    ];

    // 繁體中文翻譯對照表
    private $translations = [
        // 應用程式名稱翻譯
        'Google Sheets' => 'Google 試算表',
        'Google Calendar' => 'Google 日曆',
        'Notion' => 'Notion 全方位工作區',
        'Trello' => 'Trello 專案管理',
        'Asana' => 'Asana 工作管理',
        'Monday.com' => 'Monday.com 專案協作',
        'ClickUp' => 'ClickUp 生產力平台',
        'Todoist' => 'Todoist 任務管理',
        'Microsoft Excel' => 'Microsoft Excel 試算表',
        'Gmail' => 'Gmail 電子郵件',
        'Slack' => 'Slack 團隊協作',
        'Microsoft Outlook' => 'Microsoft Outlook 電子郵件',
        'Microsoft Teams' => 'Microsoft Teams 團隊協作',
        'Discord' => 'Discord 語音聊天',
        'HubSpot' => 'HubSpot 客戶關係管理',
        'Salesforce' => 'Salesforce 客戶關係管理',
        'Calendly' => 'Calendly 會議排程',
        'Typeform' => 'Typeform 表單建立器',
        'Google Forms' => 'Google 表單',
        'Mailchimp' => 'Mailchimp 電子郵件行銷',
        'Facebook Lead Ads' => 'Facebook 潛在客戶廣告',
        'Google Ads' => 'Google 廣告',
        'Instagram for Business' => 'Instagram 商業版',
        'Google Drive' => 'Google 雲端硬碟',
        'Dropbox' => 'Dropbox 雲端儲存',
        'OneDrive' => 'OneDrive 雲端儲存',
        'ChatGPT (OpenAI)' => 'ChatGPT 人工智慧助手',
        'Claude (Anthropic)' => 'Claude 人工智慧助手',
        'Webhooks by Zapier' => 'Zapier Webhooks 整合工具',
        'GitHub' => 'GitHub 程式碼管理',
        'Zendesk' => 'Zendesk 客戶支援',
        'Intercom' => 'Intercom 客戶訊息平台',

        // 分類翻譯
        'Productivity' => '生產力工具',
        'Communication' => '通訊協作',
        'Sales & CRM' => '銷售與客戶關係管理',
        'Marketing' => '行銷推廣',
        'Content & Files' => '內容與檔案管理',
        'Artificial Intelligence' => '人工智慧',
        'IT Operations' => 'IT 營運工具',
        'Support' => '客戶支援',

        // 子分類翻譯
        'Spreadsheets' => '試算表',
        'Calendar' => '日曆排程',
        'Notes' => '筆記工具',
        'Project Management' => '專案管理',
        'Task Management' => '任務管理',
        'Email' => '電子郵件',
        'Team Chat' => '團隊聊天',
        'CRM' => '客戶關係管理',
        'Scheduling' => '會議排程',
        'Forms & Surveys' => '表單與問卷',
        'Email Marketing' => '電子郵件行銷',
        'Ads & Conversion' => '廣告與轉換',
        'Social Media Marketing' => '社群媒體行銷',
        'File Management' => '檔案管理',
        'AI Tools' => 'AI 工具',
        'Developer Tools' => '開發者工具',
        'Customer Support' => '客戶支援'
    ];

    public function handle()
    {
        $this->info('開始移植擴展版 Zapier 應用程式資料...');

        try {
            DB::beginTransaction();

            // 清空現有產品資料
            $this->info('清空現有產品資料...');
            DB::table('products')->truncate();

            // 建立應用程式分類表（如果不存在）
            $this->createAppCategoriesTable();

            $this->info('開始移植應用程式資料...');

            foreach ($this->zapierApps as $index => $app) {
                $this->migrateApp($app, $index + 1);
            }

            // 更新管理員帳號的 role
            $this->updateAdminRole();

            DB::commit();
            $this->info('✅ 成功移植 ' . count($this->zapierApps) . ' 個 Zapier 應用程式！');

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error('❌ 移植失敗：' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    private function createAppCategoriesTable()
    {
        if (!DB::getSchemaBuilder()->hasTable('app_categories')) {
            DB::statement('
                CREATE TABLE app_categories (
                    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                    name VARCHAR(255) NOT NULL,
                    slug VARCHAR(255) NOT NULL UNIQUE,
                    description TEXT,
                    icon VARCHAR(255),
                    color VARCHAR(7) DEFAULT "#6366f1",
                    sort_order INT DEFAULT 0,
                    created_at TIMESTAMP NULL DEFAULT NULL,
                    updated_at TIMESTAMP NULL DEFAULT NULL
                )
            ');
            $this->info('✓ 建立 app_categories 資料表');
        }

        // 插入分類資料
        $categories = [
            ['name' => '生產力工具', 'slug' => 'productivity', 'description' => '提升工作效率的應用程式', 'icon' => 'productivity', 'color' => '#10b981'],
            ['name' => '通訊協作', 'slug' => 'communication', 'description' => '團隊溝通與協作工具', 'icon' => 'communication', 'color' => '#3b82f6'],
            ['name' => '銷售與客戶關係管理', 'slug' => 'sales-crm', 'description' => '銷售流程與客戶管理工具', 'icon' => 'sales', 'color' => '#f59e0b'],
            ['name' => '行銷推廣', 'slug' => 'marketing', 'description' => '行銷活動與推廣工具', 'icon' => 'marketing', 'color' => '#ef4444'],
            ['name' => '內容與檔案管理', 'slug' => 'content-files', 'description' => '檔案儲存與內容管理工具', 'icon' => 'files', 'color' => '#8b5cf6'],
            ['name' => '人工智慧', 'slug' => 'artificial-intelligence', 'description' => 'AI 驅動的智慧工具', 'icon' => 'ai', 'color' => '#06b6d4'],
            ['name' => 'IT 營運工具', 'slug' => 'it-operations', 'description' => '開發與 IT 營運工具', 'icon' => 'it', 'color' => '#64748b'],
            ['name' => '客戶支援', 'slug' => 'support', 'description' => '客戶服務與支援工具', 'icon' => 'support', 'color' => '#84cc16']
        ];

        foreach ($categories as $category) {
            DB::table('app_categories')->updateOrInsert(
                ['slug' => $category['slug']],
                array_merge($category, [
                    'created_at' => now(),
                    'updated_at' => now()
                ])
            );
        }
        $this->info('✓ 插入應用程式分類資料');
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

        // 根據合作夥伴等級設定價格
        $price = $this->calculatePrice($app);

        $productData = [
            'id' => $id,
            'name' => $chineseName,
            'description' => $chineseDescription,
            'detail' => $detailContent,
            'price' => $price,
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

        $this->info("✓ 已移植：{$chineseName} ({$app['name']}) - \${$price}");
    }

    private function calculatePrice($app)
    {
        if ($app['is_premium']) {
            return 199.00; // 付費應用
        }

        // 根據合作夥伴等級設定價格
        switch ($app['partner_tier']) {
            case 'PLATINUM':
                return 0.00; // 白金合作夥伴免費
            case 'GOLD':
                return 49.00; // 金牌合作夥伴低價
            case 'BRONZE':
                return 99.00; // 銅牌合作夥伴中價
            default:
                return 149.00; // 一般合作夥伴高價
        }
    }

    private function updateAdminRole()
    {
        // 將 admin 帳號設為 admin 角色
        DB::table('users')
            ->where('account', 'admin')
            ->update(['role' => 'admin']);

        $this->info('✓ 更新管理員帳號角色');
    }

    private function translateDescription($description)
    {
        // 簡化版翻譯，實際應用中可以使用翻譯 API
        $translations = [
            'Create, edit, and share spreadsheets wherever you are with Google Sheets, and get automated insights from your data.' =>
                '使用 Google 試算表隨時隨地建立、編輯和分享試算表，並從您的資料中獲得自動化洞察。',
            'Google Calendar lets you organize your schedule and share events with co-workers and friends. With Google\'s free online calendar, it\'s easy to keep track of your daily schedule.' =>
                'Google 日曆讓您整理行程並與同事和朋友分享活動。透過 Google 的免費線上日曆，輕鬆追蹤您的每日行程。',
            'A new tool that blends your everyday work apps into one. It\'s the all-in-one workspace for you and your team.' =>
                '一個將您日常工作應用程式融合為一體的新工具。這是您和您團隊的全方位工作區。',
            'Trello is a team collaboration tool that lets you organize anything and everything to keep your projects on task.' =>
                'Trello 是一個團隊協作工具，讓您整理任何事物，確保專案順利進行。',
            'Asana is a leading work management platform that helps teams orchestrate their work, from daily tasks to strategic initiatives.' =>
                'Asana 是領先的工作管理平台，幫助團隊協調工作，從日常任務到策略性計畫。',
            'monday.com helps you move projects forward fast, letting everyone know what\'s been done on a task—and what needs finished right now.' =>
                'Monday.com 幫助您快速推進專案，讓每個人都知道任務的完成狀況以及目前需要完成的工作。',
            'ClickUp is a productivity platform that allows you to manage your work and personal tasks in a beautifully intuitive environment.' =>
                'ClickUp 是一個生產力平台，讓您在美觀直觀的環境中管理工作和個人任務。',
            'Managing millions of tasks, Todoist is an online task management app and todo list.' =>
                '管理數百萬個任務，Todoist 是一個線上任務管理應用程式和待辦事項清單。',
            'Microsoft\'s Excel is a spreadsheet application used by millions of users across the world.' =>
                'Microsoft Excel 是全球數百萬用戶使用的試算表應用程式。',
            'One of the most popular email services, Gmail keeps track of all your emails with threaded conversations, tags, and Google-powered search.' =>
                '作為最受歡迎的電子郵件服務之一，Gmail 透過對話串、標籤和 Google 強大的搜尋功能來追蹤您的所有電子郵件。',
            'Slack is a platform for team communication: everything in one place, instantly searchable, available wherever you go.' =>
                'Slack 是團隊溝通平台：所有內容集中在一處，可即時搜尋，隨時隨地可用。',
            'Microsoft Outlook is a web-based suite of webmail, contacts, tasks, and calendaring services.' =>
                'Microsoft Outlook 是基於網路的電子郵件、聯絡人、任務和日曆服務套件。',
            'Microsoft Teams is the hub for team collaboration in Microsoft 365 that integrates the people, content, and tools your team needs.' =>
                'Microsoft Teams 是 Microsoft 365 中的團隊協作中心，整合了您團隊所需的人員、內容和工具。',
            'Discord is the easiest way to talk over voice, video, and text. Talk, chat, hang out, and stay close with your friends and communities.' =>
                'Discord 是透過語音、視訊和文字交流的最簡單方式。與朋友和社群聊天、閒逛並保持聯繫。',
            'HubSpot is your all-in-one stop for all of your marketing software needs.' =>
                'HubSpot 是滿足您所有行銷軟體需求的一站式解決方案。',
            'Salesforce is the world\'s leading customer relationship management (CRM) platform.' =>
                'Salesforce 是全球領先的客戶關係管理 (CRM) 平台。',
            'Calendly is an elegant and simple scheduling tool for businesses that eliminates email back and forth.' =>
                'Calendly 是一個優雅簡潔的企業排程工具，消除了來回電子郵件的麻煩。',
            'Typeform helps you ask awesomely online! If you ever need to run a survey, questionnaire, form, contest etc.' =>
                'Typeform 幫助您在線上進行出色的問卷調查！無論您需要進行調查、問卷、表單、競賽等。',
            'Google Forms is an easy way to collect data from the web with a simple UI and powerful editor.' =>
                'Google 表單是從網路收集資料的簡單方式，具有簡潔的使用者介面和強大的編輯器。',
            'Mailchimp is an email and marketing automation platform built for growing businesses.' =>
                'Mailchimp 是專為成長中企業打造的電子郵件和行銷自動化平台。',
            'Facebook lead ads make signing up for business information easy for people and more valuable for businesses.' =>
                'Facebook 潛在客戶廣告讓人們輕鬆註冊商業資訊，為企業創造更多價值。',
            'Google Ads is an online advertising platform developed by Google, where advertisers pay to display brief advertisements.' =>
                'Google 廣告是由 Google 開發的線上廣告平台，廣告主付費展示簡短廣告。',
            'Instagram for Business helps you reach the people who matter to your business.' =>
                'Instagram 商業版幫助您接觸對您業務重要的人群。',
            'Google Drive is Google\'s file sync app that lets you store all of your files online alongside your Google Docs documents.' =>
                'Google 雲端硬碟是 Google 的檔案同步應用程式，讓您將所有檔案與 Google 文件一起儲存在線上。',
            'Dropbox is a file hosting service that offers cloud storage, file synchronization, personal cloud, and client software.' =>
                'Dropbox 是一個檔案託管服務，提供雲端儲存、檔案同步、個人雲端和客戶端軟體。',
            'Microsoft OneDrive is a file hosting service and synchronization service operated by Microsoft.' =>
                'Microsoft OneDrive 是由 Microsoft 營運的檔案託管和同步服務。',
            'ChatGPT is an AI tool built by OpenAI that enables conversational automation.' =>
                'ChatGPT 是由 OpenAI 開發的 AI 工具，能夠實現對話式自動化。',
            'Claude is an AI assistant created by Anthropic to be helpful, harmless, and honest.' =>
                'Claude 是由 Anthropic 創建的 AI 助手，旨在提供有用、無害且誠實的服務。',
            'Webhooks simply POST data (or JSON) to a specific URL every time we see something new.' =>
                'Webhooks 只需在每次看到新內容時將資料（或 JSON）POST 到特定 URL。',
            'GitHub is a development platform inspired by the way you work. From open source to business.' =>
                'GitHub 是一個受您工作方式啟發的開發平台。從開源到商業應用。',
            'Zendesk builds software for better customer relationships. It empowers organizations to improve customer engagement.' =>
                'Zendesk 為更好的客戶關係構建軟體。它賦予組織改善客戶參與度的能力。',
            'Intercom is a customer messaging platform that helps businesses build better customer relationships.' =>
                'Intercom 是一個客戶訊息平台，幫助企業建立更好的客戶關係。'
        ];

        return $translations[$description] ?? $description;
    }

    private function generateDetailContent($app)
    {
        $chineseCategory = $this->translations[$app['category']] ?? $app['category'];
        $chineseSubcategory = $this->translations[$app['subcategory']] ?? $app['subcategory'];

        return "<h3>應用程式概述</h3>
<p>這是一個專業的{$chineseCategory}工具，屬於{$chineseSubcategory}類別。透過 TW_Zapier 平台，您可以輕鬆將此應用程式與其他工具整合，建立強大的自動化工作流程。</p>

<h3>主要功能特色</h3>
<ul>
<li>專業的工作流程自動化</li>
<li>直觀易用的使用者介面</li>
<li>強大的整合能力</li>
<li>可靠的資料安全保護</li>
<li>24/7 技術支援服務</li>
</ul>

<h3>常見使用場景</h3>
<ul>
<li>提升工作效率和生產力</li>
<li>簡化重複性任務流程</li>
<li>改善團隊協作體驗</li>
<li>優化客戶服務品質</li>
<li>加強資料管理和分析</li>
</ul>

<h3>整合資訊</h3>
<div class=\"integration-info\">
<p><strong>支援的觸發器：</strong>新資料建立、資料更新、狀態變更等</p>
<p><strong>支援的動作：</strong>建立記錄、更新資料、發送通知、生成報告等</p>
<p><strong>整合難度：</strong>簡單 - 只需幾分鐘即可完成設定</p>
<p><strong>更新頻率：</strong>即時同步，確保資料一致性</p>
<p><strong>合作夥伴等級：</strong>{$app['partner_tier']}</p>
</div>

<h3>定價方案</h3>
<p>" . ($app['is_premium'] ? '此為付費應用程式，需要訂閱或購買授權才能使用完整功能。' : '此應用程式提供基本免費功能，進階功能可能需要付費。') . "</p>

<h3>開始使用</h3>
<p>要開始使用此應用程式，請先在 <a href=\"{$app['external_url']}\" target=\"_blank\">官方網站</a> 註冊帳號，然後透過 TW_Zapier 平台建立自動化工作流程。</p>";
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
