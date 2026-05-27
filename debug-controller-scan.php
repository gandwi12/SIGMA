<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\ScannerController;

$imgPath = __DIR__ . '/tmp-food.png';
file_put_contents($imgPath, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAABlBMVEUAAAD///+l2Z/dAAAACklEQVR4nGNgAAAAAgAB4iG8MwAAAABJRU5ErkJggg=='));
$uploaded = new UploadedFile($imgPath, 'tmp-food.png', 'image/png', null, true);
$request = Request::create('/scanner/analyze-food', 'POST', [], [], ['foto' => $uploaded]);
$controller = new ScannerController(new App\Services\NutritionScannerService(new App\Services\NutrisiService()));
$response = $controller->analyzeFood($request);
var_dump($response->getStatusCode());
var_dump($response->getContent());
