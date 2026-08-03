<div>
    <!-- Category Sidebar start -->
    <div class="ec-side-cat-overlay"></div>
    <div class="col-lg-3 category-sidebar" data-animation="fadeIn">
        <div class="cat-sidebar">
            <div class="cat-sidebar-box">
                <div class="ec-sidebar-wrap">
                    <!-- Sidebar Category Block -->
                    <div class="ec-sidebar-block">
                        <div class="ec-sb-title">
                            <h3 class="ec-sidebar-title">
                                Categories
                                <button class="ec-close">×</button>
                            </h3>
                        </div>

                        @forelse($categories as $category)
                            <div class="ec-sb-block-content">
                                <ul>
                                    <li>
                                        <div class="ec-sidebar-block-item" 
                                             wire:click="selectCategory({{ $category['id'] }})"
                                             style="cursor: pointer;">
                                            @if($category['image'])
                                                <img src="{{ $category['image'] }}" 
                                                     class="svg_img" 
                                                     alt="{{ $category['name'] }}"
                                                     style="width: 24px; height: 24px; object-fit: contain;">
                                            @else
                                                <img src="{{ asset('web/images/icons/default-category.png') }}" 
                                                     class="svg_img" 
                                                     alt="{{ $category['name'] }}"
                                                     style="width: 24px; height: 24px; object-fit: contain;">
                                            @endif
                                            {{ $category['name'] }}
                                            {{-- <span class="badge bg-secondary float-end">
                                                {{ count($category['children']) }}
                                            </span> --}}
                                        </div>
                                        
                                        @if(count($category['children']) > 0)
                                            <ul style="display: block;">
                                                @foreach($category['children'] as $child)
                                                    <li>
                                                        <div class="ec-sidebar-sub-item">
                                                            <a href="" 
                                                               wire:click="selectCategory({{ $child['id'] }})">
                                                                {{ $child['name'] }}
                                                                @if(isset($child['product_count']) && $child['product_count'] > 0)
                                                                    <span title="Available Products">
                                                                        - {{ $child['product_count'] }}
                                                                    </span>
                                                                @endif
                                                            </a>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        @empty
                            <div class="ec-sb-block-content">
                                <div class="alert alert-info">
                                    No categories found.
                                </div>
                            </div>
                        @endforelse
                    </div>
                    <!-- Sidebar Category Block -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .ec-sidebar-block-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 0;
        font-weight: 500;
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .ec-sidebar-block-item:hover {
        color: #ff6b6b;
        padding-left: 5px;
    }
    
    .ec-sidebar-block-item .svg_img {
        width: 24px;
        height: 24px;
        object-fit: contain;
    }
    
    .ec-sidebar-sub-item {
        padding: 5px 0 5px 25px;
        transition: all 0.3s ease;
    }
    
    .ec-sidebar-sub-item:hover {
        padding-left: 30px;
    }
    
    .ec-sidebar-sub-item a {
        color: #333;
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .ec-sidebar-sub-item a:hover {
        color: #ff6b6b;
    }
    
    .ec-sidebar-sub-item span {
        font-size: 12px;
        color: #999;
    }
    
    /* Active category styling */
    .ec-sidebar-block-item.active {
        color: #ff6b6b;
        background: #fff5f5;
        padding: 10px 15px;
        border-radius: 5px;
    }
    
    /* Loading skeleton */
    .category-skeleton {
        animation: shimmer 1.5s infinite;
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        height: 30px;
        margin: 5px 0;
        border-radius: 4px;
    }
    
    @keyframes shimmer {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', function () {
        // Listen for category selection
        Livewire.on('categorySelected', ({ categoryId }) => {
            console.log('Category selected:', categoryId);
            
            // Highlight selected category
            document.querySelectorAll('.ec-sidebar-block-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // You can add highlight logic here if needed
        });
    });
</script>
@endpush