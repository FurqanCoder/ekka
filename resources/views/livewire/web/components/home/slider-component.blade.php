<div>
    <div class="sticky-header-next-sec ec-main-slider section section-space-pb">
        <div class="ec-slider swiper-container main-slider-nav main-slider-dot" 
             x-data="sliderComponent()" 
             x-init="initSwiper()"
             wire:ignore>
            
            <div class="swiper-wrapper">
                @foreach($slides as $index => $slide)
                    <div class="ec-slide-item swiper-slide d-flex"
                         style="background-image: url('{{ $slide['image_url'] ?? asset('web/images/main-slider-banner/default.jpg') }}'); 
                                background-size: cover; 
                                background-position: center;"
                         data-swiper-autoplay="{{ $autoplaySpeed }}">
                        
                        <div class="container align-self-center">
                            <div class="row">
                                <div class="col-xl-6 col-lg-7 col-md-7 col-sm-7 align-self-center">
                                    <div class="ec-slide-content slider-animation">
                                        @if($slide['discount_badge'])
                                            <span class="ec-slide-badge">{{ $slide['discount_badge'] }}</span>
                                        @endif
                                        
                                        <h1 class="ec-slide-title">{{ $slide['title'] }}</h1>
                                        
                                        @if($slide['offer_label'])
                                            <h2 class="ec-slide-stitle">{{ $slide['offer_label'] }}</h2>
                                        @endif
                                        
                                        @if($slide['description'])
                                            <p>{{ $slide['description'] }}</p>
                                        @endif
                                        
                                        @if($slide['button_text'])
                                            <a href="{{ $slide['button_link'] ?? '#' }}" 
                                               class="btn btn-lg btn-secondary">
                                                {{ $slide['button_text'] }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            @if($showIndicators && count($slides) > 1)
                <div class="swiper-pagination swiper-pagination-white"></div>
            @endif

            <!-- Navigation Arrows -->
            @if($showArrows && count($slides) > 1)
                <div class="swiper-buttons">
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            @endif
        </div>

        <!-- Slide Counter -->
        <div class="slide-counter" x-show="totalSlides > 1">
            <span x-text="currentSlide + 1"></span>
            <span class="separator">/</span>
            <span x-text="totalSlides"></span>
        </div>
    </div>

    <!-- Styles -->
    @push('styles')
    <style>
        .ec-main-slider {
            position: relative;
            overflow: hidden;
        }

        .ec-slide-item {
            min-height: 600px;
            position: relative;
            background-color: #f8f9fa;
        }

        .ec-slide-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0) 100%);
            z-index: 1;
        }

        .ec-slide-content {
            position: relative;
            z-index: 2;
            padding: 30px 0;
            max-width: 600px;
        }

        .ec-slide-badge {
            display: inline-block;
            background: #ff6b6b;
            color: #fff;
            padding: 5px 20px;
            border-radius: 30px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 20px;
            animation: fadeInUp 0.8s ease;
        }

        .ec-slide-title {
            font-size: 48px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
            line-height: 1.2;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease 0.2s both;
        }

        .ec-slide-stitle {
            font-size: 32px;
            font-weight: 600;
            color: #ffd700;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease 0.4s both;
        }

        .ec-slide-content p {
            font-size: 18px;
            color: rgba(255,255,255,0.9);
            margin-bottom: 25px;
            max-width: 500px;
            text-shadow: 1px 1px 3px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease 0.6s both;
        }

        .ec-slide-content .btn {
            padding: 12px 40px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            animation: fadeInUp 1s ease 0.8s both;
            background: #ff6b6b;
            border: none;
            color: #fff;
        }

        .ec-slide-content .btn:hover {
            background: #e55a5a;
            transform: translateY(-3px);
            box-shadow: 0 10px 30px rgba(255,107,107,0.3);
        }

        /* Swiper Navigation */
        .swiper-buttons {
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            transform: translateY(-50%);
            z-index: 10;
            pointer-events: none;
        }

        .swiper-button-next,
        .swiper-button-prev {
            pointer-events: auto;
            width: 50px;
            height: 50px;
            background: rgba(255,255,255,0.2);
            backdrop-filter: blur(10px);
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(255,255,255,0.4);
            transform: scale(1.1);
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
            font-size: 18px;
            color: #fff;
            font-weight: bold;
        }

        /* Pagination */
        .swiper-pagination-bullet {
            width: 12px;
            height: 12px;
            background: rgba(255,255,255,0.5);
            opacity: 1;
            transition: all 0.3s ease;
        }

        .swiper-pagination-bullet-active {
            background: #ff6b6b;
            width: 30px;
            border-radius: 6px;
        }

        /* Slide Counter */
        .slide-counter {
            position: absolute;
            bottom: 30px;
            right: 30px;
            z-index: 10;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            background: rgba(0,0,0,0.5);
            padding: 8px 16px;
            border-radius: 20px;
            backdrop-filter: blur(5px);
        }

        .slide-counter .separator {
            margin: 0 5px;
            opacity: 0.5;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInRight {
            from {
                opacity: 0;
                transform: translateX(50px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Responsive */
        @media (max-width: 991px) {
            .ec-slide-item {
                min-height: 450px;
            }
            
            .ec-slide-title {
                font-size: 32px;
            }
            
            .ec-slide-stitle {
                font-size: 24px;
            }
            
            .ec-slide-content p {
                font-size: 16px;
            }
        }

        @media (max-width: 767px) {
            .ec-slide-item {
                min-height: 350px;
                background-position: center center !important;
            }
            
            .ec-slide-content {
                text-align: center;
                padding: 20px;
            }
            
            .ec-slide-content p {
                margin: 0 auto 20px;
            }
            
            .ec-slide-title {
                font-size: 24px;
            }
            
            .ec-slide-stitle {
                font-size: 18px;
            }
            
            .swiper-button-next,
            .swiper-button-prev {
                width: 35px;
                height: 35px;
            }
            
            .swiper-button-next::after,
            .swiper-button-prev::after {
                font-size: 14px;
            }
            
            .slide-counter {
                display: none;
            }
        }
    </style>
    @endpush

    <!-- JavaScript for Swiper -->
    @push('scripts')
    <script>
        function sliderComponent() {
            return {
                swiper: null,
                currentSlide: 0,
                totalSlides: {{ count($slides) }},
                autoplaySpeed: {{ $autoplaySpeed }},
                
                initSwiper() {
                    // Wait for DOM to be ready
                    this.$nextTick(() => {
                        if (typeof Swiper !== 'undefined') {
                            this.initializeSwiper();
                        } else {
                            // Load Swiper if not available
                            this.loadSwiperLibrary();
                        }
                    });
                },
                
                loadSwiperLibrary() {
                    // Load Swiper CSS and JS if not already loaded
                    if (!document.querySelector('#swiper-css')) {
                        const link = document.createElement('link');
                        link.id = 'swiper-css';
                        link.rel = 'stylesheet';
                        link.href = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css';
                        document.head.appendChild(link);
                    }
                    
                    if (!document.querySelector('#swiper-js')) {
                        const script = document.createElement('script');
                        script.id = 'swiper-js';
                        script.src = 'https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js';
                        script.onload = () => {
                            this.initializeSwiper();
                        };
                        document.body.appendChild(script);
                    } else {
                        // If script already exists but not loaded
                        if (typeof Swiper !== 'undefined') {
                            this.initializeSwiper();
                        } else {
                            document.querySelector('#swiper-js').addEventListener('load', () => {
                                this.initializeSwiper();
                            });
                        }
                    }
                },
                
                initializeSwiper() {
                    const container = document.querySelector('.ec-slider');
                    if (!container) return;
                    
                    // Destroy existing swiper instance
                    if (this.swiper) {
                        this.swiper.destroy(true, true);
                    }
                    
                    this.swiper = new Swiper(container, {
                        slidesPerView: 1,
                        spaceBetween: 0,
                        loop: true,
                        autoplay: {
                            delay: this.autoplaySpeed,
                            disableOnInteraction: false,
                            pauseOnMouseEnter: true,
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true,
                            dynamicBullets: true,
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev',
                        },
                        speed: 800,
                        effect: 'slide',
                        watchSlidesProgress: true,
                        on: {
                            slideChange: () => {
                                if (this.swiper) {
                                    this.currentSlide = this.swiper.realIndex;
                                    // Update slide counter
                                    const counter = document.querySelector('.slide-counter span:first-child');
                                    if (counter) {
                                        counter.textContent = this.currentSlide + 1;
                                    }
                                }
                            }
                        }
                    });
                    
                    // Update total slides
                    this.totalSlides = this.swiper.slides.length;
                    
                    // Update slide counter
                    const counter = document.querySelector('.slide-counter span:first-child');
                    if (counter) {
                        counter.textContent = '1';
                    }
                    const total = document.querySelector('.slide-counter span:last-child');
                    if (total) {
                        total.textContent = this.totalSlides;
                    }
                    
                    // Pause on hover
                    const sliderElement = document.querySelector('.ec-slider');
                    if (sliderElement) {
                        sliderElement.addEventListener('mouseenter', () => {
                            if (this.swiper && this.swiper.autoplay) {
                                this.swiper.autoplay.stop();
                            }
                        });
                        
                        sliderElement.addEventListener('mouseleave', () => {
                            if (this.swiper && this.swiper.autoplay) {
                                this.swiper.autoplay.start();
                            }
                        });
                    }
                },
                
                // Refresh swiper when slides change
                refreshSwiper() {
                    if (this.swiper) {
                        this.swiper.update();
                        this.swiper.autoplay.start();
                    }
                }
            };
        }

        // Listen for Livewire events
        document.addEventListener('livewire:initialized', function () {
            Livewire.on('slidesRefreshed', () => {
                const slider = document.querySelector('[x-data]')?.__x?.data();
                if (slider && typeof slider.refreshSwiper === 'function') {
                    slider.refreshSwiper();
                }
            });
            
            Livewire.on('notification', (data) => {
                showNotification(data.message, data.type);
            });
        });

        function showNotification(message, type = 'info') {
            const colors = {
                success: '#28a745',
                error: '#dc3545',
                info: '#17a2b8',
                warning: '#ffc107'
            };
            
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 20px;
                right: 20px;
                background: ${colors[type] || colors.info};
                color: white;
                padding: 15px 25px;
                border-radius: 8px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.2);
                z-index: 9999;
                font-weight: 500;
                animation: slideInRight 0.5s ease;
                max-width: 350px;
            `;
            notification.textContent = message;
            
            document.body.appendChild(notification);
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.5s ease';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }
    </script>
    @endpush
</div>