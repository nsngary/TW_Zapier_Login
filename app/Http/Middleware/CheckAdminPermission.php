<?php
// 若登入者為 admin，則可以進入管理後台，並根據權限決定可以存取的功能

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string|null  $permission  需要的權限 (s00, s01, s02, s03)
     */
    public function handle(Request $request, Closure $next, ?string $permission = null): Response
    {
        // 檢查是否已登入
        if (!Session::has('admin_account')) {
            // 記住當前頁面，用於登入後重導向
            Session::put('url.intended', $request->fullUrl());
            return redirect()->route('admin.login')->with('error', '請先登入管理系統');
        }

        $account = Session::get('admin_account');
        $admin = User::where('account', $account)->where('role', 'admin')->first();

        if (!$admin) {
            Session::forget(['admin_account', 'admin_username', 'sLogintime']);
            return redirect()->route('admin.login')->with('error', '帳號不存在，請重新登入');
        }

        // 如果沒有指定權限，只檢查是否已登入
        if (!$permission) {
            return $next($request);
        }

        // 檢查是否有指定權限
        if (!$admin->hasPermission($permission)) {
            return redirect()->route('admin.index')->with('error', '您沒有權限存取此功能');
        }

        return $next($request);
    }
}
