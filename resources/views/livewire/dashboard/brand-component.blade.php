<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Brands Overview</h4>
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
                                            Brands
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card w-100 position-relative overflow-hidden">
                <div class="px-4 py-3 border-bottom d-flex justify-content-between">
                    <h4 class="card-title mb-0">Brands Table</h4>
                    <button class="btn-primary btn badge text-bg-primary" data-bs-toggle="modal"
                        data-bs-target="#brand-modal">Add Brand</button>
                </div>

                <div class="card-body p-4">

                    <div class="table-responsive mb-4 border rounded-1">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Brands logo</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Brand Name</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">No.Products</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                                    </th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($brands as $item)
                                    <tr>
                                        <td>
                                            <img src="{{ $item->logo ?? '/default-image.png' }}"
                                                class="rounded-circle" width="40" height="40" />
                                        </td>
                                        <td>
                                            <strong>{{ $item->name }}</strong><br>
                                            <small class="text-muted">{{ $item->slug }}</small>
                                        </td>
                                        <td>{{ $item->description }}</td>
                                        <td>
                                            <span wire:click="toggle({{ $item->id }})"
                                                class="badge {{ $item->status === 'active' ? 'bg-success-subtle text-success' : 'bg-danger-subtle text-danger' }}">
                                                {{ ucfirst($item->status) }}
                                            </span>
                                        </td>
                                        <td>{{ $item->created_at->format('d M, Y') }}</td>
                                        {{-- <td>{{ $item->updated_at->diffForHumans() }}</td> --}}
                                        <td>
                                            <div class="dropdown dropstart">
                                                <a href="#" class="text-muted" data-bs-toggle="dropdown">
                                                    <i class="ti ti-dots fs-5"></i>
                                                </a>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a wire:click.prevent="edit({{ $item->id }})"
                                                            class="dropdown-item">
                                                            <i class="ti ti-edit me-2"></i>Edit
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a wire:click.prevent="delete({{ $item->id }})"
                                                            class="dropdown-item">
                                                            <i class="ti ti-trash me-2"></i>Delete
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">🚫 No Brands Found</td>
                                    </tr>
                                @endforelse
                            </tbody>

                        </table>
                    </div>


                </div>
            </div>
        </div>
    </div>
    {{-- modal --}}
    <div id="brand-modal" class="modal fade" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <!-- Modal Header -->
                    <div class="text-center mt-2 mb-4">
                        <a href="javascript:void(0)" class="text-success">
                            <span>
                                <img src="{{ asset('assets/images/logos/favicon.png') }}" class="me-3 img-fluid"
                                    alt="brand-logo">
                            </span>
                        </a>
                    </div>

                    <!-- Brand Form -->
                    <form class="ps-3 pe-3" wire:submit.prevent="{{ $brandId ? 'update' : 'store' }}">

                        <!-- Brand Name -->
                        <div class="mb-3">
                            <label for="brandName" class="form-label">Brand Name <span
                                    class="text-danger">*</span></label>
                            <input type="text" id="brandName"
                                class="form-control @error('name') is-invalid @enderror" wire:model.defer="name"
                                placeholder="Enter brand name">
                            @error('name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label for="brandDescription" class="form-label">Description <span
                                    class="text-danger">*</span></label>
                            <textarea id="brandDescription" class="form-control @error('description') is-invalid @enderror"
                                wire:model.defer="description" rows="4" placeholder="Write a short description..."></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Brand Logo -->
                        <div class="mb-3">
                            <label for="brandLogo" class="form-label">Brand Logo</label>
                            <input type="file" id="brandLogo"
                                class="form-control @error('logo') is-invalid @enderror" wire:model="logo"
                                accept="image/*">
                            @error('logo')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror

                            <!-- Preview existing or uploaded logo -->
                            @if ($logo)
                                <div class="mt-2">
                                    <img src="{{ is_string($logo) ? $logo : $logo->temporaryUrl() }}"
                                        class="rounded-circle border" width="60" height="60"
                                        alt="Brand Logo Preview">
                                </div>
                            @endif
                        </div>

                        <!-- SEO Section -->
                        <div class="text-center mb-3">
                            <h5 class="fw-semibold">SEO Related Fields (Optional)</h5>
                        </div>

                        <!-- Meta Title -->
                        <div class="mb-3">
                            <label for="metaTitle" class="form-label">Meta Title</label>
                            <input type="text" id="metaTitle"
                                class="form-control @error('metaTitle') is-invalid @enderror"
                                wire:model.defer="metaTitle" placeholder="Enter meta title (for SEO)">
                            @error('metaTitle')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Meta Description -->
                        <div class="mb-3">
                            <label for="metaDescription" class="form-label">Meta Description</label>
                            <textarea id="metaDescription" class="form-control @error('metaDescription') is-invalid @enderror"
                                wire:model.defer="metaDescription" rows="3" placeholder="Enter meta description (for SEO)"></textarea>
                            @error('metaDescription')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Meta Keywords -->
                        <div class="mb-3">
                            <label for="metaKeywords" class="form-label">Meta Keywords</label>
                            <input type="text" id="metaKeywords"
                                class="form-control @error('metaKeywords') is-invalid @enderror"
                                wire:model.defer="metaKeywords" placeholder="Enter keywords, separated by commas">
                            @error('metaKeywords')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="text-center">
                            <button type="submit" class="btn bg-info-subtle text-info">
                                {{ $buttonText }}
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
