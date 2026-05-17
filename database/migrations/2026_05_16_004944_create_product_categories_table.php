<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('product_categories', function (Blueprint $table) {
            $table->uuid('product_id'); // ផលិតផលប្រើ UUID
            
            // 🎯 FIX ទី២៖ ប្តូរមកជា uuid វិញដើម្បីឱ្យត្រូវគ្នាជាមួយតារាង categories មេខាងលើ
            $table->uuid('category_id'); 
            
            $table->dateTime('inserted_at')->useCurrent();

            $table->primary(['product_id', 'category_id']);
            
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->index('category_id', 'idx_pc_category');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void { 
        Schema::dropIfExists('product_categories'); 
    }
};