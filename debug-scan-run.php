<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Http\Controllers\ScannerController;
use App\Services\NutritionScannerService;
use App\Services\NutrisiService;
file_put_contents('tmp-food.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAABlBMVEUAAAD///+l2Z/dAAAACklEQVR4nGNgAAAAAgAB4iG8MwAAAABJRU5ErkJggg=='));
$uploaded = new UploadedFile(__DIR__ . '/tmp-food.png', 'tmp-food.png', 'image/png', null, true);
$request = Request::create('/scanner/analyze-food', 'POST', [], [], ['foto' => $uploaded]);
$controller = new ScannerController(new NutritionScannerService(new NutrisiService()));
try {
    $response = $controller->analyzeFood($request);
    var_dump($response->getStatusCode());
    echo $response->getContent();
} catch (Exception $e) {
    echo 'ERROR: ' . $e->getMessage() . PHP_EOL;
}
unlink(__DIR__ . '/tmp-food.png');
