<?php
$projectRoot = dirname(__DIR__);
require $projectRoot.'/vendor/autoload.php';
$app = require_once $projectRoot.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$table = 'MV_pedidos';
$cols = DB::select("SHOW COLUMNS FROM `{$table}`");
if (!$cols) {
    echo "Table {$table} not found or has no columns.".PHP_EOL;
    exit(1);
}

foreach ($cols as $c) {
    echo $c->Field . ' - ' . $c->Type . (isset($c->Null) ? ' NULL='.$c->Null : '') . PHP_EOL;
}
