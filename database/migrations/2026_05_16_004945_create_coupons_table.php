<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('coupons', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('code', 255)->unique();
            $table->text('description')->nullable();
            $table->decimal('value', 12, 2);
            $table->string('value_type', 10)->default('fixed');
            $table->tinyInteger('active')->default(1);
            $table->integer('usage_limit')->nullable();
            $table->integer('used_count')->default(0);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->dateTime('inserted_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        DB::statement('ALTER TABLE coupons ADD CONSTRAINT chk_coupon_value CHECK (value > 0)');
        DB::statement('ALTER TABLE coupons ADD CONSTRAINT chk_coupon_used CHECK (used_count >= 0)');
        DB::statement("ALTER TABLE coupons ADD CONSTRAINT chk_coupon_value_type CHECK (value_type IN ('fixed','percent'))");
        DB::statement("ALTER TABLE coupons ADD CONSTRAINT chk_coupon_percent CHECK (value_type <> 'percent' OR value <= 100)");
    }
    public function down(): void { Schema::dropIfExists('coupons'); }
};