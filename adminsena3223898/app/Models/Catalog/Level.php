<?php

namespace App\Models\Catalog;

use App\Models\Academic\Program;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    use HasFactory;

    protected $table = 'niveles_formacion';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function programs()
    {
        return $this->hasMany(Program::class, 'nivel_id');
    }
}
