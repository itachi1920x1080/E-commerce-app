<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_tags', function (Blueprint $table) {
            $table->uuid('product_id');
            $table->uuid('tag_id');
            $table->dateTime('inserted_at')->useCurrent();

            $table->primary(['product_id', 'tag_id']);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('tag_id')->references('id')->on('tags')->onDelete('cascade');
            $table->index('tag_id', 'idx_pt_tag');
        });
    }
    public function down(): void { Schema::dropIfExists('product_tags'); }
};