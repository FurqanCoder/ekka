<?php

namespace App\Http\Controllers;

use LucianoTonet\GroqLaravel\Facades\Groq;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function chat(Request $request)
    {
        // -----------------------------------------------------------
        // TEMPORARY GROQ CONNECTION TEST LOGIC
        // This uses the FASTEST model to confirm API key and connectivity.
        // -----------------------------------------------------------
        
        // This is a minimal, non-blocking check for connectivity
        // NO set_time_limit() is used here as the request should be instantaneous.

        try {
            // 1. Initialize Groq client
            $client = new Groq([
                'api_key' => env('GROQ_API_KEY'),
            ]);

            // 2. Use the fastest model and a simple prompt
            $response = $client->chat()->create([
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'user', 'content' => 'Say a short, cheerful greeting.'],
                ],
            ]);

            $reply = $response->choices[0]->message->content;

            // 3. Return success message
            return response()->json([
                'reply' => '✅ Groq Connection SUCCESSFUL! The model is working. Reply: ' . $reply
            ]);

        } catch (\Exception $e) {
            // 4. Log and return failure message
            \Log::error("Groq Test FAILED: " . $e->getMessage());

            return response()->json([
                'reply' => '❌ Groq Connection FAILED. Please check your GROQ_API_KEY in the .env file and ensure it is valid. Error: ' . $e->getMessage()
            ], 500);
        }
    }
}