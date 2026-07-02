  <!-- Import Js Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
  <script src="{{asset('assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('assets/libs/simplebar/dist/simplebar.min.js')}}"></script>
  <script src="{{asset('assets/js/theme/app.init.js')}}"></script>
  <script src="{{asset('assets/js/theme/theme.js')}}"></script>
  <script src="{{asset('assets/js/theme/app.min.js')}}"></script>
  <script src="{{asset('assets/js/theme/sidebarmenu.js')}}"></script>

  <!-- solar icons -->
  <script src="{{asset('npm/iconify-icon%401.0.8/dist/iconify-icon.min-1.js')}}"></script>
  <script src="{{asset("assets/libs/apexcharts/dist/apexcharts.min.js")}}"></script>
  <script src="{{asset('assets/js/dashboards/dashboard1.js')}}"></script>
  <script src="{{asset('assets/libs/fullcalendar/index.global.min.js')}}"></script>

    <script>
    window.addEventListener('open-modal', () => {
        console.log('event worker started');
        const modal = new bootstrap.Modal(document.getElementById('category-modal'));
        modal.show();
    });
    window.addEventListener('close-modal', () => {
        // console.log('close event worker started');
        const modal = bootstrap.Modal.getInstance(document.getElementById('category-modal'));
        modal.hide();
    });
    window.addEventListener('open-modal', () => {
        console.log('event worker started');
        const modal = new bootstrap.Modal(document.getElementById('brand-modal'));
        modal.show();
    });
    window.addEventListener('close-modal', () => {
        // console.log('close event worker started');
        const modal = bootstrap.Modal.getInstance(document.getElementById('brand-modal'));
        modal.hide();
    });
</script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        toastr.options = {
            closeButton: true, // Show a close button
            progressBar: true, // Show a progress bar
            positionClass: 'toast-top-right', // Position of the toast
            showEasing: 'swing', // Fade-in easing
            hideEasing: 'linear', // Fade-out easing
            showMethod: 'fadeIn', // Animation method for showing
            hideMethod: 'fadeOut', // Animation method for hiding
            timeOut: 2000, // Duration before the toast disappears
            showMethod: "slideDown",
            hideMethod: "slideUp" // Animation method for hiding
        };
        Livewire.on('toast', ([message, type]) => {
            console.log('Type:', type);
            console.log('Message:', message);

            if (['success', 'info', 'warning', 'error'].includes(type)) {
                toastr[type](message); // Valid type
            } else {
                console.error(`Invalid toastr type: ${type}`);
            }
        });
    });
</script>
