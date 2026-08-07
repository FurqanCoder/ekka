<!-- Footer Start -->
<footer class="ec-footer section-space-mt">
    <div class="footer-container">
        <!-- Footer Offer Bar -->
        <div class="footer-offer">
            <div class="container">
                <div class="row">
                    <div class="text-center footer-off-msg">
                        <span>🏷️ Win a contest! Get this limited-edition</span>
                        <a href="{{ route('web.shop') }}" target="_blank">View Detail →</a>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="footer-top section-space-footer-p">
            <div class="container">
                <div class="row">
                    <!-- Contact Info -->
                    <div class="col-sm-12 col-lg-3 ec-footer-contact">
                        <div class="ec-footer-widget">
                            <div class="ec-footer-logo">
                                <a href="{{ route('home') }}">
                                    @php
                                        $settings = \App\Helpers\WebsiteHelper::getSettings();
                                    @endphp
                                    @if($settings->logo_light_url)
                                        <img src="{{ $settings->logo_light_url }}" alt="{{ $settings->website_name ?? 'Logo' }}" class="footer-logo-light">
                                    @else
                                        <img src="{{ asset('web/images/logo/footer-logo.png') }}" alt="Logo" class="footer-logo-light">
                                    @endif
                                    @if($settings->logo_dark_url)
                                        <img src="{{ $settings->logo_dark_url }}" alt="{{ $settings->website_name ?? 'Logo' }}" class="footer-logo-dark" style="display: none;">
                                    @else
                                        <img src="{{ asset('web/images/logo/dark-logo.png') }}" alt="Logo" class="footer-logo-dark" style="display: none;">
                                    @endif
                                </a>
                            </div>
                            <h4 class="ec-footer-heading">Contact us</h4>
                            <div class="ec-footer-links">
                                <ul class="align-items-center">
                                    @if($settings->address)
                                        <li class="ec-footer-link">
                                            <i class="ecicon eci-map-marker"></i> 
                                            {{ $settings->address }}
                                        </li>
                                    @endif
                                    @if($settings->phone)
                                        <li class="ec-footer-link">
                                            <i class="ecicon eci-phone"></i> 
                                            <a href="tel:{{ $settings->phone }}">{{ $settings->phone }}</a>
                                        </li>
                                    @endif
                                    @if($settings->email)
                                        <li class="ec-footer-link">
                                            <i class="ecicon eci-envelope"></i> 
                                            <a href="mailto:{{ $settings->email }}">{{ $settings->email }}</a>
                                        </li>
                                    @endif
                                    @if($settings->whatsapp)
                                        <li class="ec-footer-link">
                                            <i class="ecicon eci-whatsapp"></i> 
                                            <a href="https://wa.me/{{ $settings->whatsapp }}" target="_blank">WhatsApp</a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Information -->
                    <div class="col-sm-12 col-lg-2 ec-footer-info">
                        <div class="ec-footer-widget">
                            <h4 class="ec-footer-heading">Information</h4>
                            <div class="ec-footer-links">
                                <ul class="align-items-center">
                                    <li class="ec-footer-link"><a href="{{ route('web.about-us') }}">About Us</a></li>
                                    <li class="ec-footer-link"><a href="{{ route('web.contact-us') }}">Contact Us</a></li>
                                    <li class="ec-footer-link"><a href="{{ route('web.filter') }}">Shop</a></li>
                                    <li class="ec-footer-link"><a href="#">FAQ</a></li>
                                    {{-- <li class="ec-footer-link"><a href="#">Delivery Information</a></li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Account -->
                    <div class="col-sm-12 col-lg-2 ec-footer-account">
                        <div class="ec-footer-widget">
                            <h4 class="ec-footer-heading">Account</h4>
                            <div class="ec-footer-links">
                                <ul class="align-items-center">
                                    @auth
                                        <li class="ec-footer-link"><a href="{{ route('dashboard') }}">My Account</a></li>
                                        <li class="ec-footer-link"><a href="{{ route('dashboard') }}">Order History</a></li>
                                        <li class="ec-footer-link"><a href="{{ route('web.wish') }}">Wish List</a></li>
                                        <li class="ec-footer-link"><a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a></li>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    @else
                                        <li class="ec-footer-link"><a href="{{ route('login') }}">Login</a></li>
                                        <li class="ec-footer-link"><a href="{{ route('register') }}">Register</a></li>
                                    @endauth
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Services -->
                    <div class="col-sm-12 col-lg-2 ec-footer-service">
                        <div class="ec-footer-widget">
                            <h4 class="ec-footer-heading">Services</h4>
                            <div class="ec-footer-links">
                                <ul class="align-items-center">
                                    <li class="ec-footer-link"><a href="#">Returns Policy</a></li>
                                    <li class="ec-footer-link"><a href="#">Privacy Policy</a></li>
                                    <li class="ec-footer-link"><a href="#">Terms & Conditions</a></li>
                                    <li class="ec-footer-link"><a href="#">Customer Service</a></li>
                                    {{-- <li class="ec-footer-link"><a href="#">Track Order</a></li> --}}
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Newsletter -->
                    <div class="col-sm-12 col-lg-3 ec-footer-news">
                        <div class="ec-footer-widget">
                            <h4 class="ec-footer-heading">Newsletter</h4>
                            <div class="ec-footer-links">
                                <ul class="align-items-center">
                                    <li class="ec-footer-link">Get instant updates about our new products and special promos!</li>
                                </ul>
                                <div class="ec-subscribe-form">
                                    <form id="ec-newsletter-form" method="POST" action="#">
                                        @csrf
                                        <div id="ec_news_signup" class="ec-form">
                                            <input class="ec-email" type="email" required=""
                                                placeholder="Enter your email here..." name="email" />
                                            <button id="ec-news-btn" class="button btn-primary" type="submit"
                                                name="subscribe" value="">
                                                <i class="ecicon eci-paper-plane-o" aria-hidden="true"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Footer social -->
                    <div class="col text-left footer-bottom-left">
                        <div class="footer-bottom-social">
                            <span class="social-text text-upper">Follow us on:</span>
                            <ul class="mb-0">
                                @php
                                    $socialLinks = $settings->active_social_links ?? [];
                                @endphp
                                @if(isset($socialLinks['facebook']) && $socialLinks['facebook'])
                                    <li class="list-inline-item">
                                        <a class="hdr-facebook" href="{{ $socialLinks['facebook'] }}" target="_blank" aria-label="Facebook">
                                            <i class="ecicon eci-facebook"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($socialLinks['twitter']) && $socialLinks['twitter'])
                                    <li class="list-inline-item">
                                        <a class="hdr-twitter" href="{{ $socialLinks['twitter'] }}" target="_blank" aria-label="Twitter">
                                            <i class="ecicon eci-twitter"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($socialLinks['instagram']) && $socialLinks['instagram'])
                                    <li class="list-inline-item">
                                        <a class="hdr-instagram" href="{{ $socialLinks['instagram'] }}" target="_blank" aria-label="Instagram">
                                            <i class="ecicon eci-instagram"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($socialLinks['linkedin']) && $socialLinks['linkedin'])
                                    <li class="list-inline-item">
                                        <a class="hdr-linkedin" href="{{ $socialLinks['linkedin'] }}" target="_blank" aria-label="LinkedIn">
                                            <i class="ecicon eci-linkedin"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($socialLinks['youtube']) && $socialLinks['youtube'])
                                    <li class="list-inline-item">
                                        <a class="hdr-youtube" href="{{ $socialLinks['youtube'] }}" target="_blank" aria-label="YouTube">
                                            <i class="ecicon eci-youtube-play"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($socialLinks['tiktok']) && $socialLinks['tiktok'])
                                    <li class="list-inline-item">
                                        <a class="hdr-tiktok" href="{{ $socialLinks['tiktok'] }}" target="_blank" aria-label="TikTok">
                                            <i class="ecicon eci-tiktok"></i>
                                        </a>
                                    </li>
                                @endif
                                @if(isset($socialLinks['pinterest']) && $socialLinks['pinterest'])
                                    <li class="list-inline-item">
                                        <a class="hdr-pinterest" href="{{ $socialLinks['pinterest'] }}" target="_blank" aria-label="Pinterest">
                                            <i class="ecicon eci-pinterest"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>

                    <!-- Copyright -->
                    <div class="col text-center footer-copy">
                        <div class="footer-bottom-copy">
                            <div class="ec-copy">
                                Copyright © <span id="copyright_year"></span> 
                                <a class="site-name text-upper" href="{{ route('home') }}">
                                    {{ $settings->website_name ?? 'ekka' }}<span>.</span>
                                </a>. 
                                @if($settings->copyright_text)
                                    {{ $settings->copyright_text }}
                                @else
                                    All Rights Reserved
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Payment -->
                    <div class="col footer-bottom-right">
                        <div class="footer-bottom-payment d-flex justify-content-end">
                            <div class="payment-link">
                                <img src="{{ asset('web/images/icons/payment.png') }}" alt="Payment Methods">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

<script>
    // Auto-update copyright year
    document.getElementById('copyright_year').textContent = new Date().getFullYear();

    // Dark mode logo toggle
    document.addEventListener('DOMContentLoaded', function() {
        // Check if dark mode is enabled
        const isDarkMode = document.documentElement.classList.contains('dark-mode') || 
                          (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches);
        
        const logoLight = document.querySelector('.footer-logo-light');
        const logoDark = document.querySelector('.footer-logo-dark');
        
        if (isDarkMode) {
            if (logoLight) logoLight.style.display = 'none';
            if (logoDark) logoDark.style.display = 'block';
        } else {
            if (logoLight) logoLight.style.display = 'block';
            if (logoDark) logoDark.style.display = 'none';
        }
    });
</script>