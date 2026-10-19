<?php

namespace App\Models\Academic;

use App\Models\Catalog\Area;
use App\Models\Catalog\TrainingCenter;
use App\Models\People\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $table = 'courses';

    protected $fillable = [
        'name_curso',
        'codigo_curso',
        'description',
        'duracion_horas',
        'level',
        'area_id',
        'training_centers_id',
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

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'course_teachers', 'course_id', 'teacher_id');
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class, 'course_id');
    }
}
