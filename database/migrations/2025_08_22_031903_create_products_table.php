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
        if (!Schema::hasTable('product')) {
            Schema::create('product', function (Blueprint $table) {
                $table->id('p_id');
                $table->string('p_name');
                $table->text('p_intro')->nullable();
                $table->text('p_content')->nullable();
                $table->decimal('p_price', 10, 2)->default(0);
                $table->boolean('p_open')->default(1);
                $table->unsignedBigInteger('classid')->nullable();
                $table->timestamp('p_date')->nullable();
                $table->timestamps();

                $table->index('p_open');
                $table->index('classid');
                $table->index('p_date');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
