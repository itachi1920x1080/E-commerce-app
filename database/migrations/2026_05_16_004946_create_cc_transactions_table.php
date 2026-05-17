<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('cc_transactions', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('order_id');
            $table->dateTime('transdate')->useCurrent();
            $table->string('processor', 100)->nullable();
            $table->string('processor_trans_id', 255)->nullable();
            $table->decimal('amount', 12, 2);
            $table->char('cc_last4', 4)->nullable();
            $table->string('cc_type', 50)->nullable();
            $table->string('status', 20)->default('pending');
            $table->text('response')->nullable();
            $table->dateTime('inserted_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('order_id')->references('id')->on('sales_orders')->onDelete('restrict');
            $table->index('order_id', 'idx_cct_order');
            $table->index('status', 'idx_cct_status');
        });

        DB::statement('ALTER TABLE cc_transactions ADD CONSTRAINT chk_cct_amount CHECK (amount >= 0)');
        DB::statement("ALTER TABLE cc_transactions ADD CONSTRAINT chk_cct_status CHECK (status IN ('pending','success','failed','refunded'))");
    }
    public function down(): void { Schema::dropIfExists('cc_transactions'); }
};