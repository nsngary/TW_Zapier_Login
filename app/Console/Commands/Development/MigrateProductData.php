<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class MigrateProductData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:product-data {--force : Force migration without confirmation}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '將舊的 product 資料表資料移植到新的 products 資料表';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->option('force') && !$this->confirm('確定要移植產品資料嗎？這將會清空現有的 products 資料表。')) {
            $this->info('操作已取消。');
            return;
        }

        $this->info('開始移植產品資料...');

        try {
            // 清空現有的 products 資料表
            DB::table('products')->truncate();
            $this->info('已清空 products 資料表');

            // 取得舊產品資料
            $oldProducts = DB::table('product')->get();
            $this->info("找到 {$oldProducts->count()} 筆舊產品資料");

            $bar = $this->output->createProgressBar($oldProducts->count());
            $bar->start();

            foreach ($oldProducts as $oldProduct) {
                // 取得分類名稱
                $categoryName = $this->getCategoryName($oldProduct->classid);

                // 轉換狀態
                $status = $this->convertStatus($oldProduct->p_open);

                // 建立新產品記錄
                Product::create([
                    'id' => $oldProduct->p_id,
                    'name' => $oldProduct->p_name,
                    'description' => $oldProduct->p_intro,
                    'detail' => $oldProduct->p_content,
                    'price' => $oldProduct->p_price / 100, // 假設舊資料是以分為單位
                    'stock' => 0, // 預設庫存為 0
                    'category' => $categoryName,
                    'sku' => 'SKU-' . str_pad($oldProduct->p_id, 6, '0', STR_PAD_LEFT),
                    'status' => $status,
                    'images' => $this->getProductImages($oldProduct->p_id),
                    'created_by' => 'system',
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info('產品資料移植完成！');

            // 顯示統計資訊
            $newCount = Product::count();
            $this->info("成功移植 {$newCount} 筆產品資料");

        } catch (\Exception $e) {
            $this->error('移植過程中發生錯誤：' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * 取得分類名稱
     */
    private function getCategoryName($classid)
    {
        if (!$classid) {
            return null;
        }

        $category = DB::table('pyclass')->where('classid', $classid)->first();
        return $category ? $category->cname : "分類-{$classid}";
    }

    /**
     * 轉換狀態
     */
    private function convertStatus($p_open)
    {
        switch ($p_open) {
            case 'active':
                return 'active';
            case 'inactive':
                return 'inactive';
            case 'discontinued':
                return 'discontinued';
            default:
                return 'active';
        }
    }

    /**
     * 取得產品圖片
     */
    private function getProductImages($productId)
    {
        $images = DB::table('product_img')
            ->where('p_id', $productId)
            ->orderBy('sort')
            ->pluck('img_file')
            ->toArray();

        // 轉換圖片路徑格式
        return array_map(function($image) {
            return 'products/' . $image;
        }, $images);
    }
}
