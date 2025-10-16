<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Producto;

class UpdateProductImagesFromStorageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dir = storage_path('app/public/products');
        if (!is_dir($dir)) {
            $this->command->error("La carpeta {$dir} no existe. Crea y coloca las imágenes allí.");
            return;
        }

        $productos = Producto::all();
        $updated = 0;

        foreach ($productos as $p) {
            $base = $dir.DIRECTORY_SEPARATOR.'product_'.$p->id_producto;
            // buscar extensiones comunes
            $found = null;
            foreach (['jpg','jpeg','png','webp'] as $ext) {
                $path = $base.'.'.$ext;
                if (file_exists($path)) { $found = 'product_'.$p->id_producto.'.'.$ext; break; }
            }

            if ($found) {
                $p->imagen = '/storage/products/'.$found;
                $p->save();
                $this->command->info("Actualizada imagen producto id={$p->id_producto} -> {$found}");
                $updated++;
            }
        }

        $this->command->info("Total productos actualizados: {$updated}");
    }
}
