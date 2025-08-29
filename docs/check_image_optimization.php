<?php

require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$products = DB::table('products')->select('id', 'name', 'images')->orderBy('id')->get();

echo "🎯 檢查圖片優化結果:\n";
echo "=" . str_repeat('=', 80) . "\n";

// 統計圖片 URL 使用情況
$imageUrlCount = [];
foreach ($products as $product) {
    $images = json_decode($product->images, true);
    if (!$images) $images = [];
    $imageUrl = isset($images[0]) ? $images[0] : 'No image';
    
    if (!isset($imageUrlCount[$imageUrl])) {
        $imageUrlCount[$imageUrl] = [];
    }
    $imageUrlCount[$imageUrl][] = [
        'id' => $product->id,
        'name' => $product->name
    ];
}

echo "• 總應用程式數量: " . $products->count() . " 個\n";
echo "• 獨特圖片 URL 數量: " . count($imageUrlCount) . " 個\n";

// 檢查是否還有備用圖片
$backupImageUrl = 'https://zapier-images.imgix.net/storage/services/6aafbb717d42f8b42f5be2e4e89e1a15.png?auto=format&ixlib=react-9.10.0&q=50&fit=crop&h=300&w=300';
$backupCount = isset($imageUrlCount[$backupImageUrl]) ? count($imageUrlCount[$backupImageUrl]) : 0;
echo "• 仍使用備用圖片: $backupCount 個應用程式\n";

// 檢查圖片格式
$correctFormatCount = 0;
foreach ($products as $product) {
    $images = json_decode($product->images, true);
    if (!$images) $images = [];
    $imageUrl = isset($images[0]) ? $images[0] : '';
    
    if (strpos($imageUrl, 'h=300&w=300') !== false) {
        $correctFormatCount++;
    }
}
echo "• 使用正確格式 (h=300&w=300): $correctFormatCount 個應用程式\n";

echo "\n📊 圖片重複使用統計 (使用次數 > 1):\n";
echo str_repeat('-', 80) . "\n";

$duplicateCount = 0;
$totalDuplicateApps = 0;

arsort($imageUrlCount);
foreach ($imageUrlCount as $url => $apps) {
    $count = count($apps);
    if ($count > 1) {
        $duplicateCount++;
        $totalDuplicateApps += $count;
        
        // 提取圖片 ID
        preg_match('/\/([a-f0-9_]+)\.png/', $url, $matches);
        $imageId = isset($matches[1]) ? substr($matches[1], 0, 20) . '...' : 'unknown';
        
        echo "🔄 使用 $count 次 (圖片 ID: $imageId):\n";
        foreach ($apps as $app) {
            echo "   • ID {$app['id']}: {$app['name']}\n";
        }
        echo "\n";
    }
}

echo str_repeat('=', 80) . "\n";
echo "📈 優化結果總結:\n";
echo "• 重複使用的圖片數量: $duplicateCount 個\n";
echo "• 涉及重複的應用程式: $totalDuplicateApps 個\n";
echo "• 獨特圖片比例: " . round((count($imageUrlCount) / $products->count()) * 100, 1) . "%\n";

if ($duplicateCount == 0) {
    echo "🎉 太好了！所有應用程式都有專屬的圖片！\n";
} else {
    echo "⚠️  仍有 $duplicateCount 個圖片被多個應用程式使用\n";
}

echo str_repeat('=', 80) . "\n";
