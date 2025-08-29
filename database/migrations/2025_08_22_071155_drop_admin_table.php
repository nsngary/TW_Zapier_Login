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
     * 刪除舊的 admin 資料表，因為已經遷移到 users 資料表
     */
    public function up(): void
    {
        // 確認所有資料都已經遷移到 users 資料表後才刪除
        echo "正在刪除舊的 admin 資料表...\n";

        // 先移除 mright 資料表的外鍵約束（如果存在）
        try {
            DB::statement('ALTER TABLE mright DROP FOREIGN KEY mright_ibfk_1');
            echo "已移除 mright 資料表的外鍵約束\n";
        } catch (Exception $e) {
            echo "外鍵約束不存在或已被移除\n";
        }

        // 然後刪除 admin 資料表
        Schema::dropIfExists('admin');
        echo "admin 資料表已成功刪除\n";

        // 外鍵約束將在下一個 migration 中建立
        echo "admin 資料表刪除完成，外鍵約束將在下一個 migration 中建立\n";
    }

    /**
     * Reverse the migrations.
     *
     * 如果需要回滾，重新建立 admin 資料表
     */
    public function down(): void
    {
        // 移除 mright 對 users 的外鍵約束（如果存在）
        try {
            DB::statement('ALTER TABLE mright DROP FOREIGN KEY mright_account_foreign');
        } catch (Exception $e) {
            // 忽略錯誤，可能外鍵不存在
        }

        // 重新建立 admin 資料表
        Schema::create('admin', function (Blueprint $table) {
            $table->string('account', 20)->primary();
            $table->string('password', 10);
            $table->string('username', 10);
        });

        // 重新建立 mright 對 admin 的外鍵約束
        Schema::table('mright', function (Blueprint $table) {
            $table->foreign('account')->references('account')->on('admin')->onDelete('cascade');
        });

        echo "admin 資料表已重新建立\n";
    }
};
