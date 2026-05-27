<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use App\Services\NutritionScannerService;
use App\Services\NutrisiService;
$path = __DIR__ . '/tmp-food.png';
file_put_contents($path, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAABlBMVEUAAAD///+l2Z/dAAAACklEQVR4nGNgAAAAAgAB4iG8MwAAAABJRU5ErkJggg=='));
$scanner = new NutritionScannerService(new NutrisiService());
$result = $scanner->scan($path);
var_dump($result);
unlink($path);
