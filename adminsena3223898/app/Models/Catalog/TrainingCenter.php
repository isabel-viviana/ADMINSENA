<?php

namespace App\Models\Catalog;

use App\Models\Academic\Course;
use App\Models\Academic\Intake;
use App\Models\Academic\Program;
use App\Models\People\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrainingCenter extends Model
{
    use HasFactory;

    protected $table = 'training_centers';

    protected $fillable = [
        'name',
        'location',
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'training_centers_id');
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'training_centers_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'training_centers_id');
    }

    public function intakes()
    {
        return $this->hasMany(Intake::class, 'training_center_id');
    }
}
