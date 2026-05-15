<?php

namespace App\Services;

use App\Models\Food;

class ChatbotService
{
    protected $geminiService;

    public function __construct(GeminiService $geminiService)
    {
        $this->geminiService = $geminiService;
    }

    public function handleChat(string $userMessage, ?int $sessionId = null)
    {
        // 1. Manage Session
        if ($sessionId) {
            $session = \App\Models\ChatSession::find($sessionId);
        } else {
            // Create new session with user message as initial title
            $session = \App\Models\ChatSession::create([
                'title' => substr($userMessage, 0, 30) . (strlen($userMessage) > 30 ? '...' : '')
            ]);
        }

        // 2. Save User Message
        $session->messages()->create([
            'role' => 'user',
            'content' => $userMessage
        ]);

        // 3. Get History for AI Context
        $history = $session->messages()
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get()
            ->reverse();

        $historyText = "";
        foreach ($history as $msg) {
            $role = $msg->role === 'user' ? 'Pelanggan' : 'Asisten (Kamu)';
            $historyText .= "{$role}: {$msg->content}\n";
        }

        // 4. Get available foods
        $foods = Food::all(['id', 'name', 'description', 'calories', 'taste_profile', 'category', 'price']);
        $foodContext = json_encode($foods->toArray());

        $prompt = "
Kamu adalah asisten AI chatbot ramah untuk sebuah website UMKM kuliner. 
Tugasmu adalah merekomendasikan makanan kepada pelanggan berdasarkan pertanyaan mereka.
PENTING: Kamu HANYA BOLEH merekomendasikan makanan yang ada di daftar berikut. 

Daftar Makanan (JSON):
{$foodContext}

Riwayat Chat Saat Ini:
{$historyText}

Berikan jawaban yang natural, singkat, dan relevan berdasarkan riwayat chat di atas. 
Format jawabanmu WAJIB menggunakan JSON dengan struktur berikut:
{
  \"reply\": \"Pesan natural untuk pelanggan\",
  \"recommendations\": [array berisi ID makanan yang direkomendasikan]
}
Pastikan tidak ada text tambahan selain JSON (tanpa markdown blok).
        ";

        try {
            $aiResponse = $this->geminiService->generateText($prompt);
            
            $aiResponse = str_replace(['```json', '```'], '', $aiResponse);
            $aiResponse = trim($aiResponse);
            
            $parsedResponse = json_decode($aiResponse, true);
            
            if (!$parsedResponse) {
                return [
                    'reply' => 'Maaf, saya sedang mengalami sedikit gangguan. Bisa diulangi pertanyaannya?',
                    'recommendations' => [],
                    'session_id' => $session->id
                ];
            }

            // 5. Save AI Response
            $recommendedIds = $parsedResponse['recommendations'] ?? [];
            $session->messages()->create([
                'role' => 'ai',
                'content' => $parsedResponse['reply'] ?? '',
                'recommendations' => $recommendedIds
            ]);

            $recommendedFoods = Food::whereIn('id', $recommendedIds)->get();

            return [
                'reply' => $parsedResponse['reply'] ?? 'Ini beberapa rekomendasi untuk Anda.',
                'recommendations' => $recommendedFoods,
                'session_id' => $session->id
            ];
            
        } catch (\Exception $e) {
            return [
                'reply' => 'Maaf, layanan chatbot kami sedang dalam perbaikan.',
                'recommendations' => [],
                'session_id' => $session->id,
                'error' => $e->getMessage()
            ];
        }
    }
}
