<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VerificarLicencia
{
    public function handle(Request $request, Closure $next)
    {
        $rutaLicencia = base_path('.licencia');

        if (!file_exists($rutaLicencia)) {
            return response()->view('licencia.expirada');
        }

        $licencia = json_decode(file_get_contents($rutaLicencia), true);
        $hoy = Carbon::today();
        $fechaFin = Carbon::parse($licencia['fecha_fin']);

        if ($hoy->greaterThan($fechaFin)) {
            return response()->view('licencia.expirada');
        }

        return $next($request);
    }
}
