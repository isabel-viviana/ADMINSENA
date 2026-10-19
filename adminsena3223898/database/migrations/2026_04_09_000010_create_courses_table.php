<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('courses')) {
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('name_curso');
                $table->string('codigo_curso', 50)->nullable();
                $table->text('description')->nullable();
                $table->unsignedInteger('duracion_horas')->default(0);
                $table->string('level')->default('Complementario');
                $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
                $table->foreignId('training_centers_id')->nullable()->constrained('training_centers')->nullOnDelete();
                $table->string('urlFoto')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
