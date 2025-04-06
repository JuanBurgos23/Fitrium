<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    protected $table = 'recibo';
    protected $fillable = [
        'numero_recibo',
        'recibido_de',
        'concepto',
        'a_cuenta',
        'saldo',
        'total',
        'forma_pago',
        'fecha_pago',
        'estado',
        'id_inscripcion'
    ];

    public function inscripcion()
    {
        return $this->belongsTo(Inscripcion::class,'id_inscripcion');
    }
    
}
