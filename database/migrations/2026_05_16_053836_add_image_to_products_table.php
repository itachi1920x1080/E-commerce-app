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
        Route::middleware('auth')->group(function () {
            Schema::table('products', function (Blueprint $table) {
                // បន្ថែម Column សម្រាប់រក្សាទុកឈ្មោះផ្លូវរូបភាព (អាចទទេបាន Nullable)
                $table->string('image')->nullable()->after('name'); 
            });
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('image');
        });
    }
};
