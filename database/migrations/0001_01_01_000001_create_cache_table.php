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
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key', 191)->primary(); // Limit key length to 191
            $table->mediumText('value')->nullable();
            $table->integer('expiration')->nullable();
        });

        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key', 191)->primary(); // Limit key length to 191
            $table->string('owner'); // You may want to limit this as well
            $table->integer('expiration');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
    }
};
