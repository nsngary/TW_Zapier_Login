<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        // 對應 resources/views/auth/login.blade.php
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('account', 'password');

        // 嘗試登入（需把 users 表調整成有 account 欄位，或修改 guard）
        if (Auth::attempt(['account' => $credentials['account'], 'password' => $credentials['password']])) {
            $request->session()->regenerate();
            session(['username' => auth()->user()->username]);

            // 根據用戶角色跳轉到不同頁面
            $user = Auth::user();
            if ($user->role === 'admin') {
                return redirect()->intended('/admin');
            } else {
                return redirect()->intended('/user');
            }
        }

        return back()->withErrors([
            'account' => '帳號或密碼錯誤',
        ])->onlyInput('account');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}