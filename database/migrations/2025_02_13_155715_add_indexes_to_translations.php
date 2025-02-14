<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('translations', function (Blueprint $table) {
            // Ensure the columns are limited to 191 characters
            $table->string('key', 50)->change();
            $table->string('locale', 50)->change();
            $table->string('tag', 50)->nullable()->change();

            // Add the index on the limited columns
            $table->index(['locale', 'tag']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('translations', function (Blueprint $table) {
            // Drop the index if it exists
            $table->dropIndex(['locale', 'tag']);
        });
    }
};
