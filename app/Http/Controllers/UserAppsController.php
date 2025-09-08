<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\CartsList;
use App\Models\Product;
use App\Models\User;

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

        // 獲取用戶收藏狀態
        $userWishlist = [];
        $account = Session::get('admin_account');
        if ($account) {
            $user = User::where('account', $account)->first();
            if ($user) {
                $userWishlist = Cart::where('user_id', $user->id)
                    ->pluck('product_id')
                    ->toArray();
            }
        }

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

        return view('user.apps.index', compact('apps', 'categories', 'categoryStats', 'search', 'category', 'userWishlist'));
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

        // 檢查用戶是否已收藏此應用程式
        $isWishlisted = false;
        $account = Session::get('admin_account');
        if ($account) {
            $user = User::where('account', $account)->first();
            if ($user) {
                $isWishlisted = Cart::where('user_id', $user->id)
                    ->where('product_id', $id)
                    ->exists();
            }
        }

        // 獲取相關應用程式（同分類）
        $relatedApps = DB::table('products')
            ->where('category', $app->category)
            ->where('id', '!=', $id)
            ->where('status', 'active')
            ->limit(6)
            ->get();

        return view('user.apps.show', compact('app', 'relatedApps', 'isWishlisted'));
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

    /**
     * 加入產品到心願清單
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // 使用 Session 獲取用戶帳號，然後查找用戶 ID
        $account = Session::get('admin_account');
        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => '請先登入'
            ], 401);
        }

        $user = User::where('account', $account)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => '用戶不存在'
            ], 404);
        }

        $userId = $user->id;
        $productId = $request->product_id;

        // 檢查產品是否為 active 狀態
        $product = Product::where('id', $productId)
            ->where('status', 'active')
            ->first();

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => '產品不存在或已下架'
            ], 404);
        }

        // 檢查是否已在心願清單中
        $existingCart = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($existingCart) {
            return response()->json([
                'success' => false,
                'message' => '此產品已在您的心願清單中'
            ], 409);
        }

        // 加入心願清單
        try {
            Cart::create([
                'user_id' => $userId,
                'product_id' => $productId
            ]);

            return response()->json([
                'success' => true,
                'message' => '已成功加入心願清單'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '加入失敗，請稍後再試'
            ], 500);
        }
    }

    /**
     * 從心願清單移除產品
     */
    public function removeFromCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // 使用 Session 獲取用戶帳號，然後查找用戶 ID
        $account = Session::get('admin_account');
        if (!$account) {
            return response()->json([
                'success' => false,
                'message' => '請先登入'
            ], 401);
        }

        $user = User::where('account', $account)->first();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => '用戶不存在'
            ], 404);
        }

        $userId = $user->id;
        $productId = $request->product_id;

        try {
            $deleted = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'success' => true,
                    'message' => '已從心願清單移除'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '產品不在心願清單中'
                ], 404);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '移除失敗，請稍後再試'
            ], 500);
        }
    }

    /**
     * 顯示心願清單頁面
     */
    public function cart()
    {
        // 使用 Session 獲取用戶帳號，然後查找用戶 ID
        $account = Session::get('admin_account');
        if (!$account) {
            return redirect()->route('admin.login')->with('error', '請先登入');
        }

        $user = User::where('account', $account)->first();
        if (!$user) {
            return redirect()->route('admin.login')->with('error', '用戶不存在');
        }

        $userId = $user->id;

        $cartItems = Cart::byUser($userId)
            ->withProduct()
            ->get()
            ->filter(function ($cartItem) {
                return $cartItem->product !== null;
            });

        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price;
        });

        return view('user.cart.index', compact('cartItems', 'totalAmount'));
    }

    /**
     * 顯示結帳頁面
     */
    public function checkout()
    {
        // 使用 Session 獲取用戶帳號，然後查找用戶 ID
        $account = Session::get('admin_account');
        if (!$account) {
            return redirect()->route('admin.login')->with('error', '請先登入');
        }

        $user = User::where('account', $account)->first();
        if (!$user) {
            return redirect()->route('admin.login')->with('error', '用戶不存在');
        }

        $userId = $user->id;

        $cartItems = Cart::byUser($userId)
            ->withProduct()
            ->get()
            ->filter(function ($cartItem) {
                return $cartItem->product !== null;
            });

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', '您的心願清單是空的，無法進行結帳');
        }

        $totalAmount = $cartItems->sum(function ($cartItem) {
            return $cartItem->product->price;
        });

        return view('user.cart.checkout', compact('cartItems', 'totalAmount'));
    }

    /**
     * 處理結帳邏輯
     */
    public function processCheckout(Request $request)
    {
        // 使用 Session 獲取用戶帳號，然後查找用戶 ID
        $account = Session::get('admin_account');
        if (!$account) {
            return redirect()->route('admin.login')->with('error', '請先登入');
        }

        $user = User::where('account', $account)->first();
        if (!$user) {
            return redirect()->route('admin.login')->with('error', '用戶不存在');
        }

        $userId = $user->id;

        // 獲取心願清單項目
        $cartItems = Cart::byUser($userId)
            ->withProduct()
            ->get()
            ->filter(function ($cartItem) {
                return $cartItem->product !== null;
            });

        if ($cartItems->isEmpty()) {
            return redirect()->route('user.cart.index')
                ->with('error', '您的心願清單是空的，無法進行結帳');
        }

        try {
            DB::beginTransaction();

            // 準備產品資料快照
            $productData = $cartItems->map(function ($cartItem) {
                return [
                    'id' => $cartItem->product->id,
                    'name' => $cartItem->product->name,
                    'description' => $cartItem->product->description,
                    'price' => $cartItem->product->price,
                    'category' => $cartItem->product->category,
                    'sku' => $cartItem->product->sku,
                    'images' => $cartItem->product->images
                ];
            })->toArray();

            $totalAmount = $cartItems->sum(function ($cartItem) {
                return $cartItem->product->price;
            });

            // 生成訂單
            $order = CartsList::create([
                'order_number' => CartsList::generateOrderNumber(),
                'user_id' => $userId,
                'product_data' => $productData,
                'total_amount' => $totalAmount,
                'status' => 'completed'
            ]);

            // 清空心願清單
            Cart::where('user_id', $userId)->delete();

            DB::commit();

            return redirect()->route('user.cart.index')
                ->with('success', "結帳成功！訂單編號：{$order->order_number}");

        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('user.cart.checkout')
                ->with('error', '結帳失敗，請稍後再試');
        }
    }
}
