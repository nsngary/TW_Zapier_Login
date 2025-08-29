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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('產品名稱');
            $table->text('description')->nullable()->comment('產品描述');
            $table->decimal('price', 10, 2)->default(0)->comment('產品價格');
            $table->integer('stock')->default(0)->comment('庫存數量');
            $table->string('category')->nullable()->comment('產品分類');
            $table->string('sku')->unique()->nullable()->comment('產品編號');
            $table->enum('status', ['active', 'inactive', 'discontinued'])->default('active')->comment('產品狀態');
            $table->json('images')->nullable()->comment('產品圖片');
            $table->json('attributes')->nullable()->comment('產品屬性');
            $table->string('created_by')->nullable()->comment('建立者');
            $table->string('updated_by')->nullable()->comment('更新者');
            $table->timestamps();

            // 索引
            $table->index(['status', 'category']);
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
