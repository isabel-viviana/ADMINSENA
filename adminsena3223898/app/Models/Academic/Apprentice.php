<?php

namespace App\Models\Academic;

use App\Models\People\Person;
use App\Models\Resource\Computer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apprentice extends Model
{
    use HasFactory;

    protected $table = 'apprentices';

    protected $fillable = [
        'persona_id',
        'convocatoria_id',
        'inscripcion_id',
        'codigo_matricula',
        'estado_academico',
        'fecha_matricula',
        'fase_formativa',
        'name_apren',
        'email',
        'cell',
        'program_id',
        'course_id',
        'computer_id',
    ];

    protected $guarded = [
        'urlFoto'
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function computer()
    {
        return $this->belongsTo(Computer::class, 'computer_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'persona_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class, 'convocatoria_id');
    }

    public function enrollment()
    {
        return $this->belongsTo(Enrollment::class, 'inscripcion_id');
    }

    /**
     * Accessor para obtener la ruta académica del aprendiz.
     * Devuelve 'program' si program_id está asignado, de lo contrario 'course'.
     */
    public function getAcademicPathAttribute()
    {
        return $this->program_id ? 'program' : ($this->course_id ? 'course' : null);
    }
}
