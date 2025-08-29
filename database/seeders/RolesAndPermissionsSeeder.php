<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
    // 建立權限
    Permission::firstOrCreate(['name' => 'user.manage']);
    Permission::firstOrCreate(['name' => 'product.read']);
    Permission::firstOrCreate(['name' => 'product.write']);

    // 建立角色並賦予權限
    $admin = Role::firstOrCreate(['name' => 'admin']);
    $admin->givePermissionTo(['user.manage','product.read','product.write']);

    $editor = Role::firstOrCreate(['name' => 'editor']);
    $editor->givePermissionTo(['product.read','product.write']);

    $viewer = Role::firstOrCreate(['name' => 'viewer']);
    $viewer->givePermissionTo(['product.read']);
    }
}
