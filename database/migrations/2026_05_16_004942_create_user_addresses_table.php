<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('user_id');
            $table->string('address_type', 20)->default('shipping');
            $table->string('full_name', 255);
            $table->string('phone', 30)->nullable();
            $table->string('address', 255);
            $table->string('city', 100);
            $table->string('state', 100)->nullable();
            $table->string('zip_code', 20)->nullable();
            $table->char('country', 2)->default('KH');
            $table->tinyInteger('is_default')->default(0);
            $table->dateTime('inserted_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->index(['user_id', 'is_default'], 'idx_ua_user_default');
        });
        DB::statement("ALTER TABLE user_addresses ADD CONSTRAINT chk_addr_type CHECK (address_type IN ('shipping', 'billing'))");
    }
    public function down(): void { Schema::dropIfExists('user_addresses'); }
    
};