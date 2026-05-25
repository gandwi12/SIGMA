<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatHistory;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class ChatbotController extends Controller
{
    public function index()
    {
        $histories = ChatHistory::where('created_at', '>=', Carbon::now()->subMinutes(5))
            ->latest()
            ->take(10)
            ->get()
            ->reverse();

        return view('pages.asisten-gizi', compact('histories'));
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $userMessage = trim($request->message);
        $message = strtolower($userMessage);

        $budget = $this->detectBudget($message);
        $menus = $this->getRecommendedMenus($message, $budget);

        $menusData = $menus->map(function ($menu) {
            return [
                'nama' => $menu->nama,
                'harga' => $menu->harga,
                'tag' => $menu->tag ?? 'Menu SIGMA',
                'kalori' => $menu->kalori ?? 0,
                'protein' => $menu->protein ?? 0,
                'lemak' => $menu->lemak ?? 0,
                'umkm' => $menu->umkm->nama_usaha ?? 'UMKM SIGMA',
            ];
        })->values()->toJson(JSON_PRETTY_PRINT);

        $prompt = "
Kamu adalah Asisten Gizi SIGMA.

Gaya jawab:
- Bahasa Indonesia santai seperti teman kampus.
- Jawaban maksimal 3 kalimat.
- Jangan pakai markdown tabel.
- Kalau ada DATA MENU SIGMA, jawab sesuai menu itu saja.
- Jangan mengarang nama menu yang tidak ada di data.
- Kalau data menu kosong, jawab santai sesuai pertanyaan user dan arahkan user menyebut budget/menu.

Pertanyaan user:
{$userMessage}

DATA MENU SIGMA yang akan tampil sebagai card:
{$menusData}
";

        $reply = $this->askGemini($prompt);

        if (!$reply) {
            $reply = $this->fallbackReply($message, $budget, $menus->count());
        }

        ChatHistory::create([
            'user_message' => $userMessage,
            'bot_reply' => $reply,
        ]);

        return response()->json([
            'reply' => $reply,
            'menus' => $menus->map(function ($menu) {
                return [
                    'nama' => $menu->nama,
                    'harga' => 'Rp' . number_format($menu->harga, 0, ',', '.'),
                    'tag' => $menu->tag ?? 'Menu SIGMA',
                    'kalori' => $menu->kalori ?? 0,
                    'protein' => $menu->protein ?? 0,
                    'lemak' => $menu->lemak ?? 0,
                    'image_url' => $menu->image_url,
                    'url' => route('menu.show', $menu->id),
                ];
            })->values(),
        ]);
    }

    private function getRecommendedMenus(string $message, ?int $budget)
    {
        $baseQuery = Menu::with('umkm')
            ->where(function ($q) {
                $q->where('status', 'Aktif')
                  ->orWhere('status', 'aktif');
            });

        if ($budget) {
            $baseQuery->where('harga', '<=', $budget);
        }

        $excludeWords = $this->detectExcludeWords($message);

        foreach ($excludeWords as $word) {
            $baseQuery->where('nama', 'not like', "%{$word}%")
                ->where('deskripsi', 'not like', "%{$word}%")
                ->where('tag', 'not like', "%{$word}%");
        }

        $keywords = $this->extractMenuKeywords($message);

        if ($keywords->count() > 0) {
            $baseQuery->where(function ($q) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $q->orWhere('nama', 'like', "%{$keyword}%")
                      ->orWhere('deskripsi', 'like', "%{$keyword}%")
                      ->orWhere('tag', 'like', "%{$keyword}%");
                }
            });

            if ($this->isSingleCheapestIntent($message)) {
                return $baseQuery->orderBy('harga', 'asc')->take(1)->get();
            }

            if ($this->containsAny($message, ['protein', 'gym', 'otot', 'workout', 'bulking'])) {
                return $baseQuery->orderByDesc('protein')->take(3)->get();
            }

            if ($this->containsAny($message, ['diet', 'kalori', 'rendah kalori', 'sehat', 'lemak'])) {
                return $baseQuery->orderBy('kalori', 'asc')->take(3)->get();
            }

            return $baseQuery->orderBy('harga', 'asc')->take(3)->get();
        }

        if ($this->isSingleCheapestIntent($message)) {
            return $baseQuery->orderBy('harga', 'asc')->take(1)->get();
        }

        if ($this->containsAny($message, ['murah', 'hemat', 'irit', 'bokek', 'duit tipis', 'uang tipis'])) {
            return $baseQuery->orderBy('harga', 'asc')->take(3)->get();
        }

        if ($this->containsAny($message, ['protein', 'gym', 'otot', 'workout', 'bulking'])) {
            return $baseQuery->orderByDesc('protein')->take(3)->get();
        }

        if ($this->containsAny($message, ['diet', 'kalori', 'rendah kalori', 'sehat', 'lemak'])) {
            return $baseQuery->orderBy('kalori', 'asc')->take(3)->get();
        }

        if ($budget || $this->containsAny($message, ['makan', 'menu', 'rekomendasi', 'laper', 'lapar', 'jajan', 'sarapan', 'siang', 'malam'])) {
            return $baseQuery->orderBy('harga', 'asc')->take(3)->get();
        }

        return collect();
    }

    private function extractMenuKeywords(string $message)
    {
        $stopWords = [
            'gw', 'gue', 'gua', 'aku', 'saya', 'ane', 'lu', 'lo', 'kamu',
            'mau', 'pengen', 'ingin', 'butuh', 'cari', 'carikan', 'cariin',
            'yg', 'yang', 'menu', 'makanan', 'makan', 'rekomendasi',
            'rekomendasiin', 'saran', 'pilihin', 'pilihkan',
            'murah', 'hemat', 'irit', 'paling', 'termurah', 'terhemat',
            'budget', 'uang', 'duit', 'harga', 'rb', 'ribu', 'k',
            'ada', 'apa', 'aja', 'dong', 'nih', 'lah', 'sih', 'buat',
            'dengan', 'dan', 'atau', 'di', 'ke', 'dari', 'untuk',
            'ga', 'gak', 'nggak', 'tidak', 'jangan', 'selain', 'bukan',
            'bisa', 'boleh', 'kasih', 'coba', 'tolong',
            'protein', 'kalori', 'diet', 'sehat', 'gizi', 'nutrisi',
            'laper', 'lapar', 'kenyang', 'sarapan', 'siang', 'malam',
            'pedas', 'pedes', 'manis', 'asin', 'hangat',
        ];

        $words = preg_split('/\s+/', strtolower($message));

        return collect($words)
            ->map(function ($word) {
                return preg_replace('/[^a-z0-9]/', '', $word);
            })
            ->filter(function ($word) {
                return strlen($word) >= 3;
            })
            ->reject(function ($word) use ($stopWords) {
                return in_array($word, $stopWords);
            })
            ->reject(function ($word) {
                return is_numeric($word);
            })
            ->values();
    }

    private function detectExcludeWords(string $message): array
    {
        $excludes = [];

        $patterns = [
            '/(?:g mau|ga mau|gak mau|nggak mau|tidak mau|jangan|selain|bukan)\s+([a-zA-Z0-9]+)/',
        ];

        foreach ($patterns as $pattern) {
            if (preg_match_all($pattern, $message, $matches)) {
                foreach ($matches[1] as $word) {
                    $word = preg_replace('/[^a-z0-9]/', '', strtolower($word));

                    if (strlen($word) >= 3) {
                        $excludes[] = $word;
                    }
                }
            }
        }

        return array_values(array_unique($excludes));
    }

    private function isSingleCheapestIntent(string $message): bool
    {
        return $this->containsAny($message, [
            'paling murah',
            'termurah',
            'paling hemat',
            'terhemat',
            'yang paling murah',
            'yg paling murah',
            'yang paling hemat',
            'yg paling hemat',
        ]);
    }

    private function detectBudget(string $message): ?int
    {
        if (preg_match('/(\d+)\s*(ribu|rb|k)/i', $message, $match)) {
            return (int) $match[1] * 1000;
        }

        if (preg_match('/(\d{4,6})/', $message, $match)) {
            return (int) $match[1];
        }

        return null;
    }

    private function askGemini(string $prompt): ?string
    {
        $apiKey = env('GEMINI_API_KEY');

        if (!$apiKey) {
            return null;
        }

        try {
            $response = Http::timeout(30)->post(
                "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash:generateContent?key={$apiKey}",
                [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.8,
                        'topP' => 0.9,
                        'maxOutputTokens' => 250,
                    ],
                ]
            );

            if ($response->failed()) {
                return null;
            }

            return $response->json('candidates.0.content.parts.0.text');
        } catch (\Throwable $e) {
            return null;
        }
    }

    private function fallbackReply(string $message, ?int $budget, int $menuCount): string
    {
        if ($menuCount === 0) {
            return 'Belum ada menu yang cocok dengan kata yang kamu sebut. Coba pakai nama menu lain atau sebut budget kamu.';
        }

        if ($this->isSingleCheapestIntent($message)) {
            return 'Ini satu menu yang paling hemat dari daftar SIGMA.';
        }

        if ($budget) {
            return 'Aku carikan menu yang masih masuk budget Rp' . number_format($budget, 0, ',', '.') . '.';
        }

        return 'Ini rekomendasi menu yang cocok dari SIGMA.';
    }

    private function containsAny(string $message, array $keywords): bool
    {
        foreach ($keywords as $keyword) {
            if (str_contains($message, strtolower($keyword))) {
                return true;
            }
        }

        return false;
    }
}