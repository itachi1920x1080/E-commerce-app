<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('sales_orders', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->date('order_date')->default(DB::raw('(CURRENT_DATE)'));
            $table->decimal('total', 12, 2)->default(0.00);
            $table->string('status', 20)->default('pending');
            $table->uuid('user_id')->nullable();
            $table->uuid('coupon_id')->nullable();
            $table->dateTime('inserted_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('coupon_id')->references('id')->on('coupons')->onDelete('set null');
            
            $table->index('user_id', 'idx_so_user');
            $table->index('status', 'idx_so_status');
            $table->index('coupon_id', 'idx_so_coupon');
        });

        DB::statement('ALTER TABLE sales_orders ADD CONSTRAINT chk_order_total CHECK (total >= 0)');
        DB::statement("ALTER TABLE sales_orders ADD CONSTRAINT chk_order_status CHECK (status IN ('pending','paid','refunded','disputed','cancelled'))");
    }
    public function down(): void { Schema::dropIfExists('sales_orders'); }
};