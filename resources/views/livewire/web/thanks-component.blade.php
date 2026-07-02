<div>
    {{-- hello --}}
    <div class="min-h-screen bg-gray-50 flex items-center justify-center py-10 px-4">

        <div class="bg-white w-full max-w-3xl shadow-xl rounded-3xl p-10 relative overflow-hidden">

            <!-- Background Animation Bubbles -->
            <div class="absolute inset-0 opacity-10 pointer-events-none">
                <div class="absolute w-48 h-48 bg-blue-300 rounded-full blur-3xl top-10 left-10 animate-bubble"></div>
                <div class="absolute w-64 h-64 bg-purple-300 rounded-full blur-3xl bottom-0 right-0 animate-bubble-slow">
                </div>
            </div>

            <!-- Success Icon -->
            <div class="flex justify-center mb-6">
                <div id="success-icon"
                    class="w-24 h-24 bg-green-500 rounded-full flex items-center justify-center scale-0">
                    <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor" stroke-width="4"
                        viewBox="0 0 24 24">
                        <path d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
            </div>

            <!-- Heading -->
            <h1 class="text-center text-3xl font-bold text-gray-800 mb-3 opacity-0" id="title">
                🎉 Order Placed Successfully!
            </h1>

            <p class="text-center text-gray-600 mb-8 opacity-0" id="subtitle">
                Thank you for shopping with us. We’re preparing your order with care. 💙
            </p>

            <!-- Order Summary Card -->
            <div class="bg-gray-100 rounded-2xl p-6 mb-8 transform translate-y-10 opacity-0" id="summary-card">
                <h2 class="text-xl font-semibold mb-4 text-gray-800">Order Summary</h2>

                <div class="flex justify-between text-gray-700 mb-1">
                    <span>Order Number</span>
                    <span>#{{ $order->invoice_no }}</span>
                </div>
                <div class="flex justify-between text-gray-700 mb-1">
                    <span>Total Items</span>
                    <span>{{ $order->total_items }}</span>
                </div>
                <div class="flex justify-between text-gray-700 mb-1">
                    <span>Total Amount</span>
                    <span><strong>PKR {{ number_format($order->grand_total) }}</strong></span>
                </div>
                <div class="flex justify-between text-gray-700 mb-1">
                    <span>Payment Method</span>
                    <span>{{ strtoupper($order->payment_method) }}</span>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center opacity-0" id="buttons">

                <a href="" class="btn-primary px-6 py-3 rounded-full text-center">
                    Continue Shopping
                </a>

                <a href="" class="btn-outline px-6 py-3 rounded-full text-center">
                    View Order Details
                </a>

            </div>

        </div>
    </div>

    <!-- GSAP Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {

            // Success icon bounce animation
            gsap.to("#success-icon", {
                scale: 1,
                duration: 0.6,
                ease: "back.out(1.7)"
            });

            // Title fade down
            gsap.to("#title", {
                opacity: 1,
                y: -10,
                delay: 0.5,
                duration: 0.6,
                ease: "power2.out"
            });

            gsap.to("#subtitle", {
                opacity: 1,
                y: -10,
                delay: 0.7,
                duration: 0.6,
                ease: "power2.out"
            });

            // Card slide up
            gsap.to("#summary-card", {
                opacity: 1,
                y: 0,
                delay: 0.9,
                duration: 0.8,
                ease: "power2.out"
            });

            // Buttons fade in
            gsap.to("#buttons", {
                opacity: 1,
                delay: 1.2,
                duration: 0.8,
                ease: "power2.out"
            });
        });

        // Bubble animations
    </script>

    <style>
        @keyframes bubble {
            0% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-30px);
            }

            100% {
                transform: translateY(0);
            }
        }

        .animate-bubble {
            animation: bubble 6s infinite ease-in-out;
        }

        .animate-bubble-slow {
            animation: bubble 10s infinite ease-in-out;
        }
    </style>
</div>
