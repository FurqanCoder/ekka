<div class="body-wrapper">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 mb-4">
            <div>
                <h3 class="fw-bold mb-1">Shipping Management</h3>
                <p class="text-muted mb-0">Define delivery zones, shipping methods, and fulfillment rules.</p>
            </div>
        </div>

        @if (session()->has('success'))
            <div class="alert alert-success rounded-3 border-0 mb-4">{{ session('success') }}</div>
        @endif

        <div class="row g-4 mb-4">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-1">Zones</p>
                        <h4 class="fw-bold mb-0">{{ $zones->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-1">Methods</p>
                        <h4 class="fw-bold mb-0">{{ $methods->count() }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <p class="text-muted small mb-1">Coverage</p>
                        <h4 class="fw-bold mb-0">{{ $zones->whereNotNull('regions')->count() }} regions</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Shipping Zones</h5>
                        <form wire:submit.prevent="saveZone">
                            <div class="mb-3">
                                <label class="form-label">Zone Name</label>
                                <input type="text" wire:model="zoneName" class="form-control" placeholder="National / International">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Regions</label>
                                <input type="text" wire:model="regions" class="form-control" placeholder="Karachi, Lahore, Islamabad">
                            </div>
                            <button class="btn btn-primary">Save Zone</button>
                        </form>

                        <div class="table-responsive mt-4">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-muted">Name</th>
                                        <th class="text-muted">Regions</th>
                                        <th class="text-muted text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($zones as $zone)
                                        <tr>
                                            <td>{{ $zone->name }}</td>
                                            <td>{{ is_array($zone->regions) ? implode(', ', $zone->regions) : '—' }}</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary" wire:click="editZone({{ $zone->id }})">Edit</button>
                                                <button class="btn btn-sm btn-outline-danger" wire:click="deleteZone({{ $zone->id }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body">
                        <h5 class="fw-semibold mb-3">Shipping Methods</h5>
                        <form wire:submit.prevent="saveMethod">
                            <div class="mb-3">
                                <label class="form-label">Method Name</label>
                                <input type="text" wire:model="methodName" class="form-control" placeholder="Standard Delivery">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Type</label>
                                <select wire:model="type" class="form-select">
                                    <option value="flat_rate">Flat Rate</option>
                                    <option value="free">Free</option>
                                    <option value="courier_api">Courier API</option>
                                </select>
                            </div>
                            @if ($type === 'flat_rate')
                                <div class="mb-3">
                                    <label class="form-label">Cost</label>
                                    <input type="number" wire:model="cost" class="form-control" step="0.01">
                                </div>
                            @endif
                            <div class="mb-3">
                                <label class="form-label">Estimated Days</label>
                                <input type="text" wire:model="estimated_days" class="form-control" placeholder="2-4 days">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Shipping Zone</label>
                                <select wire:model="zone_id" class="form-select">
                                    <option value="">All Zones</option>
                                    @foreach ($zones as $zone)
                                        <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button class="btn btn-primary">Save Method</button>
                        </form>

                        <div class="table-responsive mt-4">
                            <table class="table align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="text-muted">Name</th>
                                        <th class="text-muted">Type</th>
                                        <th class="text-muted">Cost</th>
                                        <th class="text-muted">Zone</th>
                                        <th class="text-muted text-end">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($methods as $method)
                                        <tr>
                                            <td>{{ $method->name }}</td>
                                            <td>{{ ucfirst($method->type) }}</td>
                                            <td>{{ $method->type === 'free' ? 'Free' : number_format($method->cost, 2) }}</td>
                                            <td>{{ $method->zone?->name ?? 'All' }}</td>
                                            <td class="text-end">
                                                <button class="btn btn-sm btn-outline-primary" wire:click="editMethod({{ $method->id }})">Edit</button>
                                                <button class="btn btn-sm btn-outline-danger" wire:click="deleteMethod({{ $method->id }})">Delete</button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
