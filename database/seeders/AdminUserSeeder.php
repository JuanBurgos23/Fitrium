<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Asegúrate de importar tu modelo User
use Spatie\Permission\Models\Role; // Si usas Spatie para roles

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Verifica si no hay usuarios en la base de datos
        if (User::count() === 0) {
            // Crear el usuario Admin
            $admin = User::create([
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => bcrypt('juan1234'), // Asegúrate de usar una contraseña segura
            ]);

            // Crear o obtener el rol 'Administrador'
            $role = Role::firstOrCreate(['name' => 'Administrador']);

            // Asignar el rol de administrador al usuario
            $admin->assignRole($role);
        }
    }
}
