<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void {
        Schema::create('roles', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('(UUID())'));
            $table->string('name', 100)->unique();
            $table->dateTime('inserted_at')->useCurrent();
            $table->dateTime('updated_at')->useCurrent()->useCurrentOnUpdate();
        });

        DB::table('roles')->insert([
            ['id' => DB::raw('(UUID())'), 'name' => 'admin'],
            ['id' => DB::raw('(UUID())'), 'name' => 'customer'],
            ['id' => DB::raw('(UUID())'), 'name' => 'moderator']
        ]);
    }
    public function down(): void { Schema::dropIfExists('roles'); }
};