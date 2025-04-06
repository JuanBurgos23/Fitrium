<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Casillero extends Model
{
    protected $table = 'casillero';
    protected $fillable = [
        'id',
        'nro_casillero',
        'estado',
    ];
}
