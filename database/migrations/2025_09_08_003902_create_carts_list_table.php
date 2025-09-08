<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('carts_list', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique()->comment('訂單編號');
            $table->unsignedBigInteger('user_id')->comment('使用者ID');
            $table->json('product_data')->comment('產品資料快照');
            $table->decimal('total_amount', 10, 2)->default(0)->comment('總金額');
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('pending')->comment('訂單狀態');
            $table->timestamps();

            // 外鍵約束
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            // 索引
            $table->index('user_id');
            $table->index('order_number');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carts_list');
    }
};
