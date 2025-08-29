<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class StandardizeCategoriesCommand extends Command
{
    protected $signature = 'products:standardize-categories';
    protected $description = '標準化產品分類';

    // 分類對應表
    private $categoryMapping = [
        // 生產力相關
        '生產力工具' => '生產力',
        '生產力' => '生產力',
        
        // 溝通相關
        '通訊協作' => '溝通',
        '溝通' => '溝通',
        
        // 銷售相關
        '銷售與客戶關係管理' => '銷售與CRM',
        '銷售與CRM' => '銷售與CRM',
        
        // 行銷相關
        '行銷推廣' => '行銷',
        '行銷' => '行銷',
        
        // 檔案管理相關
        '內容與檔案管理' => '檔案管理',
        '檔案管理' => '檔案管理',
        
        // IT工具相關
        'IT 營運工具' => '開發工具',
        '開發工具' => '開發工具',
        
        // 其他分類保持不變
        '人工智慧' => '人工智慧',
        '商業智慧' => '商業智慧',
        '電子商務' => '電子商務',
        '客戶支援' => '客戶支援',
        '專案管理' => '專案管理',
        '會計' => '會計',
        '人力資源' => '人力資源',
    ];

    public function handle()
    {
        $this->info('🔄 開始標準化產品分類...');
        
        // 顯示分類對應表
        $this->info("\n📋 分類對應表:");
        foreach ($this->categoryMapping as $old => $new) {
            if ($old !== $new) {
                $this->line("  • {$old} → {$new}");
            }
        }
        
        // 確認是否繼續
        if (!$this->confirm('是否繼續執行分類標準化？')) {
            $this->info('操作已取消');
            return 0;
        }
        
        DB::beginTransaction();
        
        try {
            $updatedCount = 0;
            
            foreach ($this->categoryMapping as $oldCategory => $newCategory) {
                if ($oldCategory !== $newCategory) {
                    $count = DB::table('products')
                        ->where('category', $oldCategory)
                        ->update(['category' => $newCategory]);
                    
                    if ($count > 0) {
                        $this->info("✅ 更新 {$count} 個產品：{$oldCategory} → {$newCategory}");
                        $updatedCount += $count;
                    }
                }
            }
            
            DB::commit();
            
            $this->info("\n🎉 分類標準化完成！");
            $this->info("📊 總共更新了 {$updatedCount} 個產品的分類");
            
            // 顯示標準化後的分類統計
            $this->info("\n📂 標準化後的分類統計:");
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
            $this->error("❌ 分類標準化失敗: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
