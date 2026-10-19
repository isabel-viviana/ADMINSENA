<?php

namespace App\Models\Catalog;

use App\Models\Academic\Intake;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modality extends Model
{
    use HasFactory;

    protected $table = 'modalidades';

    protected $fillable = [
        'nombre',
    ];

    public function intakes()
    {
        return $this->hasMany(Intake::class, 'modalidad_id');
    }
}
