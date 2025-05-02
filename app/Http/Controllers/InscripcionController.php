<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Paquete;
use App\Models\Inscripcion;
use App\Models\Recibo;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class InscripcionController extends Controller
{
    public function index(Request $request)
    {
        // Obtener el valor del input de búsqueda
        $search = $request->input('search', '');

        // Construimos la consulta base
        $query = Cliente::with(['inscripciones' => function ($query) {
            $query->orderBy('fecha_expiracion', 'desc'); // Ordenamos inscripciones por fecha de expiración
        }, 'inscripciones.paquete']);

        // Aplicamos el filtro de búsqueda
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('ci', 'like', '%' . $search . '%')
                    ->orWhere('paterno', 'like', '%' . $search . '%');
            });
        }

        // Ordenamos clientes por fecha de creación (último agregado primero) y aplicamos paginación
        $clientes = $query->orderBy('created_at', 'desc')->paginate(10);

        // Transformamos la colección para seleccionar las inscripciones más recientes de cada tipo
        $clientes->getCollection()->transform(function ($cliente) {
            // Obtener la inscripción vigente más reciente
            $inscripcionVigente = $cliente->inscripciones->where('estado', 'Vigente')->sortByDesc('fecha_expiracion')->first();

            // Obtener la inscripción caducada más reciente
            $inscripcionCaducada = $cliente->inscripciones->where('estado', 'Caducado')->sortByDesc('fecha_expiracion')->first();

            // Seleccionar solo las inscripciones más recientes de ambos estados
            $inscripcionesSeleccionadas = collect([$inscripcionVigente, $inscripcionCaducada])->filter();

            // Si el cliente no tiene inscripciones relevantes, lo eliminamos de la lista
            if ($inscripcionesSeleccionadas->isEmpty()) {
                return null;
            }

            // Reemplazamos la relación con solo las inscripciones seleccionadas
            $cliente->setRelation('inscripciones', $inscripcionesSeleccionadas);

            return $cliente;
        })->filter(); // Eliminamos clientes sin inscripciones relevantes

        $paquetes = Paquete::all();

        return view('inscripcion.inscripcion', compact('clientes', 'paquetes', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',

            'paquete_id' => 'required|exists:paquete,id',
        ]);

        // Buscar si el cliente ya existe
        $cliente = $request->filled('ci')
            ? Cliente::where('ci', $request->ci)->first()
            : null;

        if (!$cliente) {
            // Si no existe, lo creamos
            $cliente = Cliente::create([
                'nombre' => $request->nombre,
                'paterno' => $request->paterno,
                'materno' => $request->materno,
                'ci' => $request->ci ? $request->ci : 'SIN-CI-' . uniqid(),
                'telefono' => $request->telefono,
                'correo' => $request->correo,
            ]);
        }

        // Buscar la inscripción vigente (si existe)
        $inscripcionVigente = Inscripcion::where('cliente_id', $cliente->id)
            ->where('estado', 'Vigente')
            ->orderBy('fecha_expiracion', 'desc')
            ->first();

        // Buscar la última inscripción futura (si existe)
        $inscripcionFutura = Inscripcion::where('cliente_id', $cliente->id)
            ->where('estado', 'Pendiente')
            ->orderBy('fecha_expiracion', 'desc')
            ->first();

        // Obtener la duración del nuevo paquete
        $paquete = Paquete::findOrFail($request->paquete_id);
        $dias_paquete = $paquete->duracion;

        if ($inscripcionFutura) {
            // Si ya tiene una inscripción futura, extendemos su duración
            $inscripcionFutura->fecha_expiracion = Carbon::parse($inscripcionFutura->fecha_expiracion)->addDays($dias_paquete);
            $inscripcionFutura->save();

            return redirect()->route('mostrar_inscripcion')
                ->with('success', 'Renovación agregada. La fecha de expiración ha sido extendida.');
        }

        // Determinar fecha de inicio y expiración
        if ($inscripcionVigente) {
            // Si hay inscripción vigente, la nueva inicia después de la actual
            $fecha_inicio = Carbon::parse($inscripcionVigente->fecha_expiracion)->addDay();
        } else {
            // Si no hay inscripción vigente, inicia hoy
            $fecha_inicio = Carbon::today();
        }

        $duracionNueva = $paquete->duracion;

        // Crear nueva inscripción
        $inscripcion = Inscripcion::create([
            'cliente_id' => $cliente->id,
            'paquete_id' => $paquete->id,
            'fecha_inicio' => $fecha_inicio,
            'fecha_expiracion' => $duracionNueva == 1 ? Carbon::today() : Carbon::today()->addDays($duracionNueva),
            'estado' => $fecha_inicio->isToday() ? 'Vigente' : 'Pendiente'
        ]);


        // Obtener el último número de recibo y sumarle 1
        $ultimoRecibo = Recibo::latest('id')->first();
        $numeroRecibo = $ultimoRecibo ? str_pad($ultimoRecibo->id + 1, 6, '0', STR_PAD_LEFT) : '000001';

        Recibo::create([
            'numero_recibo' => $numeroRecibo, // 🔹 Ahora con 6 dígitos
            'recibido_de' => $cliente->nombre_completo,
            'concepto' => $paquete->nombre,
            'a_cuenta' => $request->a_cuenta,
            'saldo' => $request->saldo,
            'total' => $request->total,
            'forma_pago' => $request->forma_pago,
            'fecha_pago' => Carbon::today(),
            'estado' => $request->a_cuenta >= $paquete->precio ? 'Pagado' : 'Debe',
            'id_inscripcion' => $inscripcion->id
        ]);
        // Verificar las fechas en logs
        \Log::info("Fecha actual: " . Carbon::today()->toDateString());
        \Log::info("Fecha inicio: " . $fecha_inicio->toDateString());

        return redirect()->route('mostrar_inscripcion')
            ->with('success', 'Inscripción registrada correctamente.');
    }
    public function pagarRecibo(Request $request)
    {
        $request->validate([
            'recibo_id' => 'required|exists:recibo,id',
            'monto_pagadoDeuda' => 'required|numeric|min:0',
            'forma_pagoDeuda' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Obtener el recibo original
            $reciboOriginal = Recibo::findOrFail($request->recibo_id);
            $montoPagado = $request->monto_pagadoDeuda;

            // Obtener el último recibo de la misma inscripción para calcular el saldo actualizado
            $ultimoRecibo = Recibo::where('id_inscripcion', $reciboOriginal->id_inscripcion)
                ->latest('id') // Tomar el más reciente
                ->first();

            // Usar el saldo del último recibo o el saldo inicial del recibo original
            $saldoActual = $ultimoRecibo ? $ultimoRecibo->saldo : $reciboOriginal->saldo;

            // Calcular el nuevo saldo correctamente
            $nuevoSaldo = max(0, $saldoActual - $montoPagado); // Evita valores negativos

            // Obtener la inscripción asociada
            $inscripcion = Inscripcion::findOrFail($reciboOriginal->id_inscripcion);
            $cliente = Cliente::findOrFail($inscripcion->cliente_id);

            // Obtener el último número de recibo y generar el nuevo
            $ultimoNumeroRecibo = Recibo::latest('id')->first();
            $numeroRecibo = $ultimoNumeroRecibo ? str_pad($ultimoNumeroRecibo->id + 1, 6, '0', STR_PAD_LEFT) : '000001';

            // Crear un nuevo recibo con el saldo correcto
            $nuevoRecibo = Recibo::create([
                'numero_recibo' => $numeroRecibo,
                'recibido_de' => $cliente->nombre_completo,
                'concepto' => $reciboOriginal->concepto,
                'a_cuenta' => $montoPagado,
                'saldo' => $nuevoSaldo, // Ahora usa el saldo del último recibo
                'total' => $reciboOriginal->total,
                'forma_pago' => $request->forma_pagoDeuda,
                'fecha_pago' => Carbon::today(),
                'estado' => $nuevoSaldo == 0 ? 'Pagado' : 'Debe',
                'id_inscripcion' => $reciboOriginal->id_inscripcion,
            ]);

            // Si el saldo es 0, actualizar todos los recibos asociados a esta inscripción
            if ($nuevoSaldo == 0) {
                Recibo::where('id_inscripcion', $reciboOriginal->id_inscripcion)
                    ->update(['estado' => 'Pagado']);
            }

            DB::commit();

            return redirect()->route('mostrar_inscripcion')
                ->with('success', 'Pago realizado con éxito. Se ha registrado en el historial.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Ocurrió un error al procesar el pago. Intenta nuevamente.');
        }
    }




    protected function generarNumeroRecibo()
    {
        // Obtener el último número de recibo y sumarle 1
        $ultimoRecibo = Recibo::latest('id')->first();
        return $ultimoRecibo ? str_pad($ultimoRecibo->id + 1, 6, '0', STR_PAD_LEFT) : '000001';
    }

    public function renovarInscripcion(Request $request, $id)
    {
        $request->validate([
            'paquete_idRenovar' => 'required|exists:paquete,id',
        ]);

        // Obtener la inscripción
        $inscripcion = Inscripcion::findOrFail($id);
        $fechaExpiracion = Carbon::parse($inscripcion->fecha_expiracion);

        // Obtener la duración del nuevo paquete
        $paquete = Paquete::findOrFail($request->paquete_idRenovar);
        $duracionNueva = $paquete->duracion;

        if ($fechaExpiracion->isPast()) {
            // Si la inscripción ha expirado, se crea una nueva
            $nuevaInscripcion = Inscripcion::create([
                'cliente_id' => $inscripcion->cliente_id,
                'paquete_id' => $request->paquete_idRenovar,
                'fecha_inicio' => Carbon::today(),
                'fecha_expiracion' => $duracionNueva == 1 ? Carbon::today() : Carbon::today()->addDays($duracionNueva),
                'estado' => 'Vigente'
            ]);

            // Obtener cliente
            $cliente = Cliente::findOrFail($inscripcion->cliente_id);

            // Obtener último número de recibo y sumarle 1
            $ultimoRecibo = Recibo::latest('id')->first();
            $numeroRecibo = $ultimoRecibo ? str_pad($ultimoRecibo->id + 1, 6, '0', STR_PAD_LEFT) : '000001';

            Recibo::create([
                'numero_recibo' => $numeroRecibo,
                'recibido_de' => $cliente->nombre_completo,
                'concepto' => $paquete->nombre,
                'a_cuenta' => $request->a_cuentaRenovar,
                'saldo' => $request->saldoRenovar,
                'total' => $request->totalRenovar,
                'forma_pago' => $request->forma_pagoRenovar,
                'fecha_pago' => Carbon::today(),
                'estado' => $request->a_cuentaRenovar >= $paquete->precio ? 'Pagado' : 'Debe',
                'id_inscripcion' => $nuevaInscripcion->id
            ]);

            return redirect()->route('mostrar_inscripcion')
                ->with('success', 'Nueva inscripción creada porque la anterior ya expiró.');
        }

        // Si la inscripción sigue vigente, extendemos su duración
        $inscripcion->paquete_id = $request->paquete_idRenovar;
        $inscripcion->fecha_expiracion = $duracionNueva == 1 ? Carbon::today() : $fechaExpiracion->addDays($duracionNueva);
        $inscripcion->estado = 'Vigente';
        $inscripcion->save();

        // Obtener cliente
        $cliente = Cliente::findOrFail($inscripcion->cliente_id);

        // Obtener último número de recibo y sumarle 1
        $ultimoRecibo = Recibo::latest('id')->first();
        $numeroRecibo = $ultimoRecibo ? str_pad($ultimoRecibo->id + 1, 6, '0', STR_PAD_LEFT) : '000001';

        // Crear recibo para la renovación
        $nuevoRecibo = Recibo::create([
            'numero_recibo' => $numeroRecibo,
            'recibido_de' => $cliente->nombre_completo,
            'concepto' => $paquete->nombre,
            'a_cuenta' => $request->a_cuentaRenovar,
            'saldo' => $request->saldoRenovar,
            'total' => $request->totalRenovar,
            'forma_pago' => $request->forma_pagoRenovar,
            'fecha_pago' => Carbon::today(),
            'estado' => $request->a_cuentaRenovar >= $paquete->precio ? 'Pagado' : 'Debe',
            'id_inscripcion' => $inscripcion->id
        ]);

        // Redirigir asegurando que el nuevo recibo sea visible
        return redirect()->route('mostrar_inscripcion', ['id' => $inscripcion->id])
            ->with('success', 'La inscripción ha sido renovada con éxito.')
            ->with('nuevo_recibo', $nuevoRecibo->id);
    }

    public function actualizarEstados()
    {
        $inscripciones = Inscripcion::all();
        foreach ($inscripciones as $inscripcion) {
            $inscripcion->actualizarEstado();
        }

        return response()->json(['message' => 'Estados actualizados']);
    }

    public function buscar(Request $request)
    {
        $query = $request->query('query');

        $clientes = Cliente::where('nombre', 'LIKE', "%{$query}%")
            ->orWhere('ci', 'LIKE', "%{$query}%")
            ->get(['id', 'nombre', 'paterno', 'materno', 'ci', 'telefono', 'correo']);

        return response()->json($clientes);
    }

    public function historial(Request $request)
    {
        // Obtener el valor del input de búsqueda
        $search = $request->input('search', '');

        // Construimos la consulta base con las relaciones necesarias
        $query = Inscripcion::with(['cliente', 'paquete'])
            ->orderBy('created_at', 'desc'); // Ordenamos por fecha de creación (última inscripción primero)

        // Filtro por búsqueda (nombre o CI del cliente)
        if (!empty($search)) {
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('ci', 'like', '%' . $search . '%')
                    ->orWhere('paterno', 'like', '%' . $search . '%');
            });
        }

        // Filtro por rango de fechas de inscripción
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [$request->fecha_inicio, $request->fecha_fin]);
        }

        // Paginar resultados
        $inscripciones = $query->paginate(10);

        return view('inscripcion.historial', compact('inscripciones', 'search'));
    }



    public function exportPDF(Request $request)
    {
        $search = $request->input('search', '');
        $fechaInicio = $request->input('fecha_inicio');
        $fechaFin = $request->input('fecha_fin');

        // Consulta base con relaciones
        $query = Inscripcion::with(['cliente', 'paquete'])
            ->orderBy('created_at', 'desc');

        // Filtrar por CI o Apellido Paterno del cliente
        if (!empty($search)) {
            $query->whereHas('cliente', function ($q) use ($search) {
                $q->where('ci', 'like', '%' . $search . '%')
                    ->orWhere('paterno', 'like', '%' . $search . '%');
            });
        }

        // Filtrar por rango de fechas
        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [$fechaInicio, $fechaFin]);
        }

        // Obtener las inscripciones filtradas
        $inscripciones = $query->get();

        // Generar PDF con las inscripciones filtradas
        $pdf = Pdf::loadView('exports.historial-pdf', compact('inscripciones'));

        return $pdf->download('historial_inscripciones.pdf');
    }

    public function verHistorial($id)
    {
        $cliente = Cliente::with('inscripciones.paquete')->findOrFail($id);
        return view('inscripcion.historialCliente', compact('cliente'));
    }

    public function exportarPDF($id)
    {
        $cliente = Cliente::with('inscripciones.paquete')->findOrFail($id);
        $pdf = Pdf::loadView('exports.historialCliente', compact('cliente'));

        return $pdf->download('historial_' . $cliente->nombre_completo . '.pdf');
    }
}
