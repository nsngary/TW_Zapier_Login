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
        if (!Schema::hasTable('mright')) {
            Schema::create('mright', function (Blueprint $table) {
                $table->string('account', 10);
                $table->string('sid', 10);

                $table->primary(['account', 'sid']);
                $table->index(['account', 'sid'], 'aid');

                $table->foreign('account')->references('account')->on('admin')->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mright');
    }
};
