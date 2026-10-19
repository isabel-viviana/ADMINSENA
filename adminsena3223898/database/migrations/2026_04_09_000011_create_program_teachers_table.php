<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('program_teachers')) {
            Schema::create('program_teachers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('program_id')->constrained('programs')->onDelete('cascade');
                $table->foreignId('teacher_id')->constrained('teachers')->onDelete('cascade');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('program_teachers');
    }
};
