<?php

namespace App\Models\People;

use App\Models\Academic\Course;
use App\Models\Academic\Intake;
use App\Models\Academic\Program;
use App\Models\Catalog\Area;
use App\Models\Catalog\TrainingCenter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $table = 'teachers';

    protected $fillable = [
        'persona_id',
        'name',
        'codigo_instructor',
        'especialidad',
        'email',
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

    public function trainingCenter()
    {
        return $this->belongsTo(TrainingCenter::class, 'training_centers_id');
    }

    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_teachers', 'teacher_id', 'program_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'course_teachers', 'teacher_id', 'course_id');
    }

    public function person()
    {
        return $this->belongsTo(Person::class, 'persona_id');
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class, 'teacher_id');
    }
}
