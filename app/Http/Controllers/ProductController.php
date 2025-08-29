<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 顯示產品列表（管理後台）
     */
    public function index(Request $request)
    {
        // 檢查是否已登入
        if (!Session::has('admin_account')) {
            return redirect()->route('admin.login');
        }

        $query = Product::query();

        // 搜尋功能
        if ($request->has('search') && !empty($request->search)) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'LIKE', "%{$request->search}%")
                  ->orWhere('sku', 'LIKE', "%{$request->search}%")
                  ->orWhere('description', 'LIKE', "%{$request->search}%");
            });
        }

        // 分類篩選
        if ($request->has('category') && !empty($request->category)) {
            $query->byCategory($request->category);
        }

        // 狀態篩選
        if ($request->has('status') && !empty($request->status)) {
            $query->byStatus($request->status);
        }

        // 排序
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $products = $query->paginate(10);
        $products->appends($request->query());

        // 取得分類列表（用於篩選）
        $categories = Product::whereNotNull('category')->distinct()->pluck('category')->filter()->sort();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * 顯示新增產品表單
     */
    public function create()
    {
        if (!Session::has('admin_account')) {
            return redirect()->route('admin.login');
        }

        return view('admin.products.create');
    }

    /**
     * 儲存新產品
     */
    public function store(Request $request)
    {
        if (!Session::has('admin_account')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => '請先登入'], 401);
            }
            return redirect()->route('admin.login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'detail' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'sku' => 'nullable|string|unique:products,sku',
            'status' => 'required|in:active,inactive,discontinued',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        try {
            $productData = $request->only([
                'name', 'description', 'detail', 'price', 'stock',
                'category', 'sku', 'status'
            ]);

            $productData['created_by'] = Session::get('admin_account');

            // 處理圖片上傳
            if ($request->hasFile('images')) {
                $images = [];
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $images[] = $path;
                }
                $productData['images'] = $images;
            }

            $product = Product::create($productData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '產品新增成功！',
                    'product' => $product
                ]);
            }

            return redirect()->route('products.index')->with('success', '產品新增成功！');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '新增失敗：' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', '新增失敗：' . $e->getMessage())->withInput();
        }
    }

    /**
     * 顯示產品詳情
     */
    public function show($id)
    {
        if (!Session::has('admin_account')) {
            return redirect()->route('admin.login');
        }

        $product = Product::findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * 顯示編輯產品表單
     */
    public function edit($id)
    {
        if (!Session::has('admin_account')) {
            return redirect()->route('admin.login');
        }

        $product = Product::findOrFail($id);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * 更新產品
     */
    public function update(Request $request, $id)
    {
        if (!Session::has('admin_account')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => '請先登入'], 401);
            }
            return redirect()->route('admin.login');
        }

        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'detail' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'nullable|string|max:255',
            'sku' => 'nullable|string|unique:products,sku,' . $id,
            'status' => 'required|in:active,inactive,discontinued',
            'new_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deleted_images' => 'nullable|string',
            'main_image_index' => 'nullable|integer|min:0'
        ]);

        try {
            $productData = $request->only([
                'name', 'description', 'detail', 'price', 'stock',
                'category', 'sku', 'status'
            ]);

            $productData['updated_by'] = Session::get('admin_account');

            // 處理圖片更新
            $currentImages = $product->images ?: [];

            // 處理刪除的圖片
            if ($request->filled('deleted_images')) {
                $deletedImages = json_decode($request->deleted_images, true);
                if (is_array($deletedImages)) {
                    foreach ($deletedImages as $deletedImage) {
                        // 從檔案系統刪除
                        Storage::disk('public')->delete($deletedImage);
                        // 從陣列中移除
                        $currentImages = array_values(array_filter($currentImages, function($img) use ($deletedImage) {
                            return $img !== $deletedImage;
                        }));
                    }
                }
            }

            // 處理新上傳的圖片
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $image) {
                    $path = $image->store('products', 'public');
                    $currentImages[] = $path;
                }
            }

            // 處理主圖設定
            if ($request->filled('main_image_index') && isset($currentImages[$request->main_image_index])) {
                $mainImage = $currentImages[$request->main_image_index];
                // 將主圖移到陣列第一位
                $currentImages = array_values(array_filter($currentImages, function($img) use ($mainImage) {
                    return $img !== $mainImage;
                }));
                array_unshift($currentImages, $mainImage);
            }

            $productData['images'] = $currentImages;

            $product->update($productData);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '產品更新成功！',
                    'product' => $product
                ]);
            }

            return redirect()->route('products.index')->with('success', '產品更新成功！');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '更新失敗：' . $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', '更新失敗：' . $e->getMessage())->withInput();
        }
    }

    /**
     * 刪除產品
     */
    public function destroy($id)
    {
        if (!Session::has('admin_account')) {
            return response()->json(['success' => false, 'message' => '請先登入'], 401);
        }

        try {
            $product = Product::findOrFail($id);

            // 刪除產品圖片
            if ($product->images) {
                foreach ($product->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }

            $product->delete();

            return response()->json([
                'success' => true,
                'message' => '產品刪除成功！'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刪除失敗：' . $e->getMessage()
            ], 500);
        }
    }
}
