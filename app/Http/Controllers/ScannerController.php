<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ScannerResult;

class ScannerController extends Controller
{
    public function index()
    {
        $results = ScannerResult::latest()->get();

        return view('pages.scanner-kalori', compact('results'));
    }

    /**
     * Untuk halaman scanner lama /scanner-kalori.
     */
    public function scan(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:5120',
        ]);

        $foto = $request->file('foto')->store('scanner', 'public');

        $data = $this->analyzeWithGemini(
            $request->file('foto')->getRealPath(),
            $request->file('foto')->getMimeType()
        );

        if (!$data['success']) {
            return back()->with('error', $data['message']);
        }

        ScannerResult::create([
            'foto' => $foto,
            'nama_makanan' => $data['food_name'],
            'estimasi_kalori' => $data['calories'] . ' kcal',
            'confidence' => $data['confidence'] . '%',
            'deskripsi' => $data['description'],
        ]);

        return back()->with([
            'success' => 'AI berhasil scan makanan.',
            'hasil_ai' => $data,
        ]);
    }

    /**
     * Untuk tombol Scanner AI di halaman tambah menu mitra.
     * Return JSON supaya bisa masuk otomatis ke input kalori/protein/lemak.
     */
    public function analyzeFood(Request $request)
    {
        $request->validate([
            'foto' => 'required|image|max:5120',
        ]);

        $data = $this->analyzeWithGemini(
            $request->file('foto')->getRealPath(),
            $request->file('foto')->getMimeType()
        );

        if (!$data['success']) {
            return response()->json([
                'food_name' => 'Gagal analisis AI',
                'calories' => 0,
                'protein' => 0,
                'fat' => 0,
                'confidence' => 0,
                'description' => $data['message'],
            ], 500);
        }

        return response()->json([
            'food_name' => $data['food_name'],
            'calories' => $data['calories'],
            'protein' => $data['protein'],
            'fat' => $data['fat'],
            'confidence' => $data['confidence'],
            'description' => $data['description'],
        ]);
    }

    private function analyzeWithGemini(string $imagePath, string $mimeType): array
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return [
                'success' => false,
                'message' => 'GEMINI_API_KEY belum dipasang di file .env.',
            ];
        }

        $image = base64_encode(file_get_contents($imagePath));

        $prompt = <<<PROMPT
Analisis foto makanan ini secara realistis.

Tugas:
1. Identifikasi nama makanan yang paling mungkin.
2. Estimasikan kalori, protein, dan lemak berdasarkan porsi yang terlihat.
3. Berikan confidence 0-100.
4. Jika gambar bukan makanan, confidence harus rendah dan nutrisi 0.

Jawab JSON valid saja tanpa markdown, tanpa teks tambahan.

Format wajib:
{
  "food_name": "nama makanan",
  "calories": 520,
  "protein": 28,
  "fat": 14,
  "confidence": 85,
  "description": "penjelasan singkat estimasi"
}
PROMPT;

        $response = Http::timeout(60)
            ->withHeaders([
                'Content-Type' => 'application/json',
            ])
            ->post(
                'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key=' . $apiKey,
                [
                    'contents' => [
                        [
                            'parts' => [
                                [
                                    'text' => $prompt,
                                ],
                                [
                                    'inline_data' => [
                                        'mime_type' => $mimeType,
                                        'data' => $image,
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.2,
                        'maxOutputTokens' => 512,
                    ],
                ]
            );

        if (!$response->successful()) {
            return [
                'success' => false,
                'message' => 'Gemini API error: ' . $response->body(),
            ];
        }

        $result = $response->json();

        $text = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';

        $clean = trim($text);
        $clean = str_replace('```json', '', $clean);
        $clean = str_replace('```', '', $clean);
        $clean = trim($clean);

        $json = json_decode($clean, true);

        if (!is_array($json)) {
            return [
                'success' => false,
                'message' => 'AI tidak mengembalikan JSON valid. Response: ' . $text,
            ];
        }

        return [
            'success' => true,
            'food_name' => $json['food_name'] ?? 'Makanan terdeteksi',
            'calories' => (int) ($json['calories'] ?? 0),
            'protein' => (int) ($json['protein'] ?? 0),
            'fat' => (int) ($json['fat'] ?? 0),
            'confidence' => (int) ($json['confidence'] ?? 0),
            'description' => $json['description'] ?? '-',
        ];
    }
}