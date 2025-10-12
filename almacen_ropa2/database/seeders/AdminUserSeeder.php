<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        DB::table('MV_usuarios')->insert([
            'nombre' => 'Admin Super',
            'correo' => 'admin@example.com',
            'telefono' => '3000000000',
            'direccion' => 'Oficina',
            'rol' => 'admin',
            'contrasena' => '$2y$12$AjB3PbabmvzCnw2RrX710.DQ2H4ff6eJrZ8QuVtdtQcEYpdnM6WYK',
        ]);
    }
}
