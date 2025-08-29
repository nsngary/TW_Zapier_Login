<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Program;
use App\Models\AdminPermission;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    /**
     * 顯示權限管理頁面
     */
    public function index(Request $request)
    {
        $query = User::admins()->with('permissions.program');

        // 搜尋功能
        if ($request->has('search') && !empty($request->search)) {
            $query->where('account', 'LIKE', "%{$request->search}%")
                  ->orWhere('username', 'LIKE', "%{$request->search}%");
        }

        $admins = $query->paginate(10);
        $admins->appends($request->query());

        $programs = Program::orderBy('sid')->get();
        $permissionLevels = Program::getPermissionLevels();

        return view('admin.permissions.index', compact('admins', 'programs', 'permissionLevels'));
    }

    /**
     * 顯示管理員權限編輯頁面
     */
    public function edit($account)
    {
        $admin = User::where('account', $account)->where('role', 'admin')->with('permissions')->firstOrFail();
        $programs = Program::orderBy('sid')->get();
        $permissionLevels = Program::getPermissionLevels();
        $adminPermissions = $admin->getPermissions();

        return view('admin.permissions.edit', compact('admin', 'programs', 'permissionLevels', 'adminPermissions'));
    }

    /**
     * 更新管理員權限
     */
    public function update(Request $request, $account)
    {
        $admin = User::where('account', $account)->where('role', 'admin')->firstOrFail();

        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'string|in:s00,s01,s02,s03'
        ]);

        // 刪除現有權限
        AdminPermission::where('account', $account)->delete();

        // 新增選中的權限
        if ($request->has('permissions')) {
            foreach ($request->permissions as $permission) {
                AdminPermission::create([
                    'account' => $account,
                    'sid' => $permission
                ]);
            }
        }

        return redirect()->route('admin.permissions.index')
                        ->with('success', "管理員 {$admin->username} 的權限已更新！");
    }

    /**
     * 快速分配權限 (AJAX)
     */
    public function assign(Request $request)
    {
        $request->validate([
            'account' => 'required|exists:users,account',
            'sid' => 'required|in:s00,s01,s02,s03'
        ]);

        try {
            AdminPermission::firstOrCreate([
                'account' => $request->account,
                'sid' => $request->sid
            ]);

            return response()->json([
                'success' => true,
                'message' => '權限分配成功！'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '權限分配失敗：' . $e->getMessage()
            ]);
        }
    }

    /**
     * 移除權限 (AJAX)
     */
    public function revoke(Request $request)
    {
        $request->validate([
            'account' => 'required|exists:users,account',
            'sid' => 'required|in:s00,s01,s02,s03'
        ]);

        try {
            AdminPermission::where('account', $request->account)
                          ->where('sid', $request->sid)
                          ->delete();

            return response()->json([
                'success' => true,
                'message' => '權限移除成功！'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '權限移除失敗：' . $e->getMessage()
            ]);
        }
    }

    /**
     * 批量權限操作
     */
    public function batchUpdate(Request $request)
    {
        $request->validate([
            'accounts' => 'required|array',
            'accounts.*' => 'exists:users,account',
            'action' => 'required|in:assign,revoke',
            'permission' => 'required|in:s00,s01,s02,s03'
        ]);

        try {
            foreach ($request->accounts as $account) {
                if ($request->action === 'assign') {
                    AdminPermission::firstOrCreate([
                        'account' => $account,
                        'sid' => $request->permission
                    ]);
                } else {
                    AdminPermission::where('account', $account)
                                  ->where('sid', $request->permission)
                                  ->delete();
                }
            }

            $actionText = $request->action === 'assign' ? '分配' : '移除';
            $count = count($request->accounts);

            return response()->json([
                'success' => true,
                'message' => "已為 {$count} 個管理員{$actionText}權限！"
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '批量操作失敗：' . $e->getMessage()
            ]);
        }
    }
}
