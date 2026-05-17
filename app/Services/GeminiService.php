<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GeminiService
{
    protected $apiKey;
    protected $apiUrl;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key');
        $this->apiUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    }

    /**
     * Send a text prompt to Gemini.
     */
    public function generateText(string $prompt, string $model = null): string
    {
        if ($model === null) {
            $model = 'gemi' . 'ni-flash-latest';
        }

        if (empty($this->apiKey)) {
            throw new Exception('Gemini API key is not configured.');
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . $model . ':generateContent?key=' . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.7,
                    ]
                ]);

        if ($response->successful()) {
            return $response->json('candidates.0.content.parts.0.text') ?? '';
        }

        \Illuminate\Support\Facades\Log::error('Gemini Failure: ' . $response->status() . ' - ' . $response->body());
        $errorBody = $response->body();
        if (empty($errorBody)) {
            $errorBody = "Status Code: " . $response->status();
        }
        throw new Exception('Gemini API Error: ' . $errorBody);
    }

    /**
     * Send an image and text prompt to Gemini Vision.
     */
    public function generateFromImage(string $prompt, string $base64Image, string $mimeType, string $model = null): string
    {
        if ($model === null) {
            $model = 'gemi' . 'ni-flash-latest';
        }
        if (empty($this->apiKey)) {
            throw new Exception('Gemini API key is not configured.');
        }

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . $model . ':generateContent?key=' . $this->apiKey, [
                    'contents' => [
                        [
                            'parts' => [
                                ['text' => $prompt],
                                [
                                    'inline_data' => [
                                        'mime_type' => $mimeType,
                                        'data' => $base64Image
                                    ]
                                ]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.4,
                    ]
                ]);

        if ($response->successful()) {
            return $response->json('candidates.0.content.parts.0.text') ?? '';
        }

        \Illuminate\Support\Facades\Log::error('Gemini Failure (Image): ' . $response->status() . ' - ' . $response->body());
        $errorBody = $response->body();
        if (empty($errorBody)) {
            $errorBody = "Status Code: " . $response->status();
        }
        throw new Exception('Gemini API Error: ' . $errorBody);
    }
}
