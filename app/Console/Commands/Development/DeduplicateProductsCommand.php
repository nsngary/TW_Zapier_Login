<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DeduplicateProductsCommand extends Command
{
    protected $signature = 'products:deduplicate';
    protected $description = '去除重複的產品記錄';

    public function handle()
    {
        $this->info('🔍 檢查重複產品...');
        
        // 檢查完全重複的產品名稱
        $exactDuplicates = DB::table('products')
            ->select('name', DB::raw('COUNT(*) as count'), DB::raw('GROUP_CONCAT(id) as ids'))
            ->groupBy('name')
            ->having('count', '>', 1)
            ->get();
            
        // 檢查相似的產品（基於名稱相似性）
        $allProducts = DB::table('products')->select('id', 'name', 'category')->get();
        $similarProducts = [];
        
        foreach ($allProducts as $product1) {
            foreach ($allProducts as $product2) {
                if ($product1->id >= $product2->id) continue;
                
                // 檢查名稱相似性
                if ($this->isSimilar($product1->name, $product2->name)) {
                    $similarProducts[] = [
                        'product1' => $product1,
                        'product2' => $product2,
                        'similarity' => $this->calculateSimilarity($product1->name, $product2->name)
                    ];
                }
            }
        }
        
        $this->info("\n📊 重複檢查結果:");
        $this->line("  • 完全重複的產品名稱: " . $exactDuplicates->count());
        $this->line("  • 相似的產品: " . count($similarProducts));
        
        if ($exactDuplicates->count() > 0) {
            $this->warn("\n⚠️  發現完全重複的產品:");
            foreach ($exactDuplicates as $duplicate) {
                $this->line("  • {$duplicate->name}: {$duplicate->count} 筆記錄 (IDs: {$duplicate->ids})");
            }
        }
        
        if (count($similarProducts) > 0) {
            $this->warn("\n⚠️  發現相似的產品:");
            foreach ($similarProducts as $similar) {
                $similarity = number_format($similar['similarity'] * 100, 1);
                $this->line("  • {$similar['product1']->name} ≈ {$similar['product2']->name} ({$similarity}% 相似)");
            }
        }
        
        // 如果沒有重複，直接返回
        if ($exactDuplicates->count() == 0 && count($similarProducts) == 0) {
            $this->info("\n✅ 沒有發現重複或相似的產品！");
            return 0;
        }
        
        // 確認是否進行去重
        if (!$this->confirm('是否要進行自動去重處理？')) {
            $this->info('操作已取消');
            return 0;
        }
        
        DB::beginTransaction();
        
        try {
            $removedCount = 0;
            
            // 處理完全重複的產品
            foreach ($exactDuplicates as $duplicate) {
                $ids = explode(',', $duplicate->ids);
                $keepId = min($ids); // 保留最小的ID
                $removeIds = array_filter($ids, function($id) use ($keepId) {
                    return $id != $keepId;
                });
                
                if (count($removeIds) > 0) {
                    DB::table('products')->whereIn('id', $removeIds)->delete();
                    $removedCount += count($removeIds);
                    $this->info("✅ 保留產品 ID {$keepId}，刪除重複記錄: " . implode(', ', $removeIds));
                }
            }
            
            // 處理相似產品（需要手動確認）
            foreach ($similarProducts as $similar) {
                $product1 = $similar['product1'];
                $product2 = $similar['product2'];
                
                $this->line("\n比較相似產品:");
                $this->line("  1. [{$product1->id}] {$product1->name} ({$product1->category})");
                $this->line("  2. [{$product2->id}] {$product2->name} ({$product2->category})");
                
                $choice = $this->choice('選擇要保留的產品 (或跳過)', [
                    '1' => "保留產品 1: {$product1->name}",
                    '2' => "保留產品 2: {$product2->name}",
                    'skip' => '跳過，保留兩個產品'
                ], 'skip');
                
                if ($choice === '1') {
                    DB::table('products')->where('id', $product2->id)->delete();
                    $removedCount++;
                    $this->info("✅ 刪除產品: {$product2->name}");
                } elseif ($choice === '2') {
                    DB::table('products')->where('id', $product1->id)->delete();
                    $removedCount++;
                    $this->info("✅ 刪除產品: {$product1->name}");
                }
            }
            
            DB::commit();
            
            $this->info("\n🎉 去重完成！");
            $this->info("📊 總共刪除了 {$removedCount} 個重複產品");
            
            // 顯示最終統計
            $finalCount = DB::table('products')->count();
            $this->info("📊 剩餘產品數量: {$finalCount}");
            
        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ 去重失敗: " . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
    
    private function isSimilar($name1, $name2)
    {
        return $this->calculateSimilarity($name1, $name2) > 0.7;
    }
    
    private function calculateSimilarity($name1, $name2)
    {
        // 簡單的字符串相似度計算
        $name1 = strtolower(trim($name1));
        $name2 = strtolower(trim($name2));
        
        if ($name1 === $name2) return 1.0;
        
        // 使用 Levenshtein 距離計算相似度
        $maxLen = max(strlen($name1), strlen($name2));
        if ($maxLen == 0) return 1.0;
        
        $distance = levenshtein($name1, $name2);
        return 1 - ($distance / $maxLen);
    }
}
