<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('programs')) {
            Schema::create('programs', function (Blueprint $table) {
                $table->id();
                $table->string('name_curso');
                $table->string('codigo_programa', 50)->nullable();
                $table->foreignId('nivel_id')->nullable()->constrained('niveles_formacion')->nullOnDelete();
                $table->string('version_programa', 20)->default('1');
                $table->unsignedInteger('duracion_horas_totales')->nullable();
                $table->text('perfil_ingreso')->nullable();
                $table->string('day')->default('Diurna');
                $table->text('description')->nullable();
                $table->enum('level', ['Tecnico', 'Tecnologo', 'Complementario'])->default('Tecnologo');
                $table->unsignedSmallInteger('duration')->default(1);
                $table->foreignId('area_id')->constrained('areas')->onDelete('cascade');
                $table->foreignId('training_centers_id')->constrained('training_centers')->onDelete('cascade');
                $table->string('urlFoto')->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('programs');
    }
};
