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
        if (!Schema::hasTable('pyclass')) {
            Schema::create('pyclass', function (Blueprint $table) {
                $table->id('classid');
                $table->string('cname');
                $table->unsignedBigInteger('uplink')->nullable();
                $table->integer('sort')->default(0);
                $table->timestamps();

                $table->index('uplink');
                $table->index('sort');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pyclass');
    }
};
