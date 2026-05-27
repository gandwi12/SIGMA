<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Service untuk mengambil data nutrisi makanan secara otomatis.
 *
 * Alur prioritas:
 * 1. Cocokkan nama menu dengan database lokal makanan Indonesia
 * 2. Jika tidak cocok & GEMINI_API_KEY ada → tanya Gemini AI
 * 3. Jika keduanya gagal → return null (nutrisi tetap 0)
 */
class NutrisiService
{
    /**
     * Database nutrisi lokal makanan Indonesia per porsi (kcal, gram).
     * Sumber: nilaigizi.com, halodoc.com, hellosehat.com
     * Format: 'keyword' => ['kalori', 'protein', 'lemak']
     */
    private array $localDb = [
        // === NASI ===
        'nasi putih'         => ['kalori' => 270, 'protein' => 5,  'lemak' => 1],
        'nasi goreng'        => ['kalori' => 500, 'protein' => 7,  'lemak' => 34],
        'nasi goreng ayam'   => ['kalori' => 520, 'protein' => 20, 'lemak' => 18],
        'nasi goreng spesial'=> ['kalori' => 560, 'protein' => 18, 'lemak' => 22],
        'nasi uduk'          => ['kalori' => 390, 'protein' => 8,  'lemak' => 16],
        'nasi kuning'        => ['kalori' => 380, 'protein' => 7,  'lemak' => 14],
        'nasi padang'        => ['kalori' => 600, 'protein' => 28, 'lemak' => 24],
        'nasi bakar'         => ['kalori' => 420, 'protein' => 10, 'lemak' => 12],
        'nasi tim'           => ['kalori' => 250, 'protein' => 6,  'lemak' => 4],
        'nasi pecel'         => ['kalori' => 380, 'protein' => 12, 'lemak' => 16],
        'nasi campur'        => ['kalori' => 550, 'protein' => 22, 'lemak' => 18],

        // === AYAM ===
        'ayam goreng'        => ['kalori' => 400, 'protein' => 30, 'lemak' => 22],
        'ayam bakar'         => ['kalori' => 320, 'protein' => 34, 'lemak' => 12],
        'ayam geprek'        => ['kalori' => 480, 'protein' => 32, 'lemak' => 26],
        'ayam penyet'        => ['kalori' => 460, 'protein' => 30, 'lemak' => 24],
        'ayam panggang'      => ['kalori' => 300, 'protein' => 36, 'lemak' => 10],
        'nasi ayam'          => ['kalori' => 420, 'protein' => 35, 'lemak' => 9],
        'nasi ayam goreng'   => ['kalori' => 540, 'protein' => 30, 'lemak' => 22],
        'nasi ayam bakar'    => ['kalori' => 460, 'protein' => 36, 'lemak' => 11],
        'nasi ayam geprek'   => ['kalori' => 580, 'protein' => 32, 'lemak' => 24],
        'nasi ayam sehat'    => ['kalori' => 420, 'protein' => 35, 'lemak' => 9],

        // === SATE ===
        'sate ayam'          => ['kalori' => 360, 'protein' => 30, 'lemak' => 16],
        'sate kambing'       => ['kalori' => 420, 'protein' => 36, 'lemak' => 22],
        'sate sapi'          => ['kalori' => 400, 'protein' => 38, 'lemak' => 18],
        'sate maranggi'      => ['kalori' => 480, 'protein' => 42, 'lemak' => 22],
        'sate padang'        => ['kalori' => 450, 'protein' => 34, 'lemak' => 20],
        'sate lilit'         => ['kalori' => 380, 'protein' => 28, 'lemak' => 18],

        // === BAKSO & MIE ===
        'bakso'              => ['kalori' => 350, 'protein' => 20, 'lemak' => 12],
        'bakso malang'       => ['kalori' => 380, 'protein' => 22, 'lemak' => 14],
        'bakso sapi'         => ['kalori' => 360, 'protein' => 24, 'lemak' => 12],
        'mie ayam'           => ['kalori' => 420, 'protein' => 18, 'lemak' => 14],
        'mie goreng'         => ['kalori' => 480, 'protein' => 14, 'lemak' => 20],
        'mie rebus'          => ['kalori' => 350, 'protein' => 12, 'lemak' => 10],
        'bakmi goreng'       => ['kalori' => 480, 'protein' => 16, 'lemak' => 18],

        // === SOTO & SOUP ===
        'soto ayam'          => ['kalori' => 220, 'protein' => 18, 'lemak' => 10],
        'soto betawi'        => ['kalori' => 380, 'protein' => 22, 'lemak' => 22],
        'soto lamongan'      => ['kalori' => 260, 'protein' => 20, 'lemak' => 12],
        'rawon'              => ['kalori' => 340, 'protein' => 24, 'lemak' => 16],
        'opor ayam'          => ['kalori' => 380, 'protein' => 26, 'lemak' => 24],
        'sup ayam'           => ['kalori' => 180, 'protein' => 16, 'lemak' => 8],

        // === SAYURAN & VEGETARIAN ===
        'gado gado'          => ['kalori' => 310, 'protein' => 13, 'lemak' => 17],
        'gado-gado'          => ['kalori' => 310, 'protein' => 13, 'lemak' => 17],
        'pecel'              => ['kalori' => 290, 'protein' => 11, 'lemak' => 14],
        'ketoprak'           => ['kalori' => 300, 'protein' => 12, 'lemak' => 12],
        'lotek'              => ['kalori' => 280, 'protein' => 10, 'lemak' => 14],
        'tumis kangkung'     => ['kalori' => 90,  'protein' => 4,  'lemak' => 5],
        'cap cay'            => ['kalori' => 150, 'protein' => 8,  'lemak' => 8],

        // === SEAFOOD ===
        'ikan goreng'        => ['kalori' => 340, 'protein' => 28, 'lemak' => 18],
        'ikan bakar'         => ['kalori' => 260, 'protein' => 32, 'lemak' => 10],
        'udang goreng'       => ['kalori' => 280, 'protein' => 24, 'lemak' => 14],
        'lele goreng'        => ['kalori' => 320, 'protein' => 26, 'lemak' => 16],
        'nila goreng'        => ['kalori' => 300, 'protein' => 28, 'lemak' => 14],

        // === TAHU TEMPE ===
        'tempe goreng'       => ['kalori' => 200, 'protein' => 14, 'lemak' => 12],
        'tahu goreng'        => ['kalori' => 160, 'protein' => 10, 'lemak' => 10],
        'tahu tempe'         => ['kalori' => 300, 'protein' => 22, 'lemak' => 18],

        // === DAGING ===
        'rendang'            => ['kalori' => 480, 'protein' => 36, 'lemak' => 28],
        'semur daging'       => ['kalori' => 380, 'protein' => 28, 'lemak' => 20],
        'gulai'              => ['kalori' => 420, 'protein' => 26, 'lemak' => 26],
        'empal'              => ['kalori' => 360, 'protein' => 28, 'lemak' => 20],

        // === JAJANAN & SNACK ===
        'martabak'           => ['kalori' => 480, 'protein' => 12, 'lemak' => 22],
        'martabak telur'     => ['kalori' => 450, 'protein' => 18, 'lemak' => 24],
        'siomay'             => ['kalori' => 280, 'protein' => 14, 'lemak' => 12],
        'batagor'            => ['kalori' => 320, 'protein' => 14, 'lemak' => 18],
        'pempek'             => ['kalori' => 300, 'protein' => 14, 'lemak' => 10],

        // === MINUMAN ===
        'es teh'             => ['kalori' => 60,  'protein' => 0,  'lemak' => 0],
        'es jeruk'           => ['kalori' => 80,  'protein' => 0,  'lemak' => 0],
        'jus alpukat'        => ['kalori' => 220, 'protein' => 2,  'lemak' => 14],
    ];

    /**
     * Ambil data nutrisi (kalori, protein, lemak) berdasarkan nama menu.
     * Return array ['kalori' => int, 'protein' => int, 'lemak' => int]
     * atau null jika gagal.
     */
    public function getFromNamMenu(string $namMenu): ?array
    {
        // Langkah 1: Cari di database lokal dulu (lebih cepat & pasti valid)
        $lokal = $this->cariDiLokalDb($namMenu);
        if ($lokal) {
            Log::info("NutrisiService: [{$namMenu}] ditemukan di lokal DB.");
            return $lokal;
        }

        // Langkah 2: Fallback ke Gemini AI
        return $this->tanyaGemini($namMenu);
    }

    /**
     * Cari di database lokal dengan keyword matching (fuzzy).
     */
    private function cariDiLokalDb(string $namMenu): ?array
    {
        $namLower = strtolower(trim($namMenu));

        // Exact match dulu
        if (isset($this->localDb[$namLower])) {
            return $this->localDb[$namLower];
        }

        // Partial match: nama menu mengandung keyword dari DB
        foreach ($this->localDb as $keyword => $nutrisi) {
            if (str_contains($namLower, $keyword)) {
                return $nutrisi;
            }
        }

        // Partial match sebaliknya: keyword dari DB ada dalam nama menu
        $namaWords = explode(' ', $namLower);
        foreach ($this->localDb as $keyword => $nutrisi) {
            $keywordWords = explode(' ', $keyword);
            $matches = 0;
            foreach ($keywordWords as $kw) {
                if (in_array($kw, $namaWords)) {
                    $matches++;
                }
            }
            // Jika lebih dari separuh kata keyword cocok
            if ($matches > 0 && $matches >= ceil(count($keywordWords) / 2)) {
                return $nutrisi;
            }
        }

        return null;
    }

    /**
     * Tanya Gemini AI jika tidak ada di lokal DB.
     */
    private function tanyaGemini(string $namMenu): ?array
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return null;
        }

        $prompt = "Kamu adalah ahli gizi. Berikan estimasi kandungan nutrisi untuk 1 porsi makanan Indonesia berikut:

Nama makanan: \"{$namMenu}\"

Jawab HANYA dalam format JSON seperti ini (tanpa penjelasan tambahan apapun):
{\"kalori\": 420, \"protein\": 35, \"lemak\": 9}

Catatan:
- kalori dalam satuan kcal (bilangan bulat)
- protein dalam gram (bilangan bulat)
- lemak dalam gram (bilangan bulat)
- Estimasi untuk 1 porsi standar yang biasa dijual di warung/kantin Indonesia";

        try {
            $response = Http::timeout(20)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
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
                Log::error('NutrisiService: Gemini API gagal.', ['status' => $response->status(), 'body' => $response->body()]);
                return null;
            }

            $text = $response->json('candidates.0.content.parts.0.text')
                ?? $response->json('candidates.0.content.0.text');

            if (!$text) {
                $content = $response->json('candidates.0.content');
                if (is_string($content)) {
                    $text = $content;
                } elseif (is_array($content)) {
                    foreach ($content as $item) {
                        if (is_string($item)) {
                            $text = $item;
                            break;
                        }
                        if (is_array($item) && isset($item['text']) && is_string($item['text'])) {
                            $text = $item['text'];
                            break;
                        }
                    }
                }
            }

            if (!$text || !is_string($text)) {
                Log::warning('NutrisiService: Gemini Vision tidak mengembalikan teks.', ['response' => $response->json()]);
                return null;
            }

            // Bersihkan markdown jika ada
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
                isset($data['kalori'], $data['protein'], $data['lemak']) &&
                is_numeric($data['kalori']) &&
                is_numeric($data['protein']) &&
                is_numeric($data['lemak'])
            ) {
                Log::info("NutrisiService: [{$namMenu}] diambil dari Gemini AI.");
                return [
                    'kalori'  => (int) $data['kalori'],
                    'protein' => (int) $data['protein'],
                    'lemak'   => (int) $data['lemak'],
                ];
            }

            Log::warning('NutrisiService: Format JSON tidak valid dari Gemini.', ['text' => $text]);
            return null;

        } catch (\Throwable $e) {
            Log::error('NutrisiService: Exception - ' . $e->getMessage());
            return null;
        }
    }
}
