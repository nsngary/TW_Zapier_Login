<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 檢查是否已有管理員資料
        if (\App\Models\Admin::count() == 0) {
            // 建立預設管理員帳號
            \App\Models\Admin::create([
                'account' => 'admin',
                'password' => '123', // 實際使用時應該使用 Hash::make()
                'username' => '系統管理員'
            ]);

            \App\Models\Admin::create([
                'account' => 'demo',
                'password' => 'demo123',
                'username' => '示範帳號'
            ]);
        }
    }
}
