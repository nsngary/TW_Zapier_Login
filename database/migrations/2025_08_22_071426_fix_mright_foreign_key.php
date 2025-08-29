<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * 修正 mright 資料表的外鍵約束，使其正確引用 users 資料表
     */
    public function up(): void
    {
        // 修改 mright.account 欄位類型以匹配 users.account
        Schema::table('mright', function (Blueprint $table) {
            $table->string('account', 255)->change();
        });
        echo "已修改 mright.account 欄位類型為 varchar(255)\n";

        // 外鍵約束將在下一個 migration 中建立
        echo "mright.account 欄位類型修改完成\n";
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

        // 恢復原始欄位類型
        Schema::table('mright', function (Blueprint $table) {
            $table->string('account', 10)->change();
        });
    }
};
