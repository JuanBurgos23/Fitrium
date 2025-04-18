<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Llama a otros seeders aquí si es necesario
        $this->call(AdminUserSeeder::class);
        $this->call(RolesSeeder::class);
    }
}
