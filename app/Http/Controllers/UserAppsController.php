<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserAppsController extends Controller
{
    /**
     * 顯示用戶端應用程式列表頁面
     */
    public function index(Request $request)
    {
        // 獲取搜尋和篩選參數
        $search = $request->get('search');
        $category = $request->get('category');

        // 建立查詢
        $query = DB::table('products')
            ->where('status', 'active');

        // 搜尋功能
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // 分類篩選
        if ($category && $category !== 'all') {
            $query->where('category', $category);
        }

        // 獲取應用程式資料
        $apps = $query->orderBy('name')
            ->paginate(12)
            ->appends($request->query());

        // 獲取所有分類
        $categories = DB::table('products')
            ->select('category')
            ->where('status', 'active')
            ->groupBy('category')
            ->orderBy('category')
            ->pluck('category');

        // 獲取分類統計
        $categoryStats = DB::table('products')
            ->select('category', DB::raw('count(*) as count'))
            ->where('status', 'active')
            ->groupBy('category')
            ->pluck('count', 'category');

        return view('user.apps.index', compact('apps', 'categories', 'categoryStats', 'search', 'category'));
    }

    /**
     * 顯示應用程式詳情頁面
     */
    public function show($id)
    {
        $app = DB::table('products')
            ->where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$app) {
            abort(404, '應用程式不存在');
        }

        // 解析圖片 JSON
        $app->images = json_decode($app->images, true) ?: [];

        // 獲取相關應用程式（同分類）
        $relatedApps = DB::table('products')
            ->where('category', $app->category)
            ->where('id', '!=', $id)
            ->where('status', 'active')
            ->limit(6)
            ->get();

        return view('user.apps.show', compact('app', 'relatedApps'));
    }

    /**
     * 顯示應用程式整合詳情頁面
     */
    public function integrations($id)
    {
        $app = DB::table('products')
            ->where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$app) {
            abort(404, '應用程式不存在');
        }

        // 解析圖片 JSON
        $app->images = json_decode($app->images, true) ?: [];

        // 獲取其他熱門應用程式用於整合示例
        $popularApps = DB::table('products')
            ->where('id', '!=', $id)
            ->where('status', 'active')
            ->orderBy('price') // 免費的排前面
            ->limit(8)
            ->get();

        return view('user.apps.integrations', compact('app', 'popularApps'));
    }
}
