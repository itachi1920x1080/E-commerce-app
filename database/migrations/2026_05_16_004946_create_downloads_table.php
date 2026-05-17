<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('downloads', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('order_id');
            $table->uuid('product_file_id');
            $table->string('token', 128)->unique();
            $table->integer('download_count')->default(0);
            $table->integer('max_downloads')->default(5);
            $table->dateTime('expires_at');
            $table->dateTime('last_downloaded_at')->nullable();
            $table->dateTime('inserted_at')->useCurrent();

            $table->unique(['order_id', 'product_file_id'], 'uq_dl_order_file');
            $table->foreign('order_id')->references('id')->on('sales_orders')->onDelete('cascade');
            $table->foreign('product_file_id')->references('id')->on('product_files')->onDelete('restrict');
            $table->index('expires_at', 'idx_dl_expires');
        });

        DB::statement('ALTER TABLE downloads ADD CONSTRAINT chk_dl_count CHECK (download_count >= 0)');
        DB::statement('ALTER TABLE downloads ADD CONSTRAINT chk_dl_max CHECK (max_downloads > 0)');
        DB::statement('ALTER TABLE downloads ADD CONSTRAINT chk_dl_lte CHECK (download_count <= max_downloads)');
    }
    public function down(): void { Schema::dropIfExists('downloads'); }
};