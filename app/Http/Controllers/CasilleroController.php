<?php

namespace App\Http\Controllers;

use App\Models\Casillero;
use Illuminate\Http\Request;

class CasilleroController extends Controller
{
    public function index()
    {
        $casilleros = Casillero::all();
        return view('casillero.casillero', compact('casilleros'));
    }

    public function store(Request $request)
    {
        $casillero = new Casillero();
        $casillero->nro_casillero = $request->nro_casillero;
        $casillero->estado = $request->estado;
        $casillero->save();
        return redirect()->route('mostrar_casillero')->with('success', 'Casillero Registrado correctamente');
    }

    public function edit($id)
    {
        $casillero = Casillero::findOrFail($id);
        return response()->json($casillero); // Devolvemos el casillero como JSON
    }

    public function update(Request $request, $id)
    {
        $casillero = Casillero::find($id);
        $casillero->nro_casillero = $request->nro_casillero;
        $casillero->estado = $request->estado;

        $casillero->update();
        return redirect()->route('mostrar_casillero')->with('success', 'Casillero actualizado correctamente');
    }
}
