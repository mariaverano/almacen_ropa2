<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class ProductImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productos = Producto::all();

        foreach ($productos as $p) {
            // Generar una URL placeholder que incluya el nombre del producto
            $text = urlencode(substr($p->nombre_producto ?? 'Producto', 0, 40));
            $url = "https://via.placeholder.com/800x600.png?text={$text}";

            $p->imagen = $url;
            $p->save();
            $this->command->info("Imagen asignada a producto id={$p->id_producto}");
        }
    }
}
