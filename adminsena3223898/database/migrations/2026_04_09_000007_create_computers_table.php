<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('computers')) {
            Schema::create('computers', function (Blueprint $table) {
                $table->id();
                $table->string('serial_num');
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('computers');
    }
};
