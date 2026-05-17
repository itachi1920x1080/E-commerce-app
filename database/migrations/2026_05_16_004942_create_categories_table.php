<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('categories', function (Blueprint $table) {
            // 🎯 FIX ទី១៖ ប្តូរមកប្រើ UUID ជា Primary Key ឱ្យត្រូវជាមួយទិន្នន័យក្នុង Seeder
            $table->uuid('id')->primary(); 
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            
            // កំណត់ parent_id ជា uuid/string ដែរ ព្រោះវាភ្ជាប់ទៅកាន់ ID មេដែលជា UUID
            $table->uuid('parent_id')->nullable(); 
            
            $table->dateTime('inserted_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void { 
        Schema::dropIfExists('categories'); 
    }
};