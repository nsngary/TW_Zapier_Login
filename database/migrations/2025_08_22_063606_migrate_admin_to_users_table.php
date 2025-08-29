<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. 首先為 users 資料表添加 role 欄位來識別管理員
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('account');
        });

        // 2. 遷移 admin 資料表的資料到 users 資料表
        $admins = DB::table('admin')->get();

        foreach ($admins as $admin) {
            // 檢查是否已存在相同 account 的用戶
            $existingUser = DB::table('users')->where('account', $admin->account)->first();

            if (!$existingUser) {
                DB::table('users')->insert([
                    'name' => $admin->username,
                    'username' => $admin->username,
                    'account' => $admin->account,
                    'email' => $admin->account . '@admin.local', // 為管理員生成預設 email
                    'password' => Hash::make($admin->password), // 將明文密碼加密
                    'role' => 'admin', // 標記為管理員
                    'email_verified_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                echo "遷移管理員: {$admin->account} ({$admin->username})\n";
            } else {
                // 如果已存在，更新為管理員角色
                DB::table('users')
                    ->where('account', $admin->account)
                    ->update([
                        'role' => 'admin',
                        'name' => $admin->username,
                        'username' => $admin->username,
                        'password' => Hash::make($admin->password),
                        'updated_at' => now(),
                    ]);

                echo "更新現有用戶為管理員: {$admin->account} ({$admin->username})\n";
            }
        }

        echo "成功遷移 " . count($admins) . " 個管理員帳號到 users 資料表\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 刪除從 admin 遷移過來的管理員帳號
        DB::table('users')->where('role', 'admin')->delete();

        // 移除 role 欄位
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
