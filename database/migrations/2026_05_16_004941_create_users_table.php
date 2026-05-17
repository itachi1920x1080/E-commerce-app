<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('email', 255)->unique();
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('password_hash', 255);
            $table->string('address', 255)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 50)->nullable();
            $table->integer('zip_code')->nullable();
            $table->tinyInteger('active')->default(1);
            $table->dateTime('inserted_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }
    public function down(): void { Schema::dropIfExists('users'); }
};