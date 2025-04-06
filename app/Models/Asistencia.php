<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $table = 'asistencia';

    protected $fillable = [
        'id',
        'id_inscripcion', // ID de la inscripción asociada
        'id_casillero', // ID del casillero asignado
        'fecha_ingreso',
        'hora_entrada',
        'hora_salida',
        'estado',
    ];
    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class,'id_inscripcion'); // Asegúrate de que el nombre de la clave foránea es correcto
    }
    public function casillero()
    {
        return $this->belongsTo(Casillero::class,'id_casillero'); // Asegúrate de que el nombre de la clave foránea es correcto
    }


}
