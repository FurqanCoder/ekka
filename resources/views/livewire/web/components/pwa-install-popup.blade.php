<div x-data="pwaHandler()" x-init="initPWA()">
    <!-- Popup -->
    <div x-show="showPopup" x-cloak>
        <!-- Overlay -->
        <div class="pwa-overlay" @click="dismissPopup()"></div>
        
        <!-- Popup Content -->
        <div class="pwa-popup">
            <div class="pwa-popup-content">
                <!-- Close Button -->
                <button class="pwa-close" @click="dismissPopup()">×</button>
                
                <!-- Icon -->
                <div class="pwa-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#1e40af" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2v8M8 6l4-4 4 4"/>
                        <rect x="2" y="12" width="20" height="10" rx="2"/>
                        <path d="M6 16h12"/>
                    </svg>
                </div>
                
                <h3 class="pwa-title">📱 Install Cloud Skin Beauty</h3>
                
                <p class="pwa-description">
                    Get the best experience with our mobile app.
                    Fast, convenient, and always up to date.
                </p>
                
                <ul class="pwa-features">
                    <li>🚀 Fast Loading</li>
                    <li>📱 Mobile Optimized</li>
                    <li>⚡ Offline Support</li>
                    <li>💄 Beauty Tips</li>
                </ul>
                
                <!-- iOS Guide -->
                <div x-show="showIosGuide" x-cloak class="ios-guide">
                    <h4 style="margin: 0 0 10px; color: #1e40af;">📱 How to Install on iPhone</h4>
                    <ol style="text-align: left; color: #444; font-size: 14px; line-height: 2.2;">
                        <li>Tap the Share button <span style="background: #f3f4f6; padding: 2px 8px; border-radius: 4px;">⬆️</span></li>
                        <li>Scroll down and tap <strong>"Add to Home Screen"</strong></li>
                        <li>Tap <strong>"Add"</strong> in the top right</li>
                    </ol>
                    <button class="pwa-btn pwa-btn-success" @click="showIosGuide = false" style="margin-top: 10px;">
                        Got it! 👍
                    </button>
                </div>
                
                <!-- Buttons -->
                <div class="pwa-buttons" x-show="!showIosGuide">
                    <button class="pwa-btn pwa-btn-primary" @click="installApp()" x-show="!isInstalling">
                        📲 Install App
                    </button>
                    <button class="pwa-btn pwa-btn-primary" x-show="isInstalling" disabled>
                        <span class="spinner"></span> Installing...
                    </button>
                    
                    <button class="pwa-btn pwa-btn-secondary" @click="dismissPopup()">
                        Maybe Later
                    </button>
                </div>
            </div>
        </div>
    </div>

    <style>
        [x-cloak] { display: none !important; }
        
        .pwa-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(5px);
            z-index: 9998;
            animation: fadeIn 0.3s ease;
        }

        .pwa-popup {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 9999;
            width: 90%;
            max-width: 400px;
            animation: slideUp 0.4s ease;
        }

        .pwa-popup-content {
            background: white;
            border-radius: 20px;
            padding: 30px;
            text-align: center;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            position: relative;
        }

        .pwa-close {
            position: absolute;
            top: 12px;
            right: 16px;
            background: none;
            border: none;
            font-size: 28px;
            color: #999;
            cursor: pointer;
            transition: color 0.3s ease;
            line-height: 1;
        }

        .pwa-close:hover {
            color: #333;
        }

        .pwa-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #f0f7ff, #dbeafe);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 15px;
        }

        .pwa-icon svg {
            width: 40px;
            height: 40px;
        }

        .pwa-title {
            font-size: 22px;
            font-weight: 700;
            color: #1e40af;
            margin: 0 0 8px;
        }

        .pwa-description {
            color: #666;
            font-size: 14px;
            line-height: 1.6;
            margin: 0 0 20px;
        }

        .pwa-features {
            list-style: none;
            padding: 0;
            margin: 0 0 25px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .pwa-features li {
            font-size: 13px;
            color: #444;
            padding: 8px 12px;
            background: #f8fafc;
            border-radius: 10px;
            text-align: left;
        }

        .pwa-buttons {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .pwa-btn {
            padding: 14px 30px;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            width: 100%;
        }

        .pwa-btn-primary {
            background: linear-gradient(135deg, #1e40af, #3b82f6);
            color: white;
        }

        .pwa-btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 30px rgba(30, 64, 175, 0.4);
        }

        .pwa-btn-primary:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .pwa-btn-secondary {
            background: transparent;
            color: #94a3b8;
            font-size: 14px;
            padding: 8px;
        }

        .pwa-btn-secondary:hover {
            color: #64748b;
        }

        .pwa-btn-success {
            background: #10b981;
            color: white;
        }

        .pwa-btn-success:hover {
            background: #059669;
        }

        .spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            vertical-align: middle;
            margin-right: 8px;
        }

        .ios-guide {
            background: #f8fafc;
            border-radius: 12px;
            padding: 20px;
            margin: 15px 0;
            text-align: left;
            border: 1px solid #e5e7eb;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translate(-50%, 40%);
            }
            to {
                opacity: 1;
                transform: translate(-50%, -50%);
            }
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        @media (max-width: 480px) {
            .pwa-popup-content {
                padding: 20px;
                margin: 10px;
            }
            
            .pwa-title {
                font-size: 18px;
            }
            
            .pwa-features {
                grid-template-columns: 1fr 1fr;
                gap: 6px;
            }
            
            .pwa-features li {
                font-size: 12px;
                padding: 6px 10px;
            }
            
            .pwa-btn {
                font-size: 14px;
                padding: 12px 20px;
            }
        }
    </style>

    <script>
        function pwaHandler() {
            return {
                showPopup: true,
                deferredPrompt: null,
                isInstalling: false,
                showIosGuide: false,
                isIOS: /iPhone|iPad|iPod/.test(navigator.userAgent),
                
                initPWA() {
                    const self = this;
                    
                    // Check if already installed
                    if (localStorage.getItem('pwa_installed') === 'true' || 
                        localStorage.getItem('pwa_dismissed') === 'true') {
                        this.showPopup = false;
                        return;
                    }
                    
                    // Check if in standalone mode
                    if (window.matchMedia('(display-mode: standalone)').matches || 
                        window.navigator.standalone) {
                        localStorage.setItem('pwa_installed', 'true');
                        this.showPopup = false;
                        return;
                    }
                    
                    // Listen for beforeinstallprompt (Android/Chrome)
                    window.addEventListener('beforeinstallprompt', (e) => {
                        e.preventDefault();
                        self.deferredPrompt = e;
                        console.log('✅ Install prompt captured');
                    });
                    
                    // Listen for app installed
                    window.addEventListener('appinstalled', () => {
                        localStorage.setItem('pwa_installed', 'true');
                        self.showPopup = false;
                        self.isInstalling = false;
                        console.log('✅ App installed');
                        self.showToast('🎉 App installed successfully!', 'success');
                    });
                    
                    // Check if we're on iOS
                    if (this.isIOS) {
                        // For iOS, show popup with guide
                        this.showPopup = true;
                    }
                    
                    // Check if on Android with Chrome
                    if (/Android/.test(navigator.userAgent) && !this.deferredPrompt) {
                        // Chrome might not fire beforeinstallprompt immediately
                        setTimeout(() => {
                            if (!this.deferredPrompt) {
                                console.log('⚠️ No install prompt detected. Showing guide.');
                            }
                        }, 3000);
                    }
                },
                
                async installApp() {
                    const self = this;
                    
                    // iOS - show guide
                    if (this.isIOS) {
                        this.showIosGuide = !this.showIosGuide;
                        return;
                    }
                    
                    // If no deferred prompt
                    if (!this.deferredPrompt) {
                        if (/Android/.test(navigator.userAgent)) {
                            this.showToast('📱 Tap the menu (⋮) and select "Add to Home screen"', 'info');
                        } else {
                            this.showToast('Please open this in Chrome browser', 'info');
                        }
                        return;
                    }
                    
                    this.isInstalling = true;
                    
                    try {
                        const result = await this.deferredPrompt.prompt();
                        const outcome = await result.userChoice;
                        
                        if (outcome === 'accepted') {
                            localStorage.setItem('pwa_installed', 'true');
                            this.showPopup = false;
                            this.isInstalling = false;
                            this.showToast('🎉 App installed successfully!', 'success');
                        } else {
                            this.isInstalling = false;
                            this.showToast('Installation cancelled', 'info');
                        }
                    } catch (error) {
                        console.error('Install error:', error);
                        this.isInstalling = false;
                        this.showToast('❌ Failed to install. Please try again.', 'error');
                    }
                    
                    this.deferredPrompt = null;
                },
                
                dismissPopup() {
                    this.showPopup = false;
                    localStorage.setItem('pwa_dismissed', 'true');
                },
                
                showToast(message, type = 'info') {
                    const colors = {
                        success: '#10b981',
                        error: '#ef4444',
                        info: '#3b82f6'
                    };
                    
                    const toast = document.createElement('div');
                    toast.style.cssText = `
                        position: fixed;
                        bottom: 30px;
                        left: 50%;
                        transform: translateX(-50%);
                        background: ${colors[type]};
                        color: white;
                        padding: 14px 24px;
                        border-radius: 12px;
                        box-shadow: 0 10px 40px rgba(0,0,0,0.2);
                        z-index: 99999;
                        font-weight: 500;
                        animation: slideUp 0.5s ease;
                        max-width: 90%;
                        text-align: center;
                        font-size: 15px;
                    `;
                    toast.textContent = message;
                    document.body.appendChild(toast);
                    
                    setTimeout(() => {
                        toast.style.animation = 'slideDown 0.5s ease';
                        setTimeout(() => toast.remove(), 500);
                    }, 4000);
                }
            };
        }
        
        // Add slideDown animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes slideDown {
                from {
                    transform: translateX(-50%) translateY(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(-50%) translateY(100%);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</div>