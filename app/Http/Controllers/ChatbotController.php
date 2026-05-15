<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ChatbotService;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'session_id' => 'nullable|integer'
        ]);

        $response = $this->chatbotService->handleChat($request->message, $request->session_id);

        return response()->json($response);
    }

    public function getSessions()
    {
        $sessions = \App\Models\ChatSession::orderBy('updated_at', 'desc')->get();
        return response()->json($sessions);
    }

    public function getMessages($id)
    {
        $session = \App\Models\ChatSession::with(['messages'])->findOrFail($id);
        
        // Map food recommendations back to objects for the frontend
        $messages = $session->messages->map(function($msg) {
            if ($msg->role === 'ai' && !empty($msg->recommendations)) {
                $msg->recommendation_data = \App\Models\Food::whereIn('id', $msg->recommendations)->get();
            }
            return $msg;
        });

        return response()->json([
            'session' => $session,
            'messages' => $messages
        ]);
    }
}
