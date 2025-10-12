<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;
use Illuminate\Support\Facades\Http;

class ProductRealImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dir = storage_path('app/public/products');
        if (!file_exists($dir)) {
            mkdir($dir, 0755, true);
        }

        $productos = Producto::all();

        foreach ($productos as $p) {
            $keyword = urlencode(substr($p->nombre_producto ?? 'product', 0, 50));
            $url = "https://source.unsplash.com/800x600/?{$keyword}";

            try {
                $response = Http::timeout(10)->get($url);
                if (!$response->successful()) {
                    $this->command->error("No se pudo descargar imagen para producto id={$p->id_producto}");
                    continue;
                }

                $contents = $response->body();
                $filename = 'product_'.$p->id_producto.'.jpg';
                $path = $dir.DIRECTORY_SEPARATOR.$filename;
                file_put_contents($path, $contents);

                // Ruta pública accesible vía public/storage/products/...
                $publicPath = '/storage/products/'.$filename;
                $p->imagen = $publicPath;
                $p->save();

                $this->command->info("Imagen real asignada a producto id={$p->id_producto}");
            } catch (\Exception $e) {
                $this->command->error('Error descargando imagen: '.$e->getMessage());
            }
        }
    }
}
