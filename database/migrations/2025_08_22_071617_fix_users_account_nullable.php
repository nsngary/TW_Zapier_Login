<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * 修正 users.account 欄位為不可為 null，以便建立外鍵約束
     */
    public function up(): void
    {
        // 修改 users.account 欄位為不可為 null
        Schema::table('users', function (Blueprint $table) {
            $table->string('account', 255)->nullable(false)->change();
        });
        echo "已修改 users.account 欄位為不可為 null\n";

        // 修改 mright 資料表的排序規則以匹配 users 資料表
        DB::statement('ALTER TABLE mright CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci');
        echo "已修改 mright 資料表的排序規則\n";

        // 現在建立外鍵約束
        Schema::table('mright', function (Blueprint $table) {
            $table->foreign('account')->references('account')->on('users')->onDelete('cascade');
        });
        echo "已建立 mright 對 users 資料表的外鍵約束\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 移除外鍵約束
        Schema::table('mright', function (Blueprint $table) {
            $table->dropForeign(['account']);
        });

        // 恢復 users.account 為可為 null
        Schema::table('users', function (Blueprint $table) {
            $table->string('account', 255)->nullable()->change();
        });
    }
};
