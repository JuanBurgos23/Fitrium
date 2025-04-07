<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'Recepcionista'); // Filtrar solo usuarios con el rol 'Recepcionista'
        })
            ->with('roles') // Solo necesitas cargar la relación 'roles', no 'Recepcionista' directamente
            ->get();

        return view('empleado.empleado', compact('users'));
    }


    public function store(Request $request)
    {
        // Validación de los datos del usuario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        // Crear el nuevo usuario
        $user = new User();
        $user->name = $request->name;
        $user->paterno = $request->paterno ?? null; // Asignar campo paterno si existe
        $user->materno = $request->materno ?? null; // Asignar campo materno si existe
        $user->telefono = $request->telefono ?? null; // Asignar campo teléfono si existe
        $user->ci = $request->ci ?? null; // Asignar campo CI si existe
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        // Asignar el rol de Recepcionista
        $role = Role::findByName('Recepcionista'); // Asegúrate de que el rol 'Recepcionista' esté creado
        $user->assignRole($role);

        return redirect()->route('mostrar_empleado')->with('success', 'Recepcionista creado exitosamente.');
    }
    public function edit($id)
    {
        $usuario = User::findOrFail($id);  // Obtiene el usuario por ID
        return response()->json($usuario); // Devuelve los datos en formato JSON
    }

    public function update(Request $request, $id)
    {
        $usuario = User::findOrFail($id);

        $usuario->name = $request->name;
        $usuario->paterno = $request->paterno;
        $usuario->materno = $request->materno;
        $usuario->ci = $request->ci;
        $usuario->telefono = $request->telefono;
        $usuario->email = $request->email;

        // Si se quiere cambiar la contraseña
        if ($request->has('password') && $request->password != '') {
            $usuario->password = bcrypt($request->password); // Encriptamos la nueva contraseña
        }

        $usuario->save();

        return redirect()->route('mostrar_empleado')->with('success', 'Usuario actualizado correctamente.');
    }
}
