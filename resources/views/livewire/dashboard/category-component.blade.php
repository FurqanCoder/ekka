<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Categories Overview</h4>
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
                                            Categories
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
                    <h4 class="card-title mb-0 btn" wire:click="open()">Categories Table</h4>
                    <button class="btn-primary btn badge text-bg-primary" data-bs-toggle="modal"
                        data-bs-target="#category-modal">Add Category</button>
                </div>

                <div class="card-body p-4">

                    <div class="table-responsive mb-4 border rounded-1">
                        <table class="table text-nowrap mb-0 align-middle">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Name</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Sub Catgories</h6>
                                    </th>
                                    <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Status</h6>
                                    </th>
                                    {{-- <th>
                                        <h6 class="fs-4 fw-semibold mb-0">Teams</h6>
                                    </th> --}}
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($categories && $categories->count() > 0)
                                    @foreach ($categories as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    @if ($item->image)
                                                        <img src="{{ str_replace('/upload/', '/upload/w_40,h_40,c_fill,g_face,r_max/', $item->image) }}"
                                                            class="rounded-circle" width="40" height="40" />
                                                    @else
                                                        <img src="/default-image.png" class="rounded-circle"
                                                            width="40" height="40" />
                                                    @endif

                                                    <div class="ms-3">
                                                        <h6 class="fs-4 fw-semibold mb-0">{{ $item->name }}</h6>
                                                        @if ($item->children_count > 0)
                                                            <span class="fw-normal">No Of Sub:
                                                                {{ $item->children_count }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>


                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    @if ($item->children_count > 0)
                                                        @foreach ($item->children as $child)
                                                            <span
                                                                class="badge text-bg-secondary">{{ $child->name }}</span>
                                                        @endforeach
                                                    @else
                                                        <span>No Children</span>
                                                    @endif

                                                </div>
                                            </td>
                                            <td>
                                                <button wire:click="toggle({{ $item->id }})"
                                                    class="btn badge bg-success-subtle text-success fw-semibold fs-2 gap-1 d-inline-flex align-items-center">
                                                    <i class="ti ti-control-play fs-3"></i>{{ $item->status }}
                                                </button>
                                            </td>
                                            <td>
                                                <div class="dropdown dropstart">
                                                    <a href="javascript:void(0)" class="text-muted"
                                                        id="dropdownMenuButton" data-bs-toggle="dropdown"
                                                        aria-expanded="false">
                                                        <i class="ti ti-dots fs-5"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                        <li>
                                                            <a class="dropdown-item d-flex align-items-center gap-3"
                                                                href="javascript:void(0)">
                                                                <i class="fs-4 ti ti-plus"></i>Add
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a wire:click.prevent="edit({{ $item->id }})"
                                                                class="dropdown-item d-flex align-items-center gap-3"
                                                                href="javascript:void(0)">
                                                                <i class="fs-4 ti ti-edit"></i>Edit
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a wire:click.prevent="delete({{ $item->id }})"
                                                                class="dropdown-item d-flex align-items-center gap-3"
                                                                href="javascript:void(0)">
                                                                <i class="fs-4 ti ti-trash"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <p>No data found</p>
                                @endif

                            </tbody>
                        </table>
                    </div>


                </div>
            </div>
        </div>

    </div>
    {{-- modal --}}

    <div id="category-modal" class="modal fade" tabindex="-1" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-scrollable modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="text-center mt-2 mb-4">
                        <a href="index.html" class="text-success">
                            <span>
                                <img src="{{ asset('assets/images/logos/favicon.png') }}" class="me-3 img-fluid"
                                    alt="matdash-img">
                            </span>
                        </a>
                    </div>

                    <form class="ps-3 pr-3" wire:submit.prevent="addCategory">
                        <div class="mb-3">
                            <label for="categoryName">Category Name</label>
                            <input class="form-control @error('categoryName') is-invalid @enderror"
                                wire:model.defer="categoryName" type="text" id="categoryName" required>
                            @error('categoryName')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" wire:model.defer="description"
                                id="description" rows="5"></textarea>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="parent">Parent (Optional)</label>
                            <select class="form-select @error('parent') is-invalid @enderror"
                                wire:model.defer="parent" id="parent">
                                <option value="" selected>Choose Parent Category</option>
                                @foreach ($categories as $cate)
                                    <option value="{{ $cate->id }}">{{ $cate->name }}</option>
                                @endforeach
                            </select>
                            @error('parent')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image">Category Image</label>
                            <input type="file" wire:model="image"
                                class="form-control @error('image') is-invalid @enderror" id="image"
                                accept="image/*">
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                            @if ($image)
                                <div class="mt-2">
                                    <img src="{{ is_string($image) ? $image : $image->temporaryUrl() }}"
                                        class="rounded-circle border" width="60" height="60"
                                        alt="Brand Logo Preview">
                                </div>
                            @endif
                        </div>
                        <hr>
                        <center>
                            <h5>Seo Related Fileds (Optional)</h5>
                        </center>
                        <div class="mb-3">
                            <label for="MetaTitle">Meta-Title</label>
                            <input class="form-control @error('metaTitle') is-invalid @enderror"
                                wire:model.defer="metaTitle" type="text" id="metaTitle" required>
                            @error('metaTitle')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="Meta-Description">Meta-Description</label>
                            <textarea class="form-control @error('metaDescription') is-invalid @enderror" wire:model.defer="metaDescription"
                                id="metaDescription" rows="5"></textarea>
                            @error('metaDescription')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3 text-center">
                            <button class="btn bg-info-subtle text-info" type="submit">
                                {{ $button }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    </script>
</div>
