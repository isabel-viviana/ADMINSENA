<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JornadaSeeder extends Seeder
{
    public function run(): void
    {
        $jornadas = [
            ['nombre' => 'Mañana', 'codigo' => 'MAN'],
            ['nombre' => 'Tarde', 'codigo' => 'TAR'],
            ['nombre' => 'Noche', 'codigo' => 'NOC'],
            ['nombre' => 'Mixta', 'codigo' => 'MIX'],
        ];

        foreach ($jornadas as $jornada) {
            DB::table('jornadas')->updateOrInsert(
                ['nombre' => $jornada['nombre']],
                [
                    'codigo' => $jornada['codigo'],
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
