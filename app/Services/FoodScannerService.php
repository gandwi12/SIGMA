<?php

namespace App\Services;

class FoodScannerService
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function scanFood($imagePath)
    {
        $mimeType = mime_content_type($imagePath);
        $base64Image = base64_encode(file_get_contents($imagePath));

        $prompt = "
Kamu adalah pakar nutrisi AI. Analisis gambar makanan ini.
Identifikasi nama makanan, perkirakan jumlah kalori, dan berikan deskripsi singkat.
Sertakan juga tingkat keyakinanmu (confidence level) dalam persentase.

Format jawabanmu WAJIB menggunakan JSON dengan struktur berikut:
{
  \"food_name\": \"Nama makanan\",
  \"estimated_calories\": \"Estimasi kalori (misal: 300 kcal)\",
  \"confidence\": \"Tingkat keyakinan (misal: 85%)\",
  \"description\": \"Deskripsi singkat makanan tersebut\"
}
Pastikan tidak ada text tambahan selain JSON (tanpa markdown blok).
        ";

        try {
            $aiResponse = $this->geminiService->generateFromImage($prompt, $base64Image, $mimeType);
            
            // Clean markdown if AI accidentally adds it
            $aiResponse = str_replace(['```json', '```'], '', $aiResponse);
            $aiResponse = trim($aiResponse);
            
            $parsedResponse = json_decode($aiResponse, true);
            
            if (!$parsedResponse) {
                return [
                    'success' => false,
                    'message' => 'Gagal menganalisis gambar. Pastikan gambar jelas.',
                ];
            }

            return array_merge(['success' => true], $parsedResponse);
            
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Layanan scanner sedang dalam perbaikan: ' . $e->getMessage(),
            ];
        }
    }
}
