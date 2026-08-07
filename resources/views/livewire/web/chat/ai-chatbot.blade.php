<!-- resources/views/livewire/web/chat/ai-chatbot.blade.php -->
<div>
    <!-- Chat Toggle Button -->
    <button class="chat-toggle-btn" id="chatToggleBtn" onclick="toggleChat()" aria-label="Toggle Chat">
        <span id="chatIcon">💬</span>
    </button>

    <!-- Chat Popup -->
    <div class="chat-popup" id="chatPopup">
        <div class="chat-popup-inner">

            <!-- Header -->
            <div class="chat-popup-header">
                <div class="chat-header-info">
                    <div class="chat-avatar">🛍️</div>
                    <div class="chat-header-text">
                        <h4>Shopping Assistant</h4>
                        <p>Online • Ready to help</p>
                    </div>
                </div>
                <div class="chat-header-actions">
                    <button class="header-btn" wire:click="clearChat" title="Clear chat">
                        🔄
                    </button>
                    <button class="header-btn" onclick="toggleChat()" title="Close">
                        ✕
                    </button>
                </div>
            </div>

            <!-- Messages -->
            <div class="chat-messages" id="chatMessages">
                @foreach ($messages as $msg)
                    <div class="chat-message {{ $msg['sender'] }}">
                        <div class="message-content">
                            @if($msg['sender'] === 'ai')
                                {!! Str::markdown($msg['text']) !!}
                            @else
                                {{ $msg['text'] }}
                            @endif
                        </div>
                    </div>
                @endforeach

                @if ($isLoading)
                    <div class="chat-loading">
                        <div class="loading-bubble">
                            <span style="font-size: 12px; color: #718096;">Typing</span>
                            <div class="typing-dots">
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                                <div class="typing-dot"></div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Input -->
            <div class="chat-input-area">
                <form wire:submit.prevent="sendMessage" class="chat-input-form">
                    <input
                        type="text"
                        wire:model="message"
                        class="chat-input"
                        id="chatInput"
                        placeholder="Ask about products..."
                        {{ $isLoading ? 'disabled' : '' }}
                        autocomplete="off"
                    >
                    <button
                        type="submit"
                        class="chat-send-btn"
                        {{ $isLoading ? 'disabled' : '' }}
                    >
                        ➤
                    </button>
                </form>
            </div>

            <!-- Footer -->
            <div class="chat-footer">
                Powered by AI • CSB (Cloud Skin Beauty)
            </div>

        </div>
    </div>

    <!-- Styles -->
    <style>
        .chat-toggle-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            border: none;
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.4);
            cursor: pointer;
            z-index: 9997;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .chat-toggle-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 40px rgba(30, 64, 175, 0.5);
        }

        .chat-toggle-btn.active {
            background: #ef4444;
            box-shadow: 0 8px 30px rgba(239, 68, 68, 0.4);
            transform: rotate(90deg);
        }

        .chat-popup {
            position: fixed;
            bottom: 100px;
            right: 30px;
            width: 400px;
            max-width: calc(100vw - 40px);
            max-height: 600px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            z-index: 9998;
            overflow: hidden;
            visibility: hidden;
            opacity: 0;
            pointer-events: none;
            transform: scale(0.8) translateY(20px);
            transform-origin: bottom right;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            /* height: 100%; */
        }

        .chat-popup.active {
            visibility: visible;
            opacity: 1;
            pointer-events: auto;
            transform: scale(1) translateY(0);
        }

        .chat-popup-inner {
            display: flex;
            flex-direction: column;
            height: 600px;
            max-height: 70vh;
        }

        /* ===== HEADER ===== */
        .chat-popup-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            flex-shrink: 0;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .chat-header-text h4 {
            margin: 0;
            font-size: 16px;
            font-weight: 600;
        }

        .chat-header-text p {
            margin: 0;
            font-size: 12px;
            opacity: 0.9;
        }

        .chat-header-actions {
            display: flex;
            gap: 8px;
        }

        .header-btn {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.25);
            transform: scale(1.1);
        }

        /* ===== MESSAGES ===== */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 16px 20px;
            background: #f8fafc;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .chat-messages::-webkit-scrollbar {
            width: 4px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #94a3b8;
            border-radius: 4px;
        }

        .chat-message {
            display: flex;
            animation: slideIn 0.3s ease;
        }

        .chat-message.user {
            justify-content: flex-end;
        }

        .chat-message.ai {
            justify-content: flex-start;
        }

        @keyframes slideIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .message-content {
            max-width: 80%;
            padding: 10px 14px;
            border-radius: 12px;
            font-size: 14px;
            line-height: 1.6;
            word-wrap: break-word;
        }

        .chat-message.ai .message-content {
            background: white;
            color: #1e293b;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .chat-message.user .message-content {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .message-content p {
            margin: 0 0 6px 0;
        }

        .message-content p:last-child {
            margin-bottom: 0;
        }

        .message-content ul {
            margin: 6px 0;
            padding-left: 20px;
        }

        .chat-message.ai .message-content strong {
            color: #1e40af;
        }

        .chat-message.user .message-content strong {
            color: rgba(255, 255, 255, 0.9);
        }

        /* ===== TYPING INDICATOR ===== */
        .chat-loading {
            display: flex;
            justify-content: flex-start;
        }

        .loading-bubble {
            background: white;
            border-radius: 12px;
            border-bottom-left-radius: 4px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            padding: 10px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .typing-dots {
            display: flex;
            gap: 4px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #94a3b8;
            animation: typing 1.4s infinite both;
        }

        .typing-dot:nth-child(2) { animation-delay: 0.2s; }
        .typing-dot:nth-child(3) { animation-delay: 0.4s; }

        @keyframes typing {
            0%, 60%, 100% { transform: translateY(0); opacity: 0.4; }
            30% { transform: translateY(-6px); opacity: 1; }
        }

        /* ===== INPUT ===== */
        .chat-input-area {
            padding: 12px 16px;
            background: white;
            border-top: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .chat-input-form {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .chat-input {
            flex: 1;
            padding: 10px 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            outline: none;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .chat-input:focus {
            border-color: #1e40af;
            box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
            background: white;
        }

        .chat-input:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .chat-send-btn {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 16px;
        }

        .chat-send-btn:hover:not(:disabled) {
            transform: scale(1.05);
            box-shadow: 0 4px 15px rgba(30, 64, 175, 0.3);
        }

        .chat-send-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* ===== FOOTER ===== */
        .chat-footer {
            padding: 8px 16px;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-size: 11px;
            color: #94a3b8;
            flex-shrink: 0;
            bottom: 0;
        }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 640px) {
            .chat-popup {
                bottom: 80px;
                right: 10px;
                width: calc(100vw - 20px);
                height: calc(100vh - 100px);
                max-height: calc(100vh - 100px);
            }

            .chat-popup-inner {
                height: 100%;
                max-height: 100%;
            }

            .chat-toggle-btn {
                bottom: 20px;
                right: 20px;
                width: 50px;
                height: 50px;
                font-size: 20px;
            }

            .message-content {
                max-width: 85%;
            }
        }
    </style>

    <script>
        // Toggle chat popup
        function toggleChat() {
            const popup = document.getElementById('chatPopup');
            const btn = document.getElementById('chatToggleBtn');
            const icon = document.getElementById('chatIcon');
            if (!popup || !btn) return;

            const isOpening = !popup.classList.contains('active');
            popup.classList.toggle('active', isOpening);
            btn.classList.toggle('active', isOpening);
            if (icon) icon.textContent = isOpening ? '✕' : '💬';

            if (isOpening) {
                setTimeout(() => {
                    const input = document.getElementById('chatInput');
                    if (input) input.focus();
                }, 300);
            }
        }

        // Close on Escape key
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const popup = document.getElementById('chatPopup');
                if (popup && popup.classList.contains('active')) {
                    toggleChat();
                }
            }
        });

        // Close on outside click
        document.addEventListener('click', function (e) {
            const popup = document.getElementById('chatPopup');
            const btn = document.getElementById('chatToggleBtn');
            if (!popup || !btn) return;
            if (popup.classList.contains('active') && !popup.contains(e.target) && !btn.contains(e.target)) {
                toggleChat();
            }
        });

        // Auto-scroll to bottom + refocus input whenever the messages
        // container changes. Plain DOM observation — no dependency on
        // Livewire event names or init timing.
        (function () {
            const chatMessages = document.getElementById('chatMessages');
            const chatInput = document.getElementById('chatInput');

            function scrollToBottom() {
                if (chatMessages) {
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }
            }

            function focusInput() {
                if (chatInput && !chatInput.disabled) {
                    chatInput.focus();
                }
            }

            scrollToBottom();

            if (chatMessages) {
                const observer = new MutationObserver(function () {
                    scrollToBottom();
                    focusInput();
                });

                observer.observe(chatMessages, {
                    childList: true,
                    subtree: true,
                    characterData: true,
                });
            }
        })();
    </script>
</div>