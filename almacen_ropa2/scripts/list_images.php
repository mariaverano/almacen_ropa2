<?php
$projectRoot = dirname(__DIR__);
require $projectRoot.'/vendor/autoload.php';
$app = require_once $projectRoot.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Producto;

$prods = Producto::all();
foreach ($prods as $p) {
    echo $p->id_producto . " -> " . ($p->imagen ?: '[no-image]') . PHP_EOL;
}
