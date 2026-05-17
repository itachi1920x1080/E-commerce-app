<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_statuses', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('name', 50)->unique();
            $table->dateTime('inserted_at')->useCurrent();
        });

        DB::table('product_statuses')->insert([
            ['id' => DB::raw('(UUID())'), 'name' => 'draft'],
            ['id' => DB::raw('(UUID())'), 'name' => 'active'],
            ['id' => DB::raw('(UUID())'), 'name' => 'archived']
        ]);
    }
    public function down(): void { Schema::dropIfExists('product_statuses'); }
};