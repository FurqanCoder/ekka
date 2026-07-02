 <!-- Vendor JS -->
 <script src="{{ asset('web/js/vendor/jquery-3.5.1.min.js') }}"></script>
 <script src="{{ asset('web/js/vendor/popper.min.js') }}"></script>
 <script src="{{ asset('web/js/vendor/bootstrap.min.js') }}"></script>
 <script src="{{ asset('web/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
 <script src="{{ asset('web/js/vendor/modernizr-3.11.2.min.js') }}"></script>

 <!--Plugins JS-->
 <script src="{{ asset('web/js/plugins/swiper-bundle.min.js') }}"></script>
 <script src="{{ asset('web/js/plugins/countdownTimer.min.js') }}"></script>
 <script src="{{ asset('web/js/plugins/scrollup.js') }}"></script>
 <script src="{{ asset('web/js/plugins/jquery.zoom.min.js') }}"></script>
 <script src="{{ asset('web/js/plugins/slick.min.js') }}"></script>
 <script src="{{ asset('web/js/plugins/infiniteslidev2.js') }}"></script>
 <script src="{{ asset('web/js/vendor/jquery.magnific-popup.min.j') }}s"></script>
 <script src="{{ asset('web/js/plugins/jquery.sticky-sidebar.js') }}"></script>

 <!-- Main Js -->
 <script src="{{ asset('web/js/vendor/index.js') }}"></script>
 <script src="{{ asset('web/js/main.js') }}"></script>
 <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
 <script>
     document.addEventListener('DOMContentLoaded', () => {

         window.showToast = function(message, type = 'info') {
             // Prevent undefined message errors
             if (!message || typeof message !== 'string') {
                 console.warn('Toast called without a valid message.');
                 message = 'Something went wrong.'; // fallback text
             }

             let background, icon;

             switch (type) {
                 case 'success':
                     background = "#007bff"; // blue
                     icon = "✔️ ";
                     break;
                 case 'error':
                     background = "#dc3545"; // red
                     icon = "❌ ";
                     break;
                 case 'warning':
                     background = "#ffc107"; // yellow
                     icon = "⚠️ ";
                     break;
                 default:
                     background = "#17a2b8"; // teal/info
                     icon = "ℹ️ ";
             }

             Toastify({
                 text: icon + message,
                 duration: 3500,
                 gravity: "top", // top or bottom
                 position: "right", // left, center or right
                 close: true,
                 stopOnFocus: true,
                 style: {
                     background: background,
                     color: "#fff",
                     fontWeight: "600",
                     fontSize: "14px",
                     borderRadius: "8px",
                     padding: "12px 18px",
                     boxShadow: "0 4px 12px rgba(0,0,0,0.15)"
                 },
                 offset: {
                     x: 15,
                     y: 60
                 }
             }).showToast();
         };

         // Hook for Livewire
         window.addEventListener('toast', e => {
             console.log(e.detail);
             let payload = e.detail;

             // if it’s an array with index 0, unwrap it
             if (Array.isArray(payload)) payload = payload[0];

             const {
                 message,
                 type
             } = payload;
             window.showToast(message, type);
         });

     });
 </script>
 @livewireScripts()
