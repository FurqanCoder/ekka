<div>
    
    <a class="ec-btn-group compare" wire:click="openModal">
        <i class="fi-rr-eye"></i>
    </a>
@if ($addmodal == 1)
 @livewire('web.components.quick-view-modal');
    
@endif
    {{-- quick view modal --}}

    <script>
        window.addEventListener('showmodal', () => {
            const modalEl = document.getElementById('ec_quickview_modal');
            const quickModal = new bootstrap.Modal(modalEl);
            quickModal.show();
        });
    </script>
</div>
