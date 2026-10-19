<?php

namespace App\Models\Academic;

use App\Models\People\Person;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'persona_id',
        'convocatoria_id',
        'status',
        'enrolled_at',
    ];

    protected $casts = [
        'enrolled_at' => 'datetime',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'persona_id');
    }

    public function persona()
    {
        return $this->belongsTo(Person::class, 'persona_id');
    }

    public function intake()
    {
        return $this->belongsTo(Intake::class, 'convocatoria_id');
    }

    public function convocatoria()
    {
        return $this->belongsTo(Intake::class, 'convocatoria_id');
    }

    public function apprentice()
    {
        return $this->hasOne(Apprentice::class, 'inscripcion_id');
    }
}
