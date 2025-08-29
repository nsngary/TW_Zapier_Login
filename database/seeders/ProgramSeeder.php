<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            ['sid' => 's00', 'sname' => '權限管理', 'program' => 'permission_manage'],
            ['sid' => 's01', 'sname' => '帳號管理', 'program' => 'account_manage'],
            ['sid' => 's02', 'sname' => '產品管理', 'program' => 'product_manage'],
            ['sid' => 's03', 'sname' => '產品資料維護', 'program' => 'product_maintain'],
        ];

        foreach ($programs as $program) {
            \App\Models\Program::firstOrCreate(
                ['program' => $program['program']],
                $program
            );
        }

        // 為 admin 帳號分配所有權限（如果存在）
        if (\App\Models\Admin::where('account', 'admin')->exists()) {
            $adminPermissions = [
                ['account' => 'admin', 'sid' => 's00'],
                ['account' => 'admin', 'sid' => 's01'],
                ['account' => 'admin', 'sid' => 's02'],
                ['account' => 'admin', 'sid' => 's03'],
            ];

            foreach ($adminPermissions as $permission) {
                \App\Models\AdminPermission::firstOrCreate($permission);
            }
        }

        // 為 demo 帳號分配部分權限（如果存在）
        if (\App\Models\Admin::where('account', 'demo')->exists()) {
            $demoPermissions = [
                ['account' => 'demo', 'sid' => 's03'], // 只有產品資料維護權限
            ];

            foreach ($demoPermissions as $permission) {
                \App\Models\AdminPermission::firstOrCreate($permission);
            }
        }
    }
}
