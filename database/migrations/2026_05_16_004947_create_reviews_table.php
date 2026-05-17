<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('reviews', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->uuid('product_id');
            $table->uuid('user_id');
            $table->tinyInteger('rating');
            $table->text('body')->nullable();
            $table->tinyInteger('is_published')->default(0);
            $table->integer('helpful_count')->default(0);
            $table->dateTime('inserted_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();

            $table->unique(['product_id', 'user_id'], 'uq_review_user_product');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->index('product_id', 'idx_rev_product');
            $table->index('is_published', 'idx_rev_published');
        });

        DB::statement('ALTER TABLE reviews ADD CONSTRAINT chk_rev_rating CHECK (rating BETWEEN 1 AND 5)');
        DB::statement('ALTER TABLE reviews ADD CONSTRAINT chk_rev_helpful CHECK (helpful_count >= 0)');
    }
    public function down(): void { Schema::dropIfExists('reviews'); }
};