<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModalidadSeeder extends Seeder
{
    public function run(): void
    {
        $modalidades = [
            ['nombre' => 'Presencial', 'codigo' => 'PRES'],
            ['nombre' => 'Virtual', 'codigo' => 'VIRT'],
            ['nombre' => 'Híbrida', 'codigo' => 'HIBR'],
        ];

        foreach ($modalidades as $modalidad) {
            DB::table('modalidades')->updateOrInsert(
                ['nombre' => $modalidad['nombre']],
                [
                    'codigo' => $modalidad['codigo'],
                    'estado' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            );
        }
    }
}
