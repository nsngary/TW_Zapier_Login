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
        if (!Schema::hasTable('product_img')) {
            Schema::create('product_img', function (Blueprint $table) {
                $table->id('img_id');
                $table->unsignedBigInteger('p_id');
                $table->string('img_file');
                $table->integer('sort')->default(1);
                $table->timestamp('create_date')->nullable();
                $table->timestamps();

                $table->index('p_id');
                $table->index('sort');

                $table->foreign('p_id')->references('p_id')->on('product')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_img');
    }
};
