<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NivelFormacionSeeder extends Seeder
{
    public function run(): void
    {
        $niveles = [
            ['nombre' => 'Técnico', 'codigo' => 'TEC', 'duracion_meses_estimada' => 12],
            ['nombre' => 'Tecnólogo', 'codigo' => 'TECO', 'duracion_meses_estimada' => 24],
            ['nombre' => 'Complementario', 'codigo' => 'COMP', 'duracion_meses_estimada' => 1],
            ['nombre' => 'Curso Especial', 'codigo' => 'CE', 'duracion_meses_estimada' => 1],
            ['nombre' => 'Operario', 'codigo' => 'OPER', 'duracion_meses_estimada' => 6],
        ];

        foreach ($niveles as $nivel) {
            DB::table('niveles_formacion')->updateOrInsert(
                ['nombre' => $nivel['nombre']],
                [
                    'codigo' => $nivel['codigo'],
                    'duracion_meses_estimada' => $nivel['duracion_meses_estimada'],
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
