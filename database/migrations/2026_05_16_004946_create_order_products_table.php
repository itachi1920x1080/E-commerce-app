<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_products', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('order_id');
            $table->uuid('product_id')->nullable();
            $table->string('sku', 255);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 12, 2);
            $table->integer('quantity')->default(1);
            $table->decimal('subtotal', 12, 2);
            $table->dateTime('inserted_at')->useCurrent();

            $table->foreign('order_id')->references('id')->on('sales_orders')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
            
            $table->index('order_id', 'idx_op_order');
            $table->index('product_id', 'idx_op_product');
        });

        DB::statement('ALTER TABLE order_products ADD CONSTRAINT chk_op_price CHECK (price >= 0)');
        DB::statement('ALTER TABLE order_products ADD CONSTRAINT chk_op_qty CHECK (quantity > 0)');
        DB::statement('ALTER TABLE order_products ADD CONSTRAINT chk_op_subtotal CHECK (subtotal >= 0)');
    }
    public function down(): void { Schema::dropIfExists('order_products'); }
};