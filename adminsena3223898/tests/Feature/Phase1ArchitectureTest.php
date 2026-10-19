<?php

namespace Tests\Feature;

use App\Models\Catalog\Area;
use App\Models\Academic\Intake as Convocatoria;
use App\Models\Academic\Course;
use App\Models\Academic\Enrollment as Inscripcion;
use App\Models\Academic\Program;
use App\Models\People\Person;
use App\Models\People\Teacher;
use App\Models\Catalog\TrainingCenter;
use App\Models\People\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class Phase1ArchitectureTest extends TestCase
{
    use RefreshDatabase;

    public function test_programs_and_courses_separation_and_convocatoria_relations(): void
    {
        // 1. Create Area and Training Center
        $area = Area::create(['name' => 'Tecnología e Informática']);
        $center = TrainingCenter::create(['name' => 'Centro CTPI', 'location' => 'Popayán']);

        // 2. Create a Program (Técnico / Tecnólogo)
        $program = Program::create([
            'name_curso' => 'ADSO - Análisis y Desarrollo de Software',
            'codigo_programa' => '228106',
            'level' => 'Tecnologo',
            'day' => 'Diurna',
            'area_id' => $area->id,
            'training_centers_id' => $center->id,
        ]);

        // 3. Create a Course (Complementario / Especial)
        $course = Course::create([
            'name_curso' => 'Python Básico',
            'codigo_curso' => 'CURSO-PY-01',
            'duracion_horas' => 40,
            'level' => 'Complementario',
            'area_id' => $area->id,
            'training_centers_id' => $center->id,
        ]);

        // Assert Area relationships
        $this->assertCount(1, $area->programs);
        $this->assertCount(1, $area->courses);

        // 4. Create Convocatoria for Program
        $convocatoriaProgram = Convocatoria::create([
            'program_id' => $program->id,
            'training_center_id' => $center->id,
            'schedule' => 'Mañana',
            'modality' => 'Presencial',
            'quota' => 30,
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'end_date' => now()->addDays(30)->format('Y-m-d'),
            'status' => 'Abierta',
        ]);

        // 5. Create Convocatoria for Course
        $convocatoriaCourse = Convocatoria::create([
            'course_id' => $course->id,
            'training_center_id' => $center->id,
            'schedule' => 'Noche',
            'modality' => 'Virtual',
            'quota' => 25,
            'start_date' => now()->addDays(5)->format('Y-m-d'),
            'end_date' => now()->addDays(20)->format('Y-m-d'),
            'status' => 'Abierta',
        ]);

        // Assert Convocatoria offerable items
        $this->assertEquals($program->id, $convocatoriaProgram->program->id);
        $this->assertEquals('ADSO - Análisis y Desarrollo de Software', $convocatoriaProgram->oferta->name_curso);
        $this->assertEquals('Programa', $convocatoriaProgram->tipo_oferta);

        $this->assertEquals($course->id, $convocatoriaCourse->course->id);
        $this->assertEquals('Python Básico', $convocatoriaCourse->oferta->name_curso);
        $this->assertEquals('Curso', $convocatoriaCourse->tipo_oferta);

        // 6. Test Inscripcion works unchanged
        $user = User::create([
            'name' => 'Aprendiz Test',
            'email' => 'test@sena.edu.co',
            'password' => bcrypt('secret123'),
            'role' => 'aprendiz',
        ]);

        $persona = Person::create([
            'user_id' => $user->id,
            'numero_documento' => '1000000001',
            'primer_nombre' => 'Aprendiz',
            'primer_apellido' => 'Test',
            'correo_contacto' => $user->email,
        ]);

        $inscripcion = Inscripcion::create([
            'persona_id' => $persona->id,
            'convocatoria_id' => $convocatoriaProgram->id,
            'status' => 'Inscrito',
            'enrolled_at' => now(),
        ]);

        $this->assertEquals($convocatoriaProgram->id, $inscripcion->convocatoria->id);
        $this->assertEquals('ADSO - Análisis y Desarrollo de Software', $inscripcion->convocatoria->oferta->name_curso);
    }
}
