<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('computers', function (Blueprint $table) {
            if (! Schema::hasColumn('computers', 'numero')) {
                $table->string('numero')->nullable();
            }

            if (! Schema::hasColumn('computers', 'marca')) {
                $table->string('marca')->nullable();
            }

            if (! Schema::hasColumn('computers', 'urlFoto')) {
                $table->string('urlFoto')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('computers', function (Blueprint $table) {
            $columns = array_filter(['numero', 'marca', 'urlFoto'], fn (string $column) => Schema::hasColumn('computers', $column));

            if ($columns !== []) {
                $table->dropColumn($columns);
            }
        });
    }
};