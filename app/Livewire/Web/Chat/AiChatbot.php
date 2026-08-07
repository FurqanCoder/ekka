<?php

namespace App\Livewire\Web\Chat;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use LucianoTonet\GroqLaravel\Facades\Groq;
use App\Models\Product;

class AiChatbot extends Component
{
    public $message = '';
    public $messages = [];
    public $isLoading = false;

    // → GREETING & SMALL TALK PHRASES
    protected $smallTalkTriggers = [
        'hello', 'hi', 'hey', 'salam', 'assalamualaikum',
        'how are you', 'thanks', 'thank you', 'who are you',
        'good morning', 'good evening', 'help',
    ];

    protected $smallTalkResponses = [
        'hello' => "Hello 👋 How can I assist you today?",
        'hi' => "Hi there! 😊 What would you like to explore?",
        'hey' => "Hey! 👀 Looking for something?",
        'salam' => "Wa Alaikum Assalam! How can I help?",
        'assalamualaikum' => "Wa Alaikum Assalam! 😊",
        'how are you' => "I'm doing great! Ready to help you shop 🙂",
        'thanks' => "You're welcome! 😊",
        'thank you' => "Happy to help! 💛",
        'who are you' => "I'm your AI shopping assistant 🤖 I can help you explore products.",
        'good morning' => "Good Morning! 🌞 How can I assist?",
        'good evening' => "Good Evening! 😊 What are you searching for?",
        'help' => "Sure! You can ask things like:\n• Show available products\n• Cheapest item?\n• Items under PKR 2000\n• Show products by category\n• Search by brand",
    ];

    public function mount()
    {
        if (empty($this->messages)) {
            $this->messages[] = [
                'sender' => 'ai',
                'text' => "Hello 👋 I'm your shopping assistant.\nHow can I help you today?",
            ];
        }
    }

    public function sendMessage()
    {
        set_time_limit(90);

        if (!trim($this->message)) {
            return;
        }

        $originalMessage = trim($this->message);
        $userMessageLower = strtolower($originalMessage);

        // Add user message (keep original casing for display)
        $this->messages[] = ['sender' => 'user', 'text' => $originalMessage];
        $this->message = '';
        $this->isLoading = true;

        // 1️⃣ SMALL TALK HANDLER — NO AI CALL NEEDED
        if ($this->isSmallTalk($userMessageLower)) {
            $this->handleSmallTalk($userMessageLower);
            return;
        }

        // 2️⃣ PRODUCT RELATED — CALL GROQ
        $this->handleProductQuery($userMessageLower);
    }

    public function clearChat()
    {
        $this->messages = [];

        $this->messages[] = [
            'sender' => 'ai',
            'text' => "🧹 Chat cleared! How can I help you today?",
        ];

        $this->dispatch('chatUpdated');
    }

    private function isSmallTalk($msg)
    {
        foreach ($this->smallTalkTriggers as $trigger) {
            if (str_contains($msg, $trigger)) {
                return true;
            }
        }
        return false;
    }

    private function handleSmallTalk($msg)
    {
        foreach ($this->smallTalkResponses as $key => $reply) {
            if (str_contains($msg, $key)) {
                $this->sendAIMessage($reply);
                return;
            }
        }

        // Default fallback
        $this->sendAIMessage("I'm here to help 😊 What would you like to see?");
    }

    private function handleProductQuery($userMessage)
    {
        try {
            $products = Product::with(['prices', 'brand', 'categories'])
                ->where('status', 'live')
                ->where('stock', '>', 0)
                ->limit(30)
                ->get();

            if ($products->isEmpty()) {
                $this->sendAIMessage("We currently have no products available.");
                return;
            }

            $productData = $products->map(function ($p) {
                return [
                    'id' => $p->id,
                    'name' => $p->name,
                    'price' => $this->extractPrice($p),
                    'brand' => $p->brand->name ?? null,
                    'category' => $p->categories->pluck('name')->implode(', '),
                ];
            })->toArray();

            $systemPrompt = "You are a professional e-commerce AI assistant.
Use ONLY the provided product data.
If the user asks general questions (not product related), reply politely.
If user asks for product-related info, filter correctly.
Do NOT invent products.

PRODUCT DATABASE:
" . json_encode($productData);

            $response = Groq::chat()->completions()->create([
                'model' => 'llama-3.1-8b-instant',
                'messages' => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user', 'content' => $userMessage],
                ],
                'temperature' => 0.2,
            ]);

            $reply = $response['choices'][0]['message']['content'] ?? null;

            if (!$reply) {
                throw new \Exception('Empty response from AI provider.');
            }

            $this->sendAIMessage($reply);

        } catch (\Exception $e) {
            Log::error('AI Chat Error: ' . $e->getMessage());
            $this->sendAIMessage("Sorry, something went wrong. Please try again.");
        }
    }

    /**
     * Safely pull a price whether `prices` is a hasOne relation (single model)
     * or a hasMany relation (collection).
     */
    private function extractPrice($product)
    {
        $prices = $product->prices;

        if (!$prices) {
            return null;
        }

        if ($prices instanceof \Illuminate\Support\Collection) {
            return optional($prices->first())->final_price;
        }

        return $prices->final_price ?? null;
    }

    private function sendAIMessage($text)
    {
        $this->messages[] = ['sender' => 'ai', 'text' => $text];
        $this->isLoading = false;
        $this->dispatch('chatUpdated');
    }

    public function render()
    {
        return view('livewire.web.chat.ai-chatbot');
    }
}