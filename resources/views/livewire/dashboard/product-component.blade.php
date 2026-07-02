<div class="body-wrapper">
    <div class="container-fluid">

        {{-- Header + Breadcrumb --}}
        <div class="card card-body py-3">
            <div class="row align-items-center">
                <div class="col-12">
                    <div class="d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-4 mb-sm-0 card-title">Products List</h4>
                        <nav aria-label="breadcrumb" class="ms-auto">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item d-flex align-items-center">
                                    <a class="text-muted text-decoration-none d-flex" href="">
                                        <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                    </a>
                                </li>
                                <li class="breadcrumb-item" aria-current="page">
                                    <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">Products</span>
                                </li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        {{-- Product Table --}}
        <div class="product-list mt-4">
            <div class="card">
                <div class="card-body p-3">

                    {{-- Search + Filter --}}
                    <div class="d-flex justify-content-between align-items-center gap-6 mb-4">
                        <form class="position-relative w-50">
                            <input type="text" wire:model.live="search" class="form-control search-chat py-2 ps-5"
                                placeholder="Search Product by name or SKU">
                            <i
                                class="ti ti-search position-absolute top-50 start-0 translate-middle-y fs-6 text-dark ms-3"></i>
                        </form>

                        <div class="d-flex gap-3">
                            <select wire:model="statusFilter" class="form-select w-auto">
                                <option value="all">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                            <a href="{{ route('dev-add-product') }}" class="btn btn-primary">+ Add Product</a>
                        </div>
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive border rounded">
                        <table class="table align-middle text-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" />
                                        </div>
                                    </th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Category</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Stock</th>
                                    <th scope="col">Variants</th>
                                    <th scope="col">Sold</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr>
                                        <td>
                                            <div class="form-check mb-0">
                                                <input class="form-check-input" type="checkbox" />
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="{{ optional($product->media->where('is_thumbnail', true)->first())->file_path ?? 'default.png' }}"
                                                    class="rounded-circle" alt="product-img" width="56"
                                                    height="56" />
                                                <div class="ms-3">
                                                    <h6 class="fw-semibold mb-0 fs-4">{{ $product->name }}</h6>
                                                    <p class="mb-0 text-muted">{{ $product->sku }}</p>
                                                </div>
                                            </div>
                                        </td>
                                        <td><span
                                                class="badge bg-secondary">{{ $product->categories->where('parent_id', '')->first()->name ?? '—' }}</span>
                                        </td>
                                        <td>{{ $product->created_at->format('d M Y') }}</td>
                                        <td>
                                            @if ($product->variants->count() > 0)
                                                <h6 class="mb-0 fs-4">
                                                    From ${{ number_format($product->variants->min('price'), 2) }} to
                                                    {{ number_format($product->variants->max('price'), 2) }}
                                                </h6>
                                            @else
                                                <h6 class="mb-0 fs-4">${{ number_format($product->prices->final_price, 2) }}</h6>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $product->variants->count() > 0 ? $product->variants->sum('stock') : $product->stock }}
                                        </td>
                                        <td>
                                            @if ($product->variants->count() > 0)
                                                <span class="badge bg-info">{{ $product->variants->count() }}</span>
                                            @else
                                                <span class="badge bg-secondary">No</span>
                                            @endif
                                        </td>
                                        <td>{{ $product->solds ?? 0 }}</td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                {{-- @if (($product->variants->sum('stock') ?? $product->stock) > 0) --}}
                                                    <span class="text-bg-success p-1 rounded-circle"></span>
                                                    <p class="mb-0 ms-2">{{$product->status}}</p>
                                                {{-- @else --}}
                                                    {{-- <span class="text-bg-danger p-1 rounded-circle"></span>
                                                    <p class="mb-0 ms-2">Out of Stock</p>
                                                @endif --}}
                                            </div>
                                        </td>
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="javascript:void(0)" class="text-muted" id="dropdownMenuButton"
                                                    data-bs-toggle="dropdown" aria-expanded="false">
                                                    <iconify-icon icon="mdi:dots-vertical" class="fs-6"></iconify-icon>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                    <li>
                                                        <a class="dropdown-item d-flex align-items-center gap-3"
                                                            href="javascript:void(0) ">
                                                            <iconify-icon icon="mdi:eye-outline" class="fs-5 btn btn-sm btn-info"></iconify-icon> View
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            class="dropdown-item d-flex align-items-center gap-3 "
                                                            href="{{route('dev-edit-product', $product->id)}}">
                                                            <iconify-icon icon="solar:pen-new-square-linear" class="fs-5 btn btn-sm btn-warning"></iconify-icon>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a
                                                            class="dropdown-item d-flex align-items-center gap-3"
                                                            wire:click="deleteProduct({{ $product->id }})" onclick="return confirm('Delete this product?')">
                                                            <iconify-icon icon="mdi:delete-outline" class="fs-5 fs-5 btn btn-sm btn-danger"></iconify-icon>Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center">No products found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>

                        {{-- Pagination --}}
                        <div class="d-flex align-items-center justify-content-between p-2">
                            <div>
                                Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of
                                {{ $products->total() }}
                            </div>
                            <div>
                                {{ $products->links() }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
