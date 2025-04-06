<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;

class PaqueteController extends Controller
{
    public function index()
    {
        $paquetes = Paquete::all();
        return view('paquete.paquete', compact('paquetes'));
    }
    public function store(Request $request)
    {
        $paquete = new Paquete();
        $paquete->nombre = $request->nombre;
        $paquete->precio = $request->precio;
        $paquete->duracion = $request->duracion;
        
        $paquete->save();

        return redirect()->route('mostrar_paquete')->with('success', 'Paquete Registrado correctamente');
    }

    public function edit($id)
    {
        $paquete = Paquete::findOrFail($id);
        return response()->json($paquete); // Devolvemos el paquete como JSON
    }

    public function update(Request $request, $id)
    {
        $paquete = Paquete::find($id);
        $paquete->nombre = $request->nombre;
        $paquete->precio = $request->precio;
        $paquete->duracion = $request->duracion;

        $paquete->update();
        return redirect()->route('mostrar_paquete')->with('success', 'Paquete actualizado correctamente');
    }
}
