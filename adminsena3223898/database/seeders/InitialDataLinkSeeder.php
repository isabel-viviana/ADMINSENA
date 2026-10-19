<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Catalog\Journey;
use App\Models\Catalog\Modality;
use App\Models\Catalog\Level;
use App\Models\Academic\Intake;
use App\Models\Academic\Program;
use App\Models\Academic\Course;
use App\Models\People\User;
use App\Models\People\Person;
use App\Models\Academic\Enrollment;
use App\Models\People\Teacher;

class InitialDataLinkSeeder extends Seeder
{
    public function run(): void
    {
        $jornada = Journey::where('nombre', 'Mañana')->first();
        $modalidad = Modality::where('nombre', 'Presencial')->first();

        Intake::where('id', 1)->update([
            'jornada_id' => $jornada?->id,
            'modalidad_id' => $modalidad?->id,
            'numero_ficha' => '3223898-01',
            'codigo_convocatoria' => 'CONV-2026-01',
        ]);

        $nivel = Level::where('nombre', 'Complementario')->first();
        Program::where('id', 2)->update([
            'nivel_id' => $nivel?->id,
            'codigo_programa' => 'PROG-3223899',
            'duracion_horas_totales' => 48,
        ]);

        // Link User 2 to Person
        $user2 = User::find(2);
        if ($user2 && !Person::where('user_id', 2)->exists()) {
            $persona = Person::create([
                'user_id' => 2,
                'tipo_documento' => 'CC',
                'numero_documento' => '1000000002',
                'primer_nombre' => 'Aprendiz',
                'primer_apellido' => 'SENA',
                'correo_contacto' => $user2->email,
                'telefono' => '3001234567',
            ]);

            Enrollment::where('id', 1)->update(['persona_id' => $persona->id]);
        }

        // Link Teacher to Person
        $teacher = Teacher::first();
        if ($teacher && !$teacher->persona_id) {
            $docentePersona = Person::firstOrCreate(
                ['numero_documento' => '1000000003'],
                [
                    'tipo_documento' => 'CC',
                    'primer_nombre' => $teacher->name ?: 'Instructor',
                    'primer_apellido' => 'SENA',
                    'correo_contacto' => $teacher->email,
                    'telefono' => '3109876543',
                ]
            );
            $teacher->update([
                'persona_id' => $docentePersona->id,
                'codigo_instructor' => 'INST-001',
                'especialidad' => 'Sistemas y Desarrollo Web',
            ]);
        }
    }
}
