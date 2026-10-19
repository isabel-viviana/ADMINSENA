<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('apprentices')) {
            Schema::create('apprentices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('persona_id')->nullable()->constrained('personas')->nullOnDelete();
                $table->foreignId('convocatoria_id')->nullable()->constrained('convocatorias')->nullOnDelete();
                $table->foreignId('inscripcion_id')->nullable()->constrained('inscripciones')->nullOnDelete();
                $table->string('codigo_matricula', 50)->nullable();
                $table->string('estado_academico', 50)->default('En Formación');
                $table->date('fecha_matricula')->nullable();
                $table->string('fase_formativa', 50)->default('Lectiva');
                $table->string('name_apren');
                $table->string('email');
                $table->string('cell');
                $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
                $table->foreignId('computer_id')->nullable()->constrained('computers')->nullOnDelete();
                $table->string('urlFoto')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('apprentices');
    }
};
