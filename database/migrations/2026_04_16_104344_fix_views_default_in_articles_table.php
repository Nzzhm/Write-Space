<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; 

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Update semua NULL jadi 0 dulu
    DB::table('articles')->whereNull('views')->update(['views' => 0]);

    Schema::table('articles', function (Blueprint $table) {
        $table->unsignedInteger('views')->default(0)->change();
    });
}

public function down(): void
{
    Schema::table('articles', function (Blueprint $table) {
        $table->unsignedInteger('views')->nullable()->change();
    });
}
};
