<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inscripcion extends Model
{
    use HasFactory;
    protected $table = "inscripcion";

    protected $fillable = ['cliente_id', 'paquete_id', 'fecha_inicio', 'fecha_expiracion', 'estado'];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function paquete()
    {
        return $this->belongsTo(Paquete::class);
    }

    public function recibo()
    {
        return $this->hasOne(Recibo::class, 'id_inscripcion');
    }
    public function actualizarEstado()
    {
        $hoy = Carbon::today();
        if ($hoy->greaterThan($this->fecha_expiracion)) {
            $this->estado = 'Caducado';
            $mesDespues = Carbon::parse($this->fecha_expiracion)->addMonth();
            if ($hoy->greaterThan($mesDespues)) {
                $this->estado = 'Abandonado';
            }
            $this->save();
        }
    }
    public function recibos()
    {
        return $this->hasMany(Recibo::class, 'id_inscripcion');  // Asegúrate que el nombre de la clave foránea es correcto
    }
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_inscripcion');  // Asegúrate que el nombre de la clave foránea es correcto
    }
}
