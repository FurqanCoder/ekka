<div>


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
                Powered by AI • Your Store
            </div>
       

    <script>
        // Toggle chat popup
        function toggleChat() {
            const popup = document.getElementById('chatPopup');
            const btn = document.getElementById('chatToggleBtn');
            const icon = document.getElementById('chatIcon');
            
            popup.classList.toggle('active');
            btn.classList.toggle('active');
            
            if (popup.classList.contains('active')) {
                icon.textContent = '✕';
                // Focus input when opening
                setTimeout(() => {
                    const input = document.querySelector('.chat-input');
                    if (input) input.focus();
                }, 300);
            } else {
                icon.textContent = '💬';
            }
        }

        // Close on escape key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const popup = document.getElementById('chatPopup');
                if (popup.classList.contains('active')) {
                    toggleChat();
                }
            }
        });

        document.addEventListener('livewire:initialized', () => {
            const messagesContainer = document.getElementById('chatMessages');

            function scrollToBottom() {
                if (messagesContainer) {
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                }
            }

            // Initial scroll
            scrollToBottom();

            // Scroll after updates
            @this.on('chatUpdated', () => {
                setTimeout(scrollToBottom, 100);
            });

            // Focus input and scroll after message
            Livewire.hook('message.processed', (message, component) => {
                if (component.name === 'web.chat.ai-chatbot') {
                    setTimeout(() => {
                        const input = document.querySelector('.chat-input');
                        if (input && !input.disabled) {
                            input.focus();
                        }
                        scrollToBottom();
                    }, 100);
                }
            });
        });
    </script>
</div>