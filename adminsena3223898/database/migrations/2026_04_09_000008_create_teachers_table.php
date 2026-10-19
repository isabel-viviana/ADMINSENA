<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('teachers')) {
            Schema::create('teachers', function (Blueprint $table) {
                $table->id();
                $table->foreignId('persona_id')->nullable()->constrained('personas')->nullOnDelete();
                $table->string('name');
                $table->string('codigo_instructor', 50)->nullable();
                $table->string('especialidad', 150)->nullable();
                $table->string('email');
                $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
                $table->foreignId('training_centers_id')->constrained('training_centers')->onDelete('cascade');
                $table->string('urlFoto')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
