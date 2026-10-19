<?php

namespace App\Models\Academic;

use App\Models\Catalog\Journey;
use App\Models\Catalog\Modality;
use App\Models\Catalog\TrainingCenter;
use App\Models\People\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intake extends Model
{
    use HasFactory;

    protected $table = 'convocatorias';

    protected $fillable = [
        'numero_ficha',
        'codigo_convocatoria',
        'program_id',
        'course_id',
        'training_center_id',
        'jornada_id',
        'modalidad_id',
        'teacher_id',
        'schedule',
        'modality',
        'quota',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class, 'course_id');
    }

    public function getOfertaAttribute()
    {
        return $this->program ?? $this->course;
    }

    public function getTipoOfertaAttribute()
    {
        if ($this->program_id) {
            return 'Programa';
        }
        if ($this->course_id) {
            return 'Curso';
        }
        return 'N/A';
    }

    public function trainingCenter()
    {
        return $this->belongsTo(TrainingCenter::class, 'training_center_id');
    }

    public function journey()
    {
        return $this->belongsTo(Journey::class, 'jornada_id');
    }

    public function modality()
    {
        return $this->belongsTo(Modality::class, 'modalidad_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacher_id');
    }

    public function getScheduleAttribute($value)
    {
        return $value ?? $this->journey?->nombre;
    }

    public function setScheduleAttribute($value)
    {
        $jornada = Journey::where('nombre', $value)->first();
        if ($jornada) {
            $this->attributes['jornada_id'] = $jornada->id;
        }
    }

    public function getModalityAttribute($value)
    {
        return $value ?? $this->modality?->nombre;
    }

    public function setModalityAttribute($value)
    {
        $modalidad = Modality::where('nombre', $value)->first();
        if ($modalidad) {
            $this->attributes['modalidad_id'] = $modalidad->id;
        }
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'convocatoria_id');
    }

    public function apprentices()
    {
        return $this->hasMany(Apprentice::class, 'convocatoria_id');
    }
}
