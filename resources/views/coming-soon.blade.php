@extends('layouts.web')

@section('web-content')
<div class="main-content">
  <section class="ec-page-content section-space-p">
    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <img src="{{ asset('web/images/logo/logo.png') }}" alt="Logo" style="max-width:160px;margin-bottom:24px;">
          <h1 class="ec-welcome-title">We're coming soon</h1>
          <p class="ec-welcome-desc mb-4">We're working hard to bring you an improved shopping experience. Sign up to get notified when we launch.</p>

          <div class="countdowntimer mb-4"><span id="coming-soon-count"></span></div>

          <form id="comingSoonForm" class="row g-2 justify-content-center">
            <div class="col-md-7">
              <input type="email" id="cs-email" class="form-control" placeholder="Enter email address" required>
            </div>
            <div class="col-md-3">
              <button class="btn btn-primary w-100" type="submit">Notify Me</button>
            </div>
          </form>

          <div class="mt-3">
            <a href="{{ route('home') }}" class="btn btn-link">Back to home</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function(){
  // Initialize countdown to 30 days from now
  const target = new Date();
  target.setDate(target.getDate() + 30);

  // If countdownTimer plugin exists
  if (typeof $.fn.countdownTimer === 'function') {
    $('#coming-soon-count').countdowntimer({
      dateAndTime: target.toISOString().split('.')[0].replace('T', ' '),
      size: "lg"
    });
  } else {
    // fallback simple countdown
    function updateFallback() {
      const now = new Date();
      const diff = target - now;
      if (diff <= 0) {
        document.getElementById('coming-soon-count').innerText = 'Launched!';
        clearInterval(iv);
        return;
      }
      const days = Math.floor(diff / (1000*60*60*24));
      const hours = Math.floor((diff/(1000*60*60))%24);
      const mins = Math.floor((diff/(1000*60))%60);
      const secs = Math.floor((diff/1000)%60);
      document.getElementById('coming-soon-count').innerText = days + 'd ' + hours + 'h ' + mins + 'm ' + secs + 's';
    }
    updateFallback();
    const iv = setInterval(updateFallback, 1000);
  }

  // simple email submit - show toast, backend endpoint can be added later
  document.getElementById('comingSoonForm').addEventListener('submit', function(e){
    e.preventDefault();
    const email = document.getElementById('cs-email').value;
    if (!email) return;
    // basic validation
    const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\\.,;:\s@\"]+\.)+[^<>()[\]\\.,;:\s@\"]{2,})$/i;
    if (!re.test(email)) {
      window.showToast('Please enter a valid email address', 'warning');
      return;
    }

    window.showToast('Thanks — we will notify you!', 'success');
    // TODO: POST to backend route to save subscriber
    this.reset();
  });

});
</script>
@endpush

@endsection
