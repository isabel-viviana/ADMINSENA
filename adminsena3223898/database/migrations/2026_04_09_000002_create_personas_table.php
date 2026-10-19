<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('personas')) {
            Schema::create('personas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
                $table->string('tipo_documento', 10)->default('CC');
                $table->string('numero_documento', 30)->unique();
                $table->string('primer_nombre', 100);
                $table->string('segundo_nombre', 100)->nullable();
                $table->string('primer_apellido', 100);
                $table->string('segundo_apellido', 100)->nullable();
                $table->date('fecha_nacimiento')->nullable();
                $table->string('genero', 20)->nullable();
                $table->string('correo_contacto', 150)->nullable();
                $table->string('telefono', 50)->nullable();
                $table->string('direccion', 255)->nullable();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
