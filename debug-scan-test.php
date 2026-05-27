<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;

file_put_contents('tmp-food.png', base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAABlBMVEUAAAD///+l2Z/dAAAACklEQVR4nGNgAAAAAgAB4iG8MwAAAABJRU5ErkJggg=='));
$uploaded = new UploadedFile(__DIR__ . '/tmp-food.png', 'tmp-food.png', 'image/png', null, true);
var_dump('signature');
var_dump($uploaded->getError());
var_dump($uploaded->isValid());
var_dump($uploaded->getClientMimeType());
$request = Request::create('/scanner/analyze-food', 'POST', [], [], ['foto' => $uploaded]);
var_dump($request->files->all());
var_dump($request->file('foto'));
unlink(__DIR__ . '/tmp-food.png');
