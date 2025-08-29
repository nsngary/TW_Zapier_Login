<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ExpandAppsCommand extends Command
{
    protected $signature = 'products:expand-apps';
    protected $description = '擴展應用程式到 100+ 個，基於 Zapier.com 分析';

    public function handle()
    {
        $this->info('🚀 開始擴展應用程式到 100+ 個...');
        
        $now = Carbon::now();
        $currentCount = DB::table('products')->count();
        
        $this->info("📊 當前應用程式數量: {$currentCount}");
        
        // 新增的應用程式資料
        $newApps = [
            // 網站建設分類 (Website & App Building - 236 apps)
            [
                'name' => 'WordPress',
                'description' => 'WordPress 是全球最受歡迎的內容管理系統，為超過 40% 的網站提供支援，提供靈活的網站建設和內容管理功能。',
                'detail' => 'WordPress 提供強大的內容管理功能，支援主題、外掛程式、SEO 優化和多用戶管理，是建立部落格、企業網站和電子商務網站的首選平台。',
                'price' => 0.00,
                'rating' => 4.6,
                'stock' => 999,
                'category' => '網站建設',
                'sku' => 'WEB-WORDPRESS-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/wordpress.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'CMS', 'provider' => 'WordPress', 'open_source' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Webflow',
                'description' => 'Webflow 是視覺化網站建設平台，讓設計師能夠設計、建立和啟動響應式網站，無需編寫程式碼。',
                'detail' => 'Webflow 結合了設計自由度和開發功能，提供視覺化編輯器、CMS 功能、電子商務整合和託管服務，是現代網站設計的理想工具。',
                'price' => 12.00,
                'rating' => 4.5,
                'stock' => 999,
                'category' => '網站建設',
                'sku' => 'WEB-WEBFLOW-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/webflow.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Website Builder', 'provider' => 'Webflow', 'visual_editor' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Squarespace',
                'description' => 'Squarespace 是一體化網站建設平台，提供美觀的模板和強大的功能，適合創意專業人士和小型企業。',
                'detail' => 'Squarespace 提供專業設計的模板、拖拽式編輯器、電子商務功能、部落格工具和分析功能，讓用戶能夠輕鬆建立專業網站。',
                'price' => 12.00,
                'rating' => 4.4,
                'stock' => 999,
                'category' => '網站建設',
                'sku' => 'WEB-SQUARESPACE-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/squarespace.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Website Builder', 'provider' => 'Squarespace', 'template_based' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 物聯網分類 (Internet of Things - 46 apps)
            [
                'name' => 'IFTTT',
                'description' => 'IFTTT (If This Then That) 是簡單的自動化平台，連接各種應用程式、裝置和服務，創建簡單的自動化規則。',
                'detail' => 'IFTTT 提供直觀的自動化功能，支援數百種服務和智慧裝置，讓用戶能夠創建簡單的「如果...那麼...」規則來自動化日常任務。',
                'price' => 0.00,
                'rating' => 4.3,
                'stock' => 999,
                'category' => '物聯網',
                'sku' => 'IOT-IFTTT-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/ifttt.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Automation', 'provider' => 'IFTTT', 'simple_rules' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'SmartThings',
                'description' => 'Samsung SmartThings 是智慧家居平台，連接和控制各種智慧裝置，創建智慧家居生態系統。',
                'detail' => 'SmartThings 支援數千種智慧裝置，提供統一的控制介面、自動化場景和遠端監控功能，是智慧家居的核心平台。',
                'price' => 0.00,
                'rating' => 4.2,
                'stock' => 999,
                'category' => '物聯網',
                'sku' => 'IOT-SMARTTHINGS-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/smartthings.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Smart Home', 'provider' => 'Samsung', 'device_control' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 生活娛樂分類 (Lifestyle & Entertainment - 49 apps)
            [
                'name' => 'Spotify',
                'description' => 'Spotify 是全球領先的音樂串流平台，提供數百萬首歌曲、播客和音頻內容，支援個人化推薦。',
                'detail' => 'Spotify 提供高品質音樂串流、個人化播放清單、播客內容、社交分享功能和跨裝置同步，是音樂愛好者的首選平台。',
                'price' => 0.00,
                'rating' => 4.7,
                'stock' => 999,
                'category' => '生活娛樂',
                'sku' => 'ENT-SPOTIFY-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/spotify.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Music Streaming', 'provider' => 'Spotify', 'personalized' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Netflix',
                'description' => 'Netflix 是全球最大的影片串流平台，提供電影、電視劇、紀錄片和原創內容，支援多裝置觀看。',
                'detail' => 'Netflix 提供豐富的影片內容庫、個人化推薦、離線下載、多用戶檔案和高畫質串流，是家庭娛樂的首選平台。',
                'price' => 15.99,
                'rating' => 4.5,
                'stock' => 999,
                'category' => '生活娛樂',
                'sku' => 'ENT-NETFLIX-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/netflix.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Video Streaming', 'provider' => 'Netflix', 'original_content' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Strava',
                'description' => 'Strava 是運動追蹤和社交平台，讓跑步者和騎行者記錄活動、分析表現和與朋友競爭。',
                'detail' => 'Strava 提供 GPS 追蹤、表現分析、社交功能、挑戰活動和路線規劃，是運動愛好者分享和改善表現的理想平台。',
                'price' => 0.00,
                'rating' => 4.4,
                'stock' => 999,
                'category' => '生活娛樂',
                'sku' => 'ENT-STRAVA-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/strava.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Fitness Tracking', 'provider' => 'Strava', 'social_features' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 教育分類 (Education)
            [
                'name' => 'Google Classroom',
                'description' => 'Google Classroom 是免費的教育平台，幫助教師創建、分發和評分作業，促進師生之間的協作。',
                'detail' => 'Google Classroom 整合 Google Workspace for Education，提供作業管理、成績追蹤、班級溝通和資源分享功能，簡化教學流程。',
                'price' => 0.00,
                'rating' => 4.6,
                'stock' => 999,
                'category' => '教育',
                'sku' => 'EDU-CLASSROOM-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/google-classroom.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Education Platform', 'provider' => 'Google', 'free_for_education' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Coursera',
                'description' => 'Coursera 是線上學習平台，與頂尖大學和公司合作，提供課程、專業證書和學位課程。',
                'detail' => 'Coursera 提供來自史丹佛、耶魯等知名大學的課程，涵蓋技術、商業、藝術等領域，支援證書認證和學位課程。',
                'price' => 39.00,
                'rating' => 4.5,
                'stock' => 999,
                'category' => '教育',
                'sku' => 'EDU-COURSERA-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/coursera.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Online Learning', 'provider' => 'Coursera', 'university_partnerships' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Khan Academy',
                'description' => 'Khan Academy 是免費的線上教育平台，提供數學、科學、程式設計等科目的互動式學習內容。',
                'detail' => 'Khan Academy 提供個人化學習體驗、練習題、影片教學和進度追蹤，致力於為全世界提供免費的優質教育。',
                'price' => 0.00,
                'rating' => 4.8,
                'stock' => 999,
                'category' => '教育',
                'sku' => 'EDU-KHAN-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/khan-academy.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Free Education', 'provider' => 'Khan Academy', 'interactive_learning' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 安全工具分類 (Security & Identity Tools)
            [
                'name' => '1Password',
                'description' => '1Password 是領先的密碼管理器，幫助個人和企業安全地儲存和管理密碼、信用卡和敏感資訊。',
                'detail' => '1Password 提供強大的加密技術、自動填入功能、安全共享、雙重驗證和跨平台同步，是保護數位身份的首選工具。',
                'price' => 2.99,
                'rating' => 4.7,
                'stock' => 999,
                'category' => '安全工具',
                'sku' => 'SEC-1PASSWORD-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/1password.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Password Manager', 'provider' => '1Password', 'enterprise_ready' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'LastPass',
                'description' => 'LastPass 是密碼管理和數位保險庫解決方案，幫助用戶生成、儲存和自動填入強密碼。',
                'detail' => 'LastPass 提供密碼生成、安全儲存、自動填入、安全共享和多重驗證功能，保護用戶的數位身份和敏感資訊。',
                'price' => 3.00,
                'rating' => 4.4,
                'stock' => 999,
                'category' => '安全工具',
                'sku' => 'SEC-LASTPASS-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/lastpass.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Password Manager', 'provider' => 'LastPass', 'vault_security' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 資料庫分類 (Databases)
            [
                'name' => 'MongoDB',
                'description' => 'MongoDB 是領先的 NoSQL 資料庫，提供靈活的文件導向資料模型，適合現代應用程式開發。',
                'detail' => 'MongoDB 提供高性能、高可用性和易擴展的資料庫解決方案，支援複雜查詢、索引和聚合操作，是現代應用程式的理想選擇。',
                'price' => 0.00,
                'rating' => 4.5,
                'stock' => 999,
                'category' => '資料庫',
                'sku' => 'DB-MONGODB-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/mongodb.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'NoSQL Database', 'provider' => 'MongoDB', 'document_oriented' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'PostgreSQL',
                'description' => 'PostgreSQL 是先進的開源關聯式資料庫，以其可靠性、功能豐富性和標準合規性而聞名。',
                'detail' => 'PostgreSQL 支援 SQL 和 JSON 查詢、全文搜尋、地理資訊系統和自訂資料類型，是企業級應用程式的強大資料庫選擇。',
                'price' => 0.00,
                'rating' => 4.6,
                'stock' => 999,
                'category' => '資料庫',
                'sku' => 'DB-POSTGRESQL-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/postgresql.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'SQL Database', 'provider' => 'PostgreSQL', 'open_source' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Redis',
                'description' => 'Redis 是高性能的記憶體資料結構儲存系統，用作資料庫、快取和訊息代理。',
                'detail' => 'Redis 提供極快的讀寫速度、豐富的資料結構、持久化選項和高可用性配置，是現代應用程式架構的重要組件。',
                'price' => 0.00,
                'rating' => 4.7,
                'stock' => 999,
                'category' => '資料庫',
                'sku' => 'DB-REDIS-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/redis.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'In-Memory Database', 'provider' => 'Redis', 'high_performance' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // 更多熱門應用程式
            [
                'name' => 'Microsoft Excel',
                'description' => 'Microsoft Excel 是世界上最受歡迎的試算表應用程式，提供強大的資料分析、圖表製作和公式計算功能。',
                'detail' => 'Excel 提供進階的資料分析工具、樞紐分析表、巨集功能、協作編輯和雲端同步，是商業分析和財務管理的標準工具。',
                'price' => 6.99,
                'rating' => 4.5,
                'stock' => 999,
                'category' => '生產力',
                'sku' => 'PROD-EXCEL-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/microsoft-excel.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Spreadsheet', 'provider' => 'Microsoft', 'advanced_analytics' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Microsoft Word',
                'description' => 'Microsoft Word 是領先的文字處理軟體，提供專業的文件創建、編輯和格式化功能。',
                'detail' => 'Word 提供豐富的格式化選項、協作編輯、範本庫、拼字檢查、追蹤修訂和雲端同步功能，是文件處理的業界標準。',
                'price' => 6.99,
                'rating' => 4.4,
                'stock' => 999,
                'category' => '生產力',
                'sku' => 'PROD-WORD-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/microsoft-word.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Word Processor', 'provider' => 'Microsoft', 'collaboration' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Microsoft PowerPoint',
                'description' => 'Microsoft PowerPoint 是專業的簡報軟體，幫助用戶創建引人注目的簡報和演示文稿。',
                'detail' => 'PowerPoint 提供豐富的設計範本、動畫效果、多媒體整合、協作功能和演講者工具，是商業簡報的首選工具。',
                'price' => 6.99,
                'rating' => 4.3,
                'stock' => 999,
                'category' => '生產力',
                'sku' => 'PROD-POWERPOINT-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/microsoft-powerpoint.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Presentation', 'provider' => 'Microsoft', 'multimedia_support' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Adobe Photoshop',
                'description' => 'Adobe Photoshop 是世界領先的影像編輯軟體，提供專業的照片編輯、數位藝術創作和設計功能。',
                'detail' => 'Photoshop 提供強大的圖層系統、濾鏡效果、色彩校正、選取工具和 AI 功能，是創意專業人士的必備工具。',
                'price' => 20.99,
                'rating' => 4.6,
                'stock' => 999,
                'category' => '設計工具',
                'sku' => 'DESIGN-PHOTOSHOP-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/adobe-photoshop.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Image Editor', 'provider' => 'Adobe', 'professional_grade' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Adobe Illustrator',
                'description' => 'Adobe Illustrator 是專業的向量圖形設計軟體，用於創建標誌、插圖、圖標和複雜的藝術作品。',
                'detail' => 'Illustrator 提供精確的向量繪圖工具、文字處理、色彩管理和輸出選項，是平面設計師和插畫師的核心工具。',
                'price' => 20.99,
                'rating' => 4.5,
                'stock' => 999,
                'category' => '設計工具',
                'sku' => 'DESIGN-ILLUSTRATOR-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/adobe-illustrator.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Vector Graphics', 'provider' => 'Adobe', 'professional_design' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Figma',
                'description' => 'Figma 是基於雲端的設計工具，專為 UI/UX 設計師打造，支援即時協作和原型製作。',
                'detail' => 'Figma 提供向量編輯、原型製作、設計系統、即時協作和開發者交接功能，是現代產品設計團隊的首選工具。',
                'price' => 0.00,
                'rating' => 4.7,
                'stock' => 999,
                'category' => '設計工具',
                'sku' => 'DESIGN-FIGMA-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/figma.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'UI/UX Design', 'provider' => 'Figma', 'real_time_collaboration' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Sketch',
                'description' => 'Sketch 是專為數位設計打造的向量圖形編輯器，廣泛用於 UI/UX 設計和網頁設計。',
                'detail' => 'Sketch 提供直觀的設計工具、符號系統、外掛程式生態系統和設計規範輸出，是 Mac 平台上的設計標準工具。',
                'price' => 9.00,
                'rating' => 4.4,
                'stock' => 999,
                'category' => '設計工具',
                'sku' => 'DESIGN-SKETCH-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/sketch.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Digital Design', 'provider' => 'Sketch', 'mac_exclusive' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Twilio',
                'description' => 'Twilio 是雲端通訊平台，提供 SMS、語音通話、視訊和電子郵件 API，讓開發者能夠在應用程式中整合通訊功能。',
                'detail' => 'Twilio 提供可靠的通訊 API、全球覆蓋、可擴展的基礎設施和豐富的開發工具，是現代應用程式通訊的首選平台。',
                'price' => 0.00,
                'rating' => 4.5,
                'stock' => 999,
                'category' => '溝通',
                'sku' => 'COMM-TWILIO-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/twilio.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Communication API', 'provider' => 'Twilio', 'developer_focused' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'SendGrid',
                'description' => 'SendGrid 是雲端電子郵件服務，提供可靠的電子郵件傳送、分析和管理功能，適合各種規模的企業。',
                'detail' => 'SendGrid 提供高傳送率、詳細分析、範本管理、A/B 測試和反垃圾郵件保護，是電子郵件行銷和交易郵件的理想選擇。',
                'price' => 0.00,
                'rating' => 4.4,
                'stock' => 999,
                'category' => '行銷',
                'sku' => 'MKT-SENDGRID-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/sendgrid.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Email Service', 'provider' => 'SendGrid', 'high_deliverability' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ConvertKit',
                'description' => 'ConvertKit 是專為創作者設計的電子郵件行銷平台，提供自動化、標籤系統和受眾分群功能。',
                'detail' => 'ConvertKit 提供視覺化自動化、進階分群、登陸頁面建立器和詳細分析，幫助創作者建立和維護與受眾的關係。',
                'price' => 29.00,
                'rating' => 4.6,
                'stock' => 999,
                'category' => '行銷',
                'sku' => 'MKT-CONVERTKIT-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/convertkit.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Email Marketing', 'provider' => 'ConvertKit', 'creator_focused' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'ActiveCampaign',
                'description' => 'ActiveCampaign 是全方位的客戶體驗自動化平台，結合電子郵件行銷、行銷自動化和 CRM 功能。',
                'detail' => 'ActiveCampaign 提供智能自動化、行為追蹤、預測分析、CRM 整合和多通道行銷，幫助企業提供個人化的客戶體驗。',
                'price' => 9.00,
                'rating' => 4.5,
                'stock' => 999,
                'category' => '行銷',
                'sku' => 'MKT-ACTIVECAMPAIGN-001',
                'status' => 'active',
                'images' => json_encode(['https://zapier-images.imgix.net/storage/services/activecampaign.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300']),
                'attributes' => json_encode(['type' => 'Marketing Automation', 'provider' => 'ActiveCampaign', 'customer_experience' => true]),
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        // 插入新應用程式
        DB::beginTransaction();
        
        try {
            foreach ($newApps as $app) {
                DB::table('products')->insert($app);
            }
            
            DB::commit();
            
            $newCount = DB::table('products')->count();
            $addedCount = $newCount - $currentCount;
            
            $this->info("\n🎉 應用程式擴展完成！");
            $this->info("📊 新增應用程式數量: {$addedCount}");
            $this->info("📊 總應用程式數量: {$newCount}");
            
            // 顯示最終分類統計
            $this->info("\n📂 最終分類統計:");
            $categories = DB::table('products')
                ->select('category', DB::raw('COUNT(*) as count'))
                ->groupBy('category')
                ->orderBy('count', 'desc')
                ->get();
                
            foreach ($categories as $category) {
                $this->line("  • {$category->category}: {$category->count} 個產品");
            }
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ 應用程式擴展失敗: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
