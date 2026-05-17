<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_files', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('product_id');
            $table->string('filename', 255);
            $table->string('storage_key', 512)->unique();
            $table->bigInteger('file_size_bytes');
            $table->string('mime_type', 127);
            $table->char('checksum_sha256', 64)->nullable();
            $table->string('version', 50)->default('1.0');
            $table->dateTime('inserted_at')->useCurrent();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index('product_id', 'idx_pf_product');
        });
        DB::statement('ALTER TABLE product_files ADD CONSTRAINT chk_file_size CHECK (file_size_bytes > 0)');
    }
    public function down(): void { Schema::dropIfExists('product_files'); }
};