<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <!-- Header -->
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Carousel Settings</h4>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item d-flex align-items-center">
                                        <a class="text-muted text-decoration-none d-flex" href="index.html">
                                            <iconify-icon icon="solar:home-2-line-duotone"
                                                class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                            Carousel Manager
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Loading Indicator -->
            <div wire:loading wire:target="saveAllItems" class="alert alert-info">
                <iconify-icon icon="svg-spinners:bars-scale" class="me-2"></iconify-icon>
                Saving items...
            </div>

            <!-- Add New Item Button -->
            <div class="mb-4">
                <button class="btn btn-primary" wire:click="addCarouselItem" wire:loading.attr="disabled">
                    <iconify-icon icon="solar:add-circle-bold" class="fs-5 me-1"></iconify-icon>
                    Add New Carousel Item
                </button>

                <span class="ms-3 text-muted">
                    <iconify-icon icon="solar:info-circle-bold"></iconify-icon>
                    Total Items: {{ count($carouselItems) }}
                </span>
            </div>

            <!-- Carousel Items Container -->
            <div id="carousel-container">
                @foreach ($carouselItems as $index => $item)
                    <div class="carousel-item-wrapper mb-4" wire:key="carousel-{{ $index }}"
                        data-index="{{ $index }}">
                        <div class="card {{ $editMode && $editingId == $index ? 'border-primary shadow-lg' : '' }}">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h5 class="mb-0">
                                    Carousel Item #{{ $loop->iteration }}
                                    @if ($item['is_new'])
                                        <span class="badge bg-info ms-2">New</span>
                                    @endif
                                    @if (isset($item['id']) && $item['id'])
                                        <span class="badge bg-success ms-2">ID: {{ $item['id'] }}</span>
                                    @endif
                                </h5>
                                <div>
                                    @if ($editMode && $editingId == $index)
                                        <button class="btn btn-sm btn-success me-2"
                                            wire:click="saveEdit({{ $index }})" wire:loading.attr="disabled">
                                            <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                            Save
                                        </button>
                                        <button class="btn btn-sm btn-secondary me-2" wire:click="cancelEdit">
                                            <iconify-icon icon="solar:close-circle-bold"></iconify-icon>
                                            Cancel
                                        </button>
                                    @else
                                        <button class="btn btn-sm btn-warning me-2"
                                            wire:click="editItem({{ $index }})" wire:loading.attr="disabled">
                                            <iconify-icon icon="solar:pen-bold"></iconify-icon>
                                            Edit
                                        </button>
                                    @endif
                                    <button class="btn btn-sm btn-danger"
                                        wire:click="removeCarouselItem({{ $index }})"
                                        wire:loading.attr="disabled"
                                        onclick="return confirm('Are you sure you want to delete this item?')">
                                        <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                                        Delete
                                    </button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- Image Upload -->
                                    <div class="col-md-4 mb-3">
                                        <label class="form-label fw-bold">Product Image</label>
                                        <div class="image-upload-wrapper">
                                            <div class="image-preview mb-2"
                                                style="width: 100%; height: 200px; border: 2px dashed #ddd; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                                @if (!empty($item['image']))
                                                    {{-- New file just selected — always takes priority for live preview --}}
                                                    <img src="{{ $item['image']->temporaryUrl() }}" alt="Product"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                @elseif(!empty($item['image_url']))
                                                {{-- <small class="text-danger d-block">DEBUG: {{ $item['image_url'] }}</small> --}}
                                                    <img src="{{ $item['image_url'] }}" alt="Product"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                @elseif(!empty($item['existing_image']))
                                                {{-- <small class="text-danger d-block">DEBUG: {{ $item['existing_image'] }}</small> --}}
                                                    {{-- Fallback when accessor/image_url wasn't set --}}
                                                    <img src="{{ $item['existing_image'] }}"
                                                        alt="Product"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                @else
                                                    <img src="https://via.placeholder.com/300x200/FF6B6B/FFFFFF?text=Upload+Image"
                                                        alt="Product"
                                                        style="width: 100%; height: 100%; object-fit: cover;">
                                                @endif
                                            </div>
                                            <input type="file" class="form-control" accept="image/*"
                                                wire:model="carouselItems.{{ $index }}.image"
                                                {{ $editMode && $editingId == $index ? '' : 'disabled' }}>
                                            @error("carouselItems.{$index}.image")
                                                <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                            <small class="text-muted">Recommended: 1920*800 (Max: 2MB)</small>
                                            @if (isset($item['existing_image']) && $item['existing_image'] && !$item['is_new'])
                                                <small class="text-success d-block mt-1">
                                                    <iconify-icon icon="solar:check-circle-bold"></iconify-icon>
                                                    Image saved in database
                                                </small>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Input Fields -->
                                    <div class="col-md-8">
                                        <div class="row">
                                            <!-- Title Input -->
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">
                                                    Title <span class="text-danger">*</span>
                                                </label>
                                                <input type="text"
                                                    class="form-control @error("carouselItems.{$index}.title") is-invalid @enderror"
                                                    placeholder="Enter product title"
                                                    wire:model="carouselItems.{{ $index }}.title"
                                                    {{ $editMode && $editingId == $index ? '' : 'disabled' }}>
                                                @error("carouselItems.{$index}.title")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <!-- Offer/Badge Input -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Offer Label</label>
                                                <input type="text" class="form-control"
                                                    placeholder="e.g., SALE OFFER"
                                                    wire:model="carouselItems.{{ $index }}.offer_label"
                                                    {{ $editMode && $editingId == $index ? '' : 'disabled' }}>
                                            </div>

                                            <!-- Discount/Badge Input -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Discount/Badge</label>
                                                <input type="text" class="form-control"
                                                    placeholder="e.g., 50% OFF"
                                                    wire:model="carouselItems.{{ $index }}.discount_badge"
                                                    {{ $editMode && $editingId == $index ? '' : 'disabled' }}>
                                            </div>

                                            <!-- Description Textarea -->
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Description</label>
                                                <textarea class="form-control" rows="2" placeholder="Enter product description"
                                                    wire:model="carouselItems.{{ $index }}.description"
                                                    {{ $editMode && $editingId == $index ? '' : 'disabled' }}></textarea>
                                            </div>

                                            <!-- Link Input -->
                                            <div class="col-12 mb-3">
                                                <label class="form-label fw-bold">Button Link</label>
                                                <div class="input-group">
                                                    <span class="input-group-text">
                                                        <iconify-icon icon="solar:link-bold"></iconify-icon>
                                                    </span>
                                                    <input type="url"
                                                        class="form-control @error("carouselItems.{$index}.button_link") is-invalid @enderror"
                                                        placeholder="https://example.com/product"
                                                        wire:model="carouselItems.{{ $index }}.button_link"
                                                        {{ $editMode && $editingId == $index ? '' : 'disabled' }}>
                                                    @error("carouselItems.{$index}.button_link")
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>

                                            <!-- Button Text -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Button Text</label>
                                                <input type="text" class="form-control" placeholder="Order Now"
                                                    wire:model="carouselItems.{{ $index }}.button_text"
                                                    {{ $editMode && $editingId == $index ? '' : 'disabled' }}>
                                            </div>

                                            <!-- Status -->
                                            <div class="col-md-6 mb-3">
                                                <label class="form-label fw-bold">Status</label>
                                                <select
                                                    class="form-select @error("carouselItems.{$index}.status") is-invalid @enderror"
                                                    wire:model="carouselItems.{{ $index }}.status"
                                                    {{ $editMode && $editingId == $index ? '' : 'disabled' }}>
                                                    <option value="active">Active</option>
                                                    <option value="inactive">Inactive</option>
                                                    <option value="draft">Draft</option>
                                                </select>
                                                @error("carouselItems.{$index}.status")
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Save All Changes -->
            <div class="card mt-4">
                <div class="card-body">
                    <div class="d-flex gap-2 justify-content-end">
                        <button class="btn btn-secondary" wire:click="resetAllItems" wire:loading.attr="disabled">
                            <iconify-icon icon="solar:restart-bold" class="me-1"></iconify-icon>
                            Reset
                        </button>
                        <button class="btn btn-success" wire:click="saveAllItems" wire:loading.attr="disabled">
                            <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
                            <span wire:loading.remove>Save All Changes</span>
                            <span wire:loading>Saving...</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Styles -->
    <style>
        .carousel-item-wrapper {
            transition: all 0.3s ease;
        }

        .carousel-item-wrapper:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .image-upload-wrapper input[type="file"] {
            padding: 8px;
        }

        .image-upload-wrapper input[type="file"]:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        .image-preview img {
            transition: opacity 0.3s ease;
        }

        .image-preview img:hover {
            opacity: 0.8;
        }

        .card-header .btn {
            padding: 4px 8px;
        }

        .card.border-primary {
            border-width: 2px !important;
        }

        /* Animation for adding/removing items */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .carousel-item-wrapper-new {
            animation: slideIn 0.3s ease;
        }

        /* Loading spinner */
        .btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }
    </style>

    <!-- JavaScript for notifications and animations -->
    @push('scripts')
        <script>
            document.addEventListener('livewire:initialized', function() {
                // Listen for notification events
                Livewire.on('notification', (data) => {
                    showNotification(data.message, data.type);
                });

                // Listen for item added event
                Livewire.on('itemAdded', () => {
                    const container = document.getElementById('carousel-container');
                    const lastItem = container.lastElementChild;
                    if (lastItem) {
                        lastItem.classList.add('carousel-item-wrapper-new');
                        setTimeout(() => {
                            lastItem.classList.remove('carousel-item-wrapper-new');
                        }, 500);
                    }
                });

                // Listen for enable editing
                Livewire.on('enableEditing', (data) => {
                    // Auto-focus first input of the item being edited
                    setTimeout(() => {
                        const items = document.querySelectorAll('.carousel-item-wrapper');
                        if (items[data.index]) {
                            const firstInput = items[data.index].querySelector(
                                'input:not([type="file"]), textarea');
                            if (firstInput) {
                                firstInput.focus();
                            }
                        }
                    }, 100);
                });

                // Listen for editing disabled
                Livewire.on('editingDisabled', () => {
                    // Remove editing highlight from all items
                    document.querySelectorAll('.carousel-item-wrapper .card').forEach(card => {
                        card.classList.remove('border-primary', 'shadow-lg');
                    });
                });
            });

            // Notification system
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

                // Auto remove after 3 seconds
                setTimeout(() => {
                    notification.style.animation = 'slideOutRight 0.5s ease';
                    setTimeout(() => notification.remove(), 500);
                }, 3000);
            }

            // Add animation styles
            const style = document.createElement('style');
            style.textContent = `
            @keyframes slideInRight {
                from {
                    transform: translateX(100%);
                    opacity: 0;
                }
                to {
                    transform: translateX(0);
                    opacity: 1;
                }
            }
            
            @keyframes slideOutRight {
                from {
                    transform: translateX(0);
                    opacity: 1;
                }
                to {
                    transform: translateX(100%);
                    opacity: 0;
                }
            }
        `;
            document.head.appendChild(style);

            // Helper function to preview image (for Livewire temporary URLs)
            document.addEventListener('livewire:update', function() {
                // Livewire automatically handles temporary URLs for file uploads
            });
        </script>
    @endpush
</div>
