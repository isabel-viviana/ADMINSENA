<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('convocatorias')) {
            Schema::create('convocatorias', function (Blueprint $table) {
                $table->id();
                $table->string('numero_ficha', 50)->nullable()->unique();
                $table->string('codigo_convocatoria', 50)->nullable();
                $table->foreignId('program_id')->nullable()->constrained('programs')->nullOnDelete();
                $table->foreignId('course_id')->nullable()->constrained('courses')->nullOnDelete();
                $table->foreignId('training_center_id')->constrained('training_centers')->restrictOnDelete();
                $table->foreignId('jornada_id')->nullable()->constrained('jornadas')->nullOnDelete();
                $table->foreignId('modalidad_id')->nullable()->constrained('modalidades')->nullOnDelete();
                $table->foreignId('teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
                $table->enum('schedule', ['Mañana', 'Tarde', 'Noche'])->default('Mañana');
                $table->enum('modality', ['Presencial', 'Virtual', 'Mixta'])->default('Presencial');
                $table->unsignedInteger('quota');
                $table->date('start_date');
                $table->date('end_date');
                $table->enum('status', ['Abierta', 'Cerrada', 'Finalizada'])->default('Abierta');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('convocatorias');
    }
};
