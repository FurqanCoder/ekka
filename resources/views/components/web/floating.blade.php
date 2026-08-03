 <!-- Recent Purchase Popup  -->
 {{-- <div class="recent-purchase">
        <img src="web/images/product-image/1.jpg" alt="payment image">
        <div class="detail">
            <p>Someone in new just bought</p>
            <h6>stylish baby shoes</h6>
            <p>10 Minutes ago</p>
        </div>
        <a href="javascript:void(0)" class="icon-btn recent-close">×</a>
    </div> --}}
 <!-- Recent Purchase Popup end -->

 <!-- Cart Floating Button -->

 <!-- Cart Floating Button end -->
    <style>
        /* Chat Widget Styles */
        .chat-widget-wrapper {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        /* Floating Chat Button */
        .chat-toggle-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            z-index: 9999;
        }

        .chat-toggle-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 12px 32px rgba(102, 126, 234, 0.5);
        }

        .chat-toggle-btn.active {
            transform: rotate(90deg);
        }

        /* Notification Badge */
        .chat-badge {
            position: absolute;
            top: -4px;
            right: -4px;
            background: #ef4444;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            font-size: 11px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 2px solid white;
        }

        /* Chat Popup Window */
        .chat-popup {
            position: fixed;
            bottom: 100px;
            right: 24px;
            width: 380px;
            height: 500px;
            background: white;
            border-radius: 16px;
            box-shadow: 0 12px 48px rgba(0, 0, 0, 0.2);
            display: none;
            flex-direction: column;
            overflow: hidden;
            z-index: 9998;
            animation: slideUp 0.3s ease-out;
        }

        .chat-popup.active {
            display: flex;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px) scale(0.95);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        /* Chat Header */
        .chat-popup-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .chat-header-info {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .chat-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
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
            margin: 2px 0 0 0;
            font-size: 12px;
            opacity: 0.9;
        }

        .chat-header-actions {
            display: flex;
            gap: 8px;
        }

        .header-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
            font-size: 14px;
        }

        .header-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        /* Messages Area */
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8fafc;
            scroll-behavior: smooth;
        }

        .chat-messages::-webkit-scrollbar {
            width: 6px;
        }

        .chat-messages::-webkit-scrollbar-track {
            background: transparent;
        }

        .chat-messages::-webkit-scrollbar-thumb {
            background: #cbd5e0;
            border-radius: 3px;
        }

        /* Message Bubbles */
        .chat-message {
            display: flex;
            margin-bottom: 12px;
            animation: messageSlide 0.3s ease-out;
        }

        @keyframes messageSlide {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .chat-message.user {
            justify-content: flex-end;
        }

        .chat-message.ai {
            justify-content: flex-start;
        }

        .message-content {
            max-width: 75%;
            padding: 10px 14px;
            border-radius: 12px;
            line-height: 1.4;
            word-wrap: break-word;
            font-size: 14px;
        }

        .user .message-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-bottom-right-radius: 4px;
        }

        .ai .message-content {
            background: white;
            color: #2d3748;
            border: 1px solid #e2e8f0;
            border-bottom-left-radius: 4px;
        }

        /* Markdown in AI messages */
        .ai .message-content p {
            margin: 6px 0;
        }

        .ai .message-content p:first-child {
            margin-top: 0;
        }

        .ai .message-content p:last-child {
            margin-bottom: 0;
        }

        .ai .message-content strong {
            font-weight: 600;
            color: #1a202c;
        }

        .ai .message-content ul,
        .ai .message-content ol {
            margin: 8px 0;
            padding-left: 20px;
        }

        .ai .message-content li {
            margin: 4px 0;
        }

        /* Loading Indicator */
        .chat-loading {
            display: flex;
            justify-content: flex-start;
            margin-bottom: 12px;
        }

        .loading-bubble {
            background: white;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            border-radius: 12px;
            border-bottom-left-radius: 4px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .typing-dots {
            display: flex;
            gap: 3px;
        }

        .typing-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #667eea;
            animation: typingBounce 1.4s infinite;
        }

        .typing-dot:nth-child(2) {
            animation-delay: 0.2s;
        }

        .typing-dot:nth-child(3) {
            animation-delay: 0.4s;
        }

        @keyframes typingBounce {
            0%, 60%, 100% {
                transform: translateY(0);
            }
            30% {
                transform: translateY(-8px);
            }
        }

        /* Input Area */
        .chat-input-area {
            padding: 16px;
            background: white;
            border-top: 1px solid #e2e8f0;
        }

        .chat-input-form {
            display: flex;
            gap: 8px;
        }

        .chat-input {
            flex: 1;
            padding: 10px 14px;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            outline: none;
            font-size: 14px;
            transition: all 0.2s;
        }

        .chat-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .chat-input:disabled {
            background: #f7fafc;
            cursor: not-allowed;
        }

        .chat-send-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 40px;
            height: 40px;
            border: none;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            font-size: 18px;
        }

        .chat-send-btn:hover:not(:disabled) {
            transform: scale(1.1);
        }

        .chat-send-btn:disabled {
            background: #cbd5e0;
            cursor: not-allowed;
        }

        /* Powered By */
        .chat-footer {
            padding: 8px 16px;
            text-align: center;
            font-size: 11px;
            color: #a0aec0;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .chat-popup {
                bottom: 0;
                right: 0;
                left: 0;
                width: 100%;
                height: 100%;
                max-height: 100vh;
                border-radius: 0;
            }

            .chat-toggle-btn {
                bottom: 16px;
                right: 16px;
            }
        }
    </style>
 <!-- Whatsapp -->
 <div class="ec-style ec-right-bottom">
     <!-- Start Floating Panel Container -->
     <div class="chat-widget-wrapper">
         <!-- Floating Chat Button -->
         <button class="chat-toggle-btn" onclick="toggleChat()" id="chatToggleBtn">
             <span id="chatIcon">💬</span>
         </button>

         <!-- Chat Popup Window -->
         <div class="chat-popup" id="chatPopup">
             @livewire('web.chat.ai-chatbot')
         </div>
     </div>
     <!--/ End Floating Panel Container -->
     <!-- Start Right Floating Button-->
     <div class="ec-right-bottom">
         <div class="ec-box">
             <div class="ec-button rotateBackward">
                 <img class="whatsapp" src="web/images/common/whatsapp.png" alt="whatsapp icon">
             </div>
         </div>
     </div>
     <!--/ End Right Floating Button-->
 </div>
 <!-- Whatsapp end -->

 <!-- Feature tools -->

 <!-- Feature tools end -->
