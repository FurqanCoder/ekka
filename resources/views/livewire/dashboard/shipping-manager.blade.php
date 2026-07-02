<div class="body-wrapper">
    <div class="container-fluid">
    <h4 class="mb-4">📦 Shipping Zones & Methods</h4>

    @if (session()->has('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        <!-- Zones -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Shipping Zones</div>
                <div class="card-body">
                    <form wire:submit.prevent="saveZone">
                        <div class="mb-2">
                            <label>Zone Name</label>
                            <input type="text" wire:model="zoneName" class="form-control">
                        </div>
                        <div class="mb-2">
                            <label>Regions (comma separated)</label>
                            <input type="text" wire:model="regions" placeholder="e.g. Karachi,Lahore" class="form-control">
                        </div>
                        <button class="btn btn-primary">Save Zone</button>
                    </form>

                    <hr>

                    <table class="table mt-3">
                        <thead>
                            <tr><th>Name</th><th>Regions</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($zones as $zone)
                                <tr>
                                    <td>{{ $zone->name }}</td>
                                    <td>{{ implode(', ', (array)$zone->regions) }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" wire:click="editZone({{ $zone->id }})">Edit</button>
                                        <button class="btn btn-sm btn-danger" wire:click="deleteZone({{ $zone->id }})">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Methods -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header">Shipping Methods</div>
                <div class="card-body">
                    <form wire:submit.prevent="saveMethod">
                        <div class="mb-2">
                            <label>Method Name</label>
                            <input type="text" wire:model="methodName" class="form-control" placeholder="Standard Delivery">
                        </div>
                        <div class="mb-2">
                            <label>Type</label>
                            <select wire:model="type" class="form-control">
                                <option value="flat_rate">Flat Rate</option>
                                <option value="free">Free</option>
                                <option value="courier_api">Courier API</option>
                            </select>
                        </div>
                        @if ($type === 'flat_rate')
                            <div class="mb-2">
                                <label>Cost</label>
                                <input type="number" wire:model="cost" class="form-control" step="0.01">
                            </div>
                        @endif
                        <div class="mb-2">
                            <label>Estimated Days</label>
                            <input type="text" wire:model="estimated_days" class="form-control" placeholder="e.g. 2-4 days">
                        </div>
                        <div class="mb-2">
                            <label>Shipping Zone</label>
                            <select wire:model="zone_id" class="form-control">
                                <option value="">All Zones</option>
                                @foreach ($zones as $zone)
                                    <option value="{{ $zone->id }}">{{ $zone->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary">Save Method</button>
                    </form>

                    <hr>

                    <table class="table mt-3">
                        <thead>
                            <tr><th>Name</th><th>Type</th><th>Cost</th><th>Zone</th><th>Action</th></tr>
                        </thead>
                        <tbody>
                            @foreach ($methods as $method)
                                <tr>
                                    <td>{{ $method->name }}</td>
                                    <td>{{ ucfirst($method->type) }}</td>
                                    <td>{{ $method->type === 'free' ? 'Free' : number_format($method->cost, 2) }}</td>
                                    <td>{{ $method->zone?->name ?? 'All' }}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning" wire:click="editMethod({{ $method->id }})">Edit</button>
                                        <button class="btn btn-sm btn-danger" wire:click="deleteMethod({{ $method->id }})">Delete</button>
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
