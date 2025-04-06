<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Inscripcion;
use App\Models\Paquete;
use App\Models\Recibo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Obtener los paquetes más inscritos
        $paquetesInscritos = Inscripcion::select('paquete_id', DB::raw('count(*) as total'))
            ->groupBy('paquete_id')
            ->orderByDesc('total')
            ->limit(5)  // Limitar a los 5 más inscritos
            ->get();

        // Obtener los nombres de los paquetes y sus inscripciones
        $paquetesData = $paquetesInscritos->map(function ($inscripcion) {
            $paquete = Paquete::find($inscripcion->paquete_id);
            return [
                'name' => $paquete->nombre,  // Suponiendo que tienes una columna 'nombre' en la tabla Paquete
                'y' => $inscripcion->total
            ];
        });

        // Obtener el total de clientes
        $totalClientes = Cliente::count();

        // Obtener clientes con inscripción vigente
        $clientesActivos = Inscripcion::where('estado', 'Vigente')->count();

        // Calcular ingresos de hoy
        $ingresosHoy = Recibo::whereDate('fecha_pago', Carbon::today())->sum('a_cuenta');

        return view('dashboard.dashboard', compact('totalClientes', 'clientesActivos', 'ingresosHoy', 'paquetesData'));
    }
}
