<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Paquete extends Model
{
    use HasFactory;
    protected $table = "paquete";
    protected $fillable = ['nombre', 'duracion', 'precio'];
}
