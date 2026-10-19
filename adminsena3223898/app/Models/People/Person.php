<?php

namespace App\Models\People;

use App\Models\Academic\Apprentice;
use App\Models\Academic\Enrollment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'personas';

    protected $fillable = [
        'user_id',
        'tipo_documento',
        'numero_documento',
        'primer_nombre',
        'segundo_nombre',
        'primer_apellido',
        'segundo_apellido',
        'fecha_nacimiento',
        'genero',
        'correo_contacto',
        'telefono',
        'direccion',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class, 'persona_id');
    }

    public function apprentice()
    {
        return $this->hasOne(Apprentice::class, 'persona_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'persona_id');
    }
}
