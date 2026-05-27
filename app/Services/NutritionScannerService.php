<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NutritionScannerService
{
    protected NutrisiService $nutrisiService;

    public function __construct(NutrisiService $nutrisiService)
    {
        $this->nutrisiService = $nutrisiService;
    }

    /**
     * Scan image menggunakan Gemini Vision untuk mendeteksi makanan
     * dan mendapatkan data nutrisi.
     *
     * Alur:
     * 1. Kirim gambar ke Gemini Vision → dapat nama makanan + estimasi nutrisi
     * 2. Cross-reference dengan NutrisiService (database lokal Indonesia)
     * 3. Prioritaskan data lokal jika ada, fallback ke estimasi Gemini
     *
     * @param string $imagePath Lokasi absolut file gambar
     * @return array|null [nama, kalori, protein, lemak, karbo, confidence, description] atau null jika gagal
     */
    public function scan(string $imagePath): ?array
    {
        try {
            $apiKey = config('services.gemini.api_key') ?: env('GEMINI_API_KEY');

            if (!$apiKey) {
                Log::warning('NutritionScanner: Gemini API Key belum dikonfigurasi.');
                return null;
            }

            // Baca dan encode gambar ke base64
            $imageData = file_get_contents($imagePath);
            if (!$imageData) {
                Log::error('NutritionScanner: Gagal membaca file gambar.');
                return null;
            }

            $base64Image = base64_encode($imageData);
            $mimeType = $this->detectMimeType($imagePath);

            // Kirim ke Gemini Vision
            $result = $this->analyzeWithGeminiVision($apiKey, $base64Image, $mimeType);

            if (!$result) {
                return null;
            }

            // Cross-reference dengan database lokal untuk akurasi lebih baik
            $localData = $this->nutrisiService->getFromNamMenu($result['nama']);

            if ($localData) {
                Log::info("NutritionScanner: [{$result['nama']}] diperkaya dengan data lokal.");
                return [
                    'nama'    => $result['nama'],
                    'kalori'  => $localData['kalori'],
                    'protein' => $localData['protein'],
                    'lemak'   => $localData['lemak'],
                    'karbo'   => $localData['karbo'] ?? 0,
                ];
            }

            // Gunakan estimasi dari Gemini jika tidak ada di database lokal
            return $result;

        } catch (\Exception $e) {
            Log::error('NutritionScanner Error: ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Kirim gambar ke Gemini Vision API untuk identifikasi makanan + nutrisi.
     */
    private function analyzeWithGeminiVision(string $apiKey, string $base64Image, string $mimeType): ?array
    {
        $prompt = <<<PROMPT
Kamu adalah ahli gizi Indonesia. Lihat foto makanan ini dan identifikasi:

1. Nama makanan dalam Bahasa Indonesia (gunakan nama yang umum di Indonesia)
2. Estimasi kandungan nutrisi per porsi

Jawab HANYA dalam format JSON berikut (tanpa markdown, tanpa penjelasan tambahan):
{"nama": "Nasi Ayam Goreng", "kalori": 420, "protein": 35, "lemak": 12, "karbo": 40}

Aturan:
- Nama makanan harus dalam Bahasa Indonesia yang umum
- kalori dalam kcal (bilangan bulat)
- protein, lemak, karbo dalam gram (bilangan bulat)
- Estimasi untuk 1 porsi standar warung/kantin Indonesia
- Jika tidak yakin makanan apa, tetap berikan estimasi terbaik
PROMPT;

        try {
            $response = Http::timeout(30)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'inlineData' => [
                                        'mimeType' => $mimeType,
                                        'data'     => $base64Image,
                                    ],
                                ],
                                [
                                    'text' => $prompt,
                                ],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature'     => 0.2,
                        'topP'            => 0.8,
                        'maxOutputTokens' => 2048,
                    ],
                ]
            );

            if ($response->failed()) {
                Log::error('NutritionScanner: Gemini Vision API gagal.', [
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }

            $text = $response->json('candidates.0.content.parts.0.text')
                ?? $response->json('candidates.0.content.0.text');

            if (!$text) {
                $content = $response->json('candidates.0.content');
                if (is_string($content)) {
                    $text = $content;
                } elseif (is_array($content)) {
                    $possibleText = null;
                    foreach ($content as $item) {
                        if (is_string($item)) {
                            $possibleText = $item;
                            break;
                        }
                        if (is_array($item) && isset($item['text']) && is_string($item['text'])) {
                            $possibleText = $item['text'];
                            break;
                        }
                        if (is_array($item) && isset($item['content']) && is_string($item['content'])) {
                            $possibleText = $item['content'];
                            break;
                        }
                    }
                    $text = $possibleText;
                }
            }

            if (!$text || !is_string($text)) {
                Log::warning('NutritionScanner: Gemini Vision tidak mengembalikan teks.', [
                    'response' => $response->json(),
                ]);
                return null;
            }

            // Bersihkan response dari markdown jika ada
            $text = preg_replace('/```(?:json)?/i', '', $text);
            $text = trim($text, " \t\n\r`");

            // Extract JSON object if the model includes explanatory text before/after JSON
            if (str_contains($text, '{') && str_contains($text, '}')) {
                $matches = [];
                preg_match('/\{.*\}/s', $text, $matches);
                if (!empty($matches[0])) {
                    $text = $matches[0];
                }
            }

            $data = json_decode($text, true);

            if (
                is_array($data) &&
                isset($data['nama'], $data['kalori'], $data['protein'], $data['lemak']) &&
                is_numeric($data['kalori']) &&
                is_numeric($data['protein']) &&
                is_numeric($data['lemak'])
            ) {
                Log::info("NutritionScanner: Gemini Vision berhasil mendeteksi [{$data['nama']}].");
                return [
                    'nama'    => $data['nama'],
                    'kalori'  => (int) $data['kalori'],
                    'protein' => (int) $data['protein'],
                    'lemak'   => (int) $data['lemak'],
                    'karbo'   => (int) ($data['karbo'] ?? 0),
                ];
            }

            Log::warning('NutritionScanner: Format JSON tidak valid dari Gemini Vision.', ['text' => $text]);
            return null;

        } catch (\Throwable $e) {
            Log::error('NutritionScanner: Gemini Vision Exception - ' . $e->getMessage());
            return null;
        }
    }

    /**
     * Deteksi MIME type dari file gambar.
     */
    private function detectMimeType(string $path): string
    {
        $extension = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return match ($extension) {
            'png'  => 'image/png',
            'gif'  => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/jpeg',
        };
    }
}
