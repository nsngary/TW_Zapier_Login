<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductClass;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * 顯示產品管理列表
     */
    public function index(Request $request)
    {
        $query = Product::with(['mainImage', 'category', 'images']);

        // 搜尋功能
        if ($request->has('search') && !empty($request->search)) {
            $query->where('p_name', 'LIKE', "%{$request->search}%");
        }

        // 分類篩選
        if ($request->has('classid') && !empty($request->classid)) {
            $query->where('classid', $request->classid);
        }

        // 狀態篩選
        if ($request->has('status') && $request->status !== '') {
            $query->where('p_open', $request->status);
        }

        $products = $query->orderBy('p_id', 'desc')->paginate(15);
        $products->appends($request->query());

        $categories = ProductClass::orderBy('sort')->get();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * 顯示新增產品表單
     */
    public function create()
    {
        $categories = ProductClass::orderBy('sort')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * 儲存新產品
     */
    public function store(Request $request)
    {
        $request->validate([
            'p_name' => 'required|string|max:255',
            'p_intro' => 'nullable|string',
            'p_content' => 'nullable|string',
            'p_price' => 'required|numeric|min:0',
            'classid' => 'required|exists:pyclass,classid',
            'p_open' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product = Product::create([
            'p_name' => $request->p_name,
            'p_intro' => $request->p_intro,
            'p_content' => $request->p_content,
            'p_price' => $request->p_price,
            'classid' => $request->classid,
            'p_open' => $request->has('p_open') ? 1 : 0,
            'p_date' => now()
        ]);

        // 處理圖片上傳
        if ($request->hasFile('images')) {
            $this->handleImageUpload($product, $request->file('images'));
        }

        return redirect()->route('admin.products.index')
                        ->with('success', '產品新增成功！');
    }

    /**
     * 顯示產品詳情
     */
    public function show($id)
    {
        $product = Product::with(['images', 'category'])->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    /**
     * 顯示編輯產品表單
     */
    public function edit($id)
    {
        $product = Product::with(['images', 'category'])->findOrFail($id);
        $categories = ProductClass::orderBy('sort')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * 更新產品
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'p_name' => 'required|string|max:255',
            'p_intro' => 'nullable|string',
            'p_content' => 'nullable|string',
            'p_price' => 'required|numeric|min:0',
            'classid' => 'required|exists:pyclass,classid',
            'p_open' => 'boolean',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $product->update([
            'p_name' => $request->p_name,
            'p_intro' => $request->p_intro,
            'p_content' => $request->p_content,
            'p_price' => $request->p_price,
            'classid' => $request->classid,
            'p_open' => $request->has('p_open') ? 1 : 0
        ]);

        // 處理圖片上傳
        if ($request->hasFile('images')) {
            $this->handleImageUpload($product, $request->file('images'));
        }

        return redirect()->route('admin.products.index')
                        ->with('success', '產品更新成功！');
    }

    /**
     * 刪除產品
     */
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);

            // 刪除相關圖片
            foreach ($product->images as $image) {
                if (file_exists(public_path('product_img/' . $image->img_file))) {
                    unlink(public_path('product_img/' . $image->img_file));
                }
                $image->delete();
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
            ]);
        }
    }

    /**
     * 切換產品上下架狀態
     */
    public function toggleStatus($id)
    {
        try {
            $product = Product::findOrFail($id);
            $product->p_open = !$product->p_open;
            $product->save();

            $status = $product->p_open ? '上架' : '下架';

            return response()->json([
                'success' => true,
                'message' => "產品已{$status}！",
                'status' => $product->p_open
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '操作失敗：' . $e->getMessage()
            ]);
        }
    }

    /**
     * 產品維護頁面（僅能修改內容，不能上下架）
     */
    public function maintain(Request $request)
    {
        $query = Product::with(['mainImage', 'category', 'images'])
                       ->where('p_open', 1); // 只顯示已上架的產品

        // 搜尋功能
        if ($request->has('search') && !empty($request->search)) {
            $query->where('p_name', 'LIKE', "%{$request->search}%");
        }

        // 分類篩選
        if ($request->has('classid') && !empty($request->classid)) {
            $query->where('classid', $request->classid);
        }

        $products = $query->orderBy('p_id', 'desc')->paginate(15);
        $products->appends($request->query());

        $categories = ProductClass::orderBy('sort')->get();

        return view('admin.products.maintain', compact('products', 'categories'));
    }

    /**
     * 處理圖片上傳
     */
    private function handleImageUpload($product, $images)
    {
        $sort = ProductImage::where('p_id', $product->p_id)->max('sort') + 1;

        foreach ($images as $image) {
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('product_img'), $filename);

            ProductImage::create([
                'p_id' => $product->p_id,
                'img_file' => $filename,
                'sort' => $sort++
            ]);
        }
    }

    /**
     * 刪除產品圖片
     */
    public function deleteImage($imageId)
    {
        try {
            $image = ProductImage::findOrFail($imageId);

            // 刪除實體檔案
            if (file_exists(public_path('product_img/' . $image->img_file))) {
                unlink(public_path('product_img/' . $image->img_file));
            }

            $image->delete();

            return response()->json([
                'success' => true,
                'message' => '圖片刪除成功！'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刪除失敗：' . $e->getMessage()
            ]);
        }
    }
}
