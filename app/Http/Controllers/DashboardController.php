<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Inscripcion;
use App\Models\Recibo;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $totalClientes = Cliente::count();

        // Contar clientes con inscripción vigente
        $clientesActivos = Inscripcion::where('estado', 'Vigente')->count();

        // Calcular ingresos de hoy
        $ingresosHoy = Recibo::whereDate('fecha_pago', Carbon::today())->sum('total');

        return view('dashboard.dashboard', compact('totalClientes', 'clientesActivos', 'ingresosHoy'));
    }
}
