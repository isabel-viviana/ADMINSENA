<?php

namespace App\Models\Academic;

use App\Models\Catalog\Area;
use App\Models\Catalog\Level;
use App\Models\Catalog\TrainingCenter;
use App\Models\People\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $table = 'programs';

    protected $fillable = [
        "name_curso",
        "codigo_programa",
        "nivel_id",
        "version_programa",
        "duracion_horas_totales",
        "perfil_ingreso",
        "day",
        "description",
        "level",
        "duration",
        "area_id",
        "training_centers_id"
    ];

    protected $guarded = [
        'urlFoto'
    ];

    public function area()
    {
        return $this->belongsTo(Area::class, 'area_id');
    }

    public function training_center()
    {
        return $this->belongsTo(TrainingCenter::class, 'training_centers_id');
    }

    public function level()
    {
        return $this->belongsTo(Level::class, 'nivel_id');
    }

    public function apprentices()
    {
        return $this->hasMany(Apprentice::class, 'program_id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'program_teachers', 'program_id', 'teacher_id');
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class, 'program_id');
    }

    public function getLevelAttribute($value)
    {
        return $value ?? $this->level?->nombre;
    }

    public function setLevelAttribute($value)
    {
        $this->attributes['level'] = $value;
        $nivel = Level::where('nombre', $value)->first();
        if ($nivel) {
            $this->attributes['nivel_id'] = $nivel->id;
        }
    }
}
