<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
$apiKey = config('services.gemini.api_key') ?: env('GEMINI_API_KEY');
use Illuminate\Support\Facades\Http;
$path = __DIR__ . '/tmp-test.png';
file_put_contents($path, base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAABlBMVEUAAAD///+l2Z/dAAAACklEQVR4nGNgAAAAAgAB4iG8MwAAAABJRU5ErkJggg=='));
$imageData = file_get_contents($path);
$mimeType = 'image/png';
$base64Image = base64_encode($imageData);
$prompt = 'Kamu adalah ahli gizi Indonesia. Identifikasi makanan pada gambar ini dan berikan estimasi nutrisi JSON.';
$response = Http::timeout(30)->post("https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}", [
    'contents' => [
        [
            'parts' => [
                [
                    'inlineData' => [
                        'mimeType' => $mimeType,
                        'data' => $base64Image,
                    ],
                ],
                [
                    'text' => $prompt,
                ],
            ],
        ],
    ],
    'generationConfig' => [
        'temperature' => 0.2,
        'topP' => 0.8,
        'maxOutputTokens' => 1024,
    ],
]);
echo "status=" . $response->status() . "\n";
echo "ok=" . ($response->ok() ? 'true' : 'false') . "\n";
echo "body=" . substr($response->body(), 0, 2000) . "\n";
file_put_contents('debug-gemini-response-inline.json', json_encode($response->json(), JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
