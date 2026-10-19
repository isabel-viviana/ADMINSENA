<?php

namespace App\Models\Resource;

use App\Models\Academic\Apprentice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Computer extends Model
{
    use HasFactory;

    protected $table = 'computers';

    protected $fillable = [
        'serial_num',
        'numero',
        'marca',
    ];
    
    protected $guarded = [
        'urlFoto'
    ];

    public function apprentices()
    {
        return $this->hasMany(Apprentice::class, 'computer_id');
    }
}
