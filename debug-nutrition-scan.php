<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$filename = __DIR__ . '/tmp-test.png';
file_put_contents($filename, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAABlBMVEUAAAD///+l2Z/dAAAACklEQVR4nGNgAAAAAgAB4iG8MwAAAABJRU5ErkJggg=='));
$svc = new App\Services\NutritionScannerService(new App\Services\NutrisiService());
$result = $svc->scan($filename);
var_dump($result);
