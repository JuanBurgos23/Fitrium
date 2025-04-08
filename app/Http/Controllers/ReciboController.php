<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Recibo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Browsershot\Browsershot;

class ReciboController extends Controller
{
    public function generarRecibo($id)
    {
        $recibo = Recibo::findOrFail($id);
        $totalAbonado = Recibo::where('id_inscripcion', $recibo->id_inscripcion)
            ->sum('a_cuenta');

        $pdf = PDF::loadView('recibo.reciboPdf', compact('recibo', 'totalAbonado'));


        // Tamaño exacto en puntos (1mm = 2.83465pt)
        // 80mm = 226.77pt, 150mm = 425.19pt
        $pdf->setPaper([0, 0, 226.77, 425.19], 'portrait');

        return $pdf->download("recibo_{$recibo->id}.pdf");
    }
    public function show($id)
    {
        $recibo = Recibo::findOrFail($id);

        // Sumar todos los pagos anteriores (a_cuenta) de la misma inscripción
        $totalAbonado = Recibo::where('id_inscripcion', $recibo->id_inscripcion)
            ->sum('a_cuenta');

        // Obtener el último saldo registrado en el recibo más reciente de la inscripción
        $ultimoRecibo = Recibo::where('id_inscripcion', $recibo->id_inscripcion)
            ->latest('id') // Obtener el último recibo creado
            ->first();

        $saldoPendiente = $ultimoRecibo ? $ultimoRecibo->saldo : 0; // Si no hay recibo, saldo 0

        return response()->json([
            'id' => $recibo->id,
            'recibido_de' => $recibo->recibido_de,
            'concepto' => $recibo->concepto,
            'total' => $recibo->total,
            'a_cuenta' => $totalAbonado, // Suma de todos los pagos anteriores
            'saldo' => $saldoPendiente, //  Último saldo registrado
        ]);
    }
    public function verRecibos($id)
    {
        $cliente = Cliente::findOrFail($id);

        // Obtener el criterio de ordenamiento desde la request (por defecto será descendente)
        $orden = request('orden', 'desc');

        // Obtener los recibos directamente desde la base de datos con paginación
        $recibos = Recibo::whereHas('inscripcion', function ($query) use ($cliente) {
            $query->where('cliente_id', $cliente->id);
        })->orderBy('fecha_pago', $orden)
            ->paginate(10); // Paginación de 10 recibos

        return view('recibo.recibosCliente', compact('cliente', 'recibos', 'orden'));
    }
}
