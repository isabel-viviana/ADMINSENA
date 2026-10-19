<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('jornadas')) {
            Schema::create('jornadas', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 50)->unique();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('modalidades')) {
            Schema::create('modalidades', function (Blueprint $table) {
                $table->id();
                $table->string('nombre', 50)->unique();
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('modalidades');
        Schema::dropIfExists('jornadas');
    }
};
