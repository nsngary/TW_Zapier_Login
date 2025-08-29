<?php
// 若登入者的 role = user，則無法進入管理後台

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 檢查是否已登入（使用與管理員相同的 session 機制）
        if (!Session::has('admin_account')) {
            // 記住當前頁面，用於登入後重導向
            Session::put('url.intended', $request->fullUrl());
            return redirect()->route('admin.login')->with('error', '請先登入系統');
        }

        $account = Session::get('admin_account');
        $user = User::where('account', $account)->first();

        if (!$user) {
            Session::forget(['admin_account', 'admin_username', 'sLogintime']);
            return redirect()->route('admin.login')->with('error', '帳號不存在，請重新登入');
        }

        return $next($request);
    }
}
