<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('sku', 255)->unique();
            $table->string('name', 255);
            
            // 🎯 រក្សាទុកតម្លៃ ស្តុកទំនិញ និងតម្លៃចុះ (លុបភាពស្ទួនចេញហើយ)
            $table->decimal('regular_price', 12, 2)->default(0.00);
            $table->integer('qty')->default(0); 
            $table->decimal('discount_price', 12, 2)->default(0.00)->nullable();
            $table->string('slug', 300)->unique();
            $table->text('description')->nullable();
            $table->uuid('product_status_id')->nullable();
            
            $table->tinyInteger('is_free')->default(0);
            $table->tinyInteger('taxable')->default(0);
            $table->char('currency', 3)->default('USD');
            $table->dateTime('inserted_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            // Relationships & Indexes
            $table->foreign('product_status_id')->references('id')->on('product_statuses')->onDelete('set null');
            $table->index('product_status_id', 'idx_products_status');
            $table->index('is_free', 'idx_products_is_free');
        });

        // Database Constraints (CHECK)
        DB::statement('ALTER TABLE products ADD CONSTRAINT chk_regular_price CHECK (regular_price >= 0)');
        DB::statement('ALTER TABLE products ADD CONSTRAINT chk_discount_price CHECK (discount_price >= 0)');
        DB::statement('ALTER TABLE products ADD CONSTRAINT chk_discount_lte CHECK (discount_price <= regular_price)');
    }

    public function down(): void { 
        Schema::dropIfExists('products'); 
    }
};