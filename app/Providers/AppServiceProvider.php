<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // 定義權限 Gates
        Gate::define('manage-permissions', function () {
            return self::checkAdminPermission('s00');
        });

        Gate::define('manage-accounts', function () {
            return self::checkAdminPermission('s01');
        });

        Gate::define('manage-products', function () {
            return self::checkAdminPermission('s02');
        });

        Gate::define('maintain-products', function () {
            return self::checkAdminPermission('s03');
        });

        Gate::define('access-admin', function () {
            return Session::has('admin_account');
        });

        Gate::define('has-any-permission', function () {
            if (!Session::has('admin_account')) {
                return false;
            }

            $account = Session::get('admin_account');
            $admin = Admin::where('account', $account)->first();

            return $admin && $admin->hasAnyPermission();
        });
    }

    /**
     * 檢查管理員權限的輔助方法
     */
    private static function checkAdminPermission($permission)
    {
        if (!Session::has('admin_account')) {
            return false;
        }

        $account = Session::get('admin_account');
        $admin = Admin::where('account', $account)->first();

        if (!$admin) {
            return false;
        }

        $hasPermission = $admin->hasPermission($permission);

        // 調試信息
        if (config('app.debug')) {
            \Log::info("Gate check: account={$account}, permission={$permission}, result=" . ($hasPermission ? 'true' : 'false'));
        }

        return $hasPermission;
    }
}
