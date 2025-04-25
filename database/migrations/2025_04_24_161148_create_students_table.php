<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('father_name')->nullable();
            $table->date('birth')->nullable();
            $table->date('recept_date');
            $table->foreignId('degree_id')->nullable()->constrained('degrees')->onDelete('cascade');
            $table->foreignId('group_id')->constrained('groups')->onDelete('cascade');
            $table->foreignId('nationality_id')->constrained('nationalities')->onDelete('cascade');
            $table->string('phone')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
