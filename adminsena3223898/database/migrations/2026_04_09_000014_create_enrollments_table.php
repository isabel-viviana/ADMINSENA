<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('inscripciones')) {
            Schema::create('inscripciones', function (Blueprint $table) {
                $table->id();
                $table->foreignId('persona_id')->constrained('personas')->restrictOnDelete();
                $table->foreignId('convocatoria_id')->constrained('convocatorias')->restrictOnDelete();
                $table->string('status', 50)->default('Registrada');
                $table->timestamp('enrolled_at')->useCurrent();
                $table->timestamps();
                $table->unique(['persona_id', 'convocatoria_id']);
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
