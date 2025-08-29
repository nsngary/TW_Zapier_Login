<!-- 舊的 checkpasswddb 等登入驗證 / 對應轉換 -->
 
<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    public function attemptByAccount(string $account, string $password): bool
    {
        $user = User::where('account', $account)->first();
        if (! $user) return false;

        // 若已是 bcrypt，交給 Auth::attempt
        if (Hash::info($user->password)['algoName'] === 'bcrypt') {
            return Auth::attempt(['account' => $account, 'password' => $password]);
        }

        // 舊密碼相容：例如 md5（依你舊系統實況調整）
        // 假設舊系統是 md5($password) 存在 user.password
        if (hash('md5', $password) === $user->password) {
            // 首次登入成功 → 升級為 bcrypt
            $user->password = Hash::make($password);
            $user->save();

            return Auth::attempt(['account' => $account, 'password' => $password]);
        }

        return false;
    }
}