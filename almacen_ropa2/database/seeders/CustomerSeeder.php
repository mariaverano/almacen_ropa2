<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        // Evitar duplicados en caso de re-ejecución
        $exists = DB::table('MV_usuarios')->where('correo', 'cliente@example.com')->first();
        if ($exists) {
            return;
        }

        DB::table('MV_usuarios')->insert([
            'nombre' => 'Cliente Demo',
            'correo' => 'cliente@example.com',
            'telefono' => '3001112222',
            'direccion' => 'Calle Ejemplo 123',
            'rol' => 'cliente',
            'contrasena' => Hash::make('Cliente1234'),
        ]);
    }
}
