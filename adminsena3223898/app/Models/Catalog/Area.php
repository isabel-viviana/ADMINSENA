<?php

namespace App\Models\Catalog;

use App\Models\Academic\Course;
use App\Models\Academic\Program;
use App\Models\People\Teacher;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        'name',
    ];

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'area_id');
    }

    public function programs()
    {
        return $this->hasMany(Program::class, 'area_id');
    }

    public function courses()
    {
        return $this->hasMany(Course::class, 'area_id');
    }
}
