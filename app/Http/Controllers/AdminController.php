<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * 顯示管理員登入頁面
     */
    public function showLoginForm()
    {
        return view('partials.manage.login');
    }

    /**
     * 處理管理員登入
     */
    public function login(Request $request)
    {
        $request->validate([
            'account' => 'required|string',
            'password' => 'required|string',
        ]);

        $account = $request->account;
        $password = $request->password;

        // 查找用戶（不限制角色，讓所有用戶都能登入）
        $user = User::where('account', $account)->first();

        if (!$user) {
            return back()->withErrors(['account' => '帳號錯誤'])->withInput();
        }

        // 驗證密碼（使用 Hash::check 支援 bcrypt）
        if (!Hash::check($password, $user->password)) {
            return back()->withErrors(['password' => '密碼錯誤'])->withInput();
        }

        // 設定 session
        Session::put('admin_account', $user->account);
        Session::put('admin_username', $user->username);
        Session::put('sLogintime', now()->format('F j, Y, g:i a'));

        // 根據用戶角色跳轉到不同頁面
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.index'));
        } else {
            // 用戶角色跳轉到用戶端頁面
            return redirect()->intended('/user');
        }
    }

    /**
     * 管理員登出
     */
    public function logout(Request $request)
    {
        Session::forget(['admin_account', 'admin_username', 'sLogintime']);
        return redirect()->route('admin.login')->with('message', '已成功登出');
    }

    /**
     * 顯示管理員列表
     */
    public function index(Request $request)
    {
        // 檢查是否已登入
        if (!Session::has('admin_account')) {
            return redirect()->route('admin.login');
        }

        $currentAccount = Session::get('admin_account');
        $currentAdmin = User::where('account', $currentAccount)->where('role', 'admin')->first();

        if (!$currentAdmin) {
            return redirect()->route('admin.login');
        }

        // 權限控制：只有 admin 可以看到所有管理員，其他管理員只能看到自己
        if ($currentAccount === 'admin') {
            // admin 可以看到所有管理員
            $query = User::admins();
        } else {
            // 其他管理員只能看到自己
            $query = User::where('account', $currentAccount)->where('role', 'admin');
        }

        // 搜尋功能
        if ($request->has('Search') && !empty($request->Search)) {
            $query->search($request->Search);
        }

        $admins = $query->paginate(10);

        return view('partials.manage.admin', compact('admins', 'currentAdmin'));
    }

    /**
     * 顯示新增管理員表單
     */
    public function create()
    {
        if (!Session::has('admin_account')) {
            return redirect()->route('admin.login');
        }

        return view('partials.manage.admindetail');
    }

    /**
     * 儲存新管理員
     */
    public function store(Request $request)
    {
        // 調試信息
        \Log::info('Store method called', [
            'has_session' => Session::has('admin_account'),
            'expects_json' => $request->expectsJson(),
            'request_data' => $request->all()
        ]);

        if (!Session::has('admin_account')) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => '請先登入'], 401);
            }
            return redirect()->route('admin.login');
        }

        $currentAccount = Session::get('admin_account');

        // 權限控制：只有 admin 可以新增管理員
        if ($currentAccount !== 'admin') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => '您沒有權限新增管理員'], 403);
            }
            return redirect()->route('admin.index')->with('error', '您沒有權限新增管理員');
        }

        try {
            $request->validate([
                'account' => 'required|string|unique:users,account',
                'password' => 'required|string|min:3',
                'username' => 'required|string',
                'email' => 'nullable|email',
                'permissions' => 'nullable|array',
                'permissions.*' => 'string|in:s00,s01,s02,s03'
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '驗證失敗',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        }

        try {
            // 建立管理員
            $admin = User::create([
                'account' => $request->account,
                'password' => \Hash::make($request->password),
                'username' => $request->username,
                'name' => $request->username,
                'email' => $request->email ?: $request->account . '@admin.local',
                'role' => 'admin',
            ]);

            // 分配權限
            if ($request->has('permissions')) {
                foreach ($request->permissions as $permission) {
                    \App\Models\AdminPermission::create([
                        'account' => $request->account,
                        'sid' => $permission
                    ]);
                }
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => '管理員新增成功！',
                    'admin' => $admin
                ]);
            }

            return redirect()->route('admin.index')->with('success', '管理員新增成功！');
        } catch (\Exception $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => '新增失敗：' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('admin.index')->with('error', '新增失敗：' . $e->getMessage());
        }
    }

    /**
     * 顯示編輯管理員表單
     */
    public function edit($account)
    {
        if (!Session::has('admin_account')) {
            return redirect()->route('admin.login');
        }

        $currentAccount = Session::get('admin_account');

        // 權限控制：只有 admin 可以編輯所有管理員，其他管理員只能編輯自己
        if ($currentAccount !== 'admin' && $currentAccount !== $account) {
            return redirect()->route('admin.index')->with('error', '您只能編輯自己的資料');
        }

        $admin = User::where('account', $account)->where('role', 'admin')->firstOrFail();
        $currentAdmin = User::where('account', $currentAccount)->where('role', 'admin')->first();

        return view('partials.manage.admindetailu', compact('admin', 'currentAdmin'));
    }

    /**
     * 更新管理員資料
     */
    public function update(Request $request, $account)
    {
        if (!Session::has('admin_account')) {
            return redirect()->route('admin.login');
        }

        $admin = User::where('account', $account)->where('role', 'admin')->firstOrFail();

        $request->validate([
            'password' => 'nullable|string|min:3',
            'username' => 'required|string',
        ]);

        $updateData = [
            'username' => $request->username,
            'name' => $request->username,
        ];

        // 如果有提供新密碼才更新
        if (!empty($request->password)) {
            $updateData['password'] = \Hash::make($request->password);
        }

        $admin->update($updateData);

        return redirect()->route('admin.index')->with('success', '管理員資料更新成功！');
    }

    /**
     * 刪除管理員
     */
    public function destroy($account)
    {
        if (!Session::has('admin_account')) {
            return response()->json([
                'success' => false,
                'message' => '請先登入！'
            ]);
        }

        $currentAccount = Session::get('admin_account');

        // 權限控制：只有 admin 可以刪除管理員
        if ($currentAccount !== 'admin') {
            return response()->json([
                'success' => false,
                'message' => '您沒有權限刪除管理員！'
            ]);
        }

        // 不能刪除自己
        if ($currentAccount === $account) {
            return response()->json([
                'success' => false,
                'message' => '不能刪除自己的帳號！'
            ]);
        }

        try {
            $admin = User::where('account', $account)->where('role', 'admin')->firstOrFail();

            // 刪除相關權限
            \App\Models\AdminPermission::where('account', $account)->delete();

            // 刪除管理員
            $admin->delete();

            return response()->json([
                'success' => true,
                'message' => '刪除成功！'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '刪除失敗：' . $e->getMessage()
            ]);
        }
    }

    /**
     * 檢查管理員是否已登入的中介軟體
     */
    public function checkAdminAuth()
    {
        return Session::has('admin_account');
    }
}
