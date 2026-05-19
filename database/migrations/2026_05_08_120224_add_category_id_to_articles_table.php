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
        Schema::table('articles', function (Blueprint $table) {
            // Hapus tabel lama
            Schema::dropIfExists('article_categoty');

            // Tamabah category ke article
            Schema::table('articles', function (Blueprint $table){
                $table->foreignId('category_id')->nullable()->constrained()->onDelete('set null');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            Schema::table('articles', function (Blueprint $table){
                $table->dropForeignId(['category_id']);
                $table->dropColumn('category_id');
            });
        });
    }
};
