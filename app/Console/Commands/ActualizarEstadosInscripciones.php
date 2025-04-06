<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Inscripcion;

class ActualizarEstadosInscripciones extends Command
{
    /**
     * El nombre y la firma del comando de la consola.
     *
     * @var string
     */
    protected $signature = 'inscripciones:actualizar-estados';

    /**
     * La descripción del comando.
     *
     * @var string
     */
    protected $description = 'Actualiza el estado de las inscripciones a caducado o abandonado si es necesario.';

    /**
     * Ejecutar el comando de la consola.
     *
     * @return void
     */
    public function handle()
    {
        $inscripciones = Inscripcion::all();
        foreach ($inscripciones as $inscripcion) {
            $inscripcion->actualizarEstado();
        }

        $this->info('Estados actualizados.');
    }
}
