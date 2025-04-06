<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Casillero;
use App\Models\Cliente;
use App\Models\Inscripcion;
use Illuminate\Http\Request;

class AsistenciaController extends Controller
{
    public function index()
    {
        $asistencias = Asistencia::with(['inscripcion.cliente', 'casillero'])
            ->where('estado', 'Activo')
            ->latest()
            ->get();

        // Clientes vigentes
        $clientesVigentes = Inscripcion::where('estado', 'Vigente')->with('cliente')->get();

        // Casilleros disponibles
        $casillerosDisponibles = Casillero::where('estado', 'Disponible')->get();

        return view('asistencia.asistencia', compact('asistencias', 'clientesVigentes', 'casillerosDisponibles'));
    }

    public function store(Request $request)
    {

        Asistencia::create([
            'id_inscripcion' => $request->id_inscripcion,
            'id_casillero' => $request->casillero_id,
            'fecha_ingreso' => now(),
            'hora_entrada' => now()->format('H:i:s'),
            'hora_salida' => null,
            'estado' => 'Activo',
        ]);

        $casilero = Casillero::find($request->casillero_id);
        $casilero->estado = 'Ocupado'; // Cambiamos el estado del casillero a ocupado
        $casilero->save(); // Guardamos el cambio en la base de datos

        // Opcional: Cambiar estado del casillero a ocupado
        Casillero::where('id', $request->casillero_id)->update(['estado' => 'Ocupado']);

        return redirect()->back()->with('success', 'Asistencia registrada correctamente');
    }
    public function buscar(Request $request)
    {
        $buscar = $request->buscar;

        $clientes = Cliente::where(function ($query) use ($buscar) {
            $query->where('ci', 'LIKE', "%{$buscar}%")
                ->orWhere('paterno', 'LIKE', "%{$buscar}%");
        })->get();

        return view('asistencia.buscar', compact('clientes'));
    }
    public function finalizarAsistencia($id)
    {
        $asistencia = Asistencia::findOrFail($id);
        $asistencia->hora_salida = now()->format('H:i:s');
        $asistencia->estado = 'finalizado';
        $asistencia->save();

        // Validamos si existe el casillero
        $casillero = Casillero::find($asistencia->id_casillero);
        if ($casillero) {
            $casillero->estado = 'Disponible';
            $casillero->save();
        }

        return redirect()->back()->with('success', 'Asistencia finalizada con éxito.');
    }

    public function buscarVigentes(Request $request)
    {
        $query = $request->query('query');

        // Buscar clientes con inscripciones vigentes
        $clientes = Cliente::whereHas('inscripciones', function ($q) {
            $q->where('estado', 'Vigente');
        })
            ->where(function ($q) use ($query) {
                $q->where('ci', 'LIKE', "%$query%")
                    ->orWhere('nombre', 'LIKE', "%$query%")
                    ->orWhere('paterno', 'LIKE', "%$query%");
            })
            ->get()
            ->map(function ($cliente) {
                // Solo devolver clientes con inscripción vigente
                $inscripcionVigente = $cliente->inscripciones()->where('estado', 'Vigente')->first();
                if ($inscripcionVigente) {
                    return [
                        'id' => $inscripcionVigente->id,
                        'ci' => $cliente->ci,
                        'nombre_completo' => $cliente->nombre . ' ' . $cliente->paterno,
                    ];
                }
                return null;
            })
            ->filter(); // Filtrar clientes nulos (si algún cliente no tiene inscripción vigente)

        // Si no hay clientes vigentes
        if ($clientes->isEmpty()) {
            return response()->json(['mensaje' => 'No hay clientes vigentes para esta búsqueda.'], 404);
        }

        return response()->json($clientes);
    }
}
