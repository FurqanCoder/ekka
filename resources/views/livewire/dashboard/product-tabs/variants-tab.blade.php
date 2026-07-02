<div>
    @if ($hasVariants)
        <div class="row g-3">
            @foreach ($options as $index => $option)
                <div class="col-md-4 mb-3">
                    <div class="border rounded p-3 shadow-sm h-100">
                        {{-- Option Dropdown --}}
                        <label class="form-label fw-semibold">Option</label>
                        <select class="form-select mb-3" wire:model="options.{{ $index }}.option_id"
                            wire:change="refreshMe">
                            <option value="">-- Select Option --</option>
                            @foreach ($allOptions as $opt)
                                <option value="{{ $opt['id'] }}">{{ $opt['name'] }}</option>
                            @endforeach
                        </select>

                        {{-- Values --}}
                        @if (!empty($option['option_id']))
                            <label class="form-label fw-semibold">Values</label>
                            <div class="d-flex flex-column gap-2">
                                @foreach ($allValues[$option['option_id']] ?? [] as $val)
                                    <div class="d-flex align-items-center justify-content-between p-2 rounded bg-light">
                                        <div class="form-check m-0">
                                            <input type="checkbox" value="{{ $val['id'] }}"
                                                class="form-check-input me-2"
                                                wire:model.defer="options.{{ $index }}.values"
                                                id="optionVal{{ $index }}{{ $val['id'] }}">
                                            <label class="form-check-label"
                                                for="optionVal{{ $index }}{{ $val['id'] }}">
                                                {{ $val['value'] }}
                                            </label>
                                        </div>

                                        @if ($val['color_code'])
                                            <span class="rounded-circle border"
                                                style="width: 24px; height: 24px; background-color: {{ $val['color_code'] }};">
                                            </span>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        {{-- Remove Button --}}
                        <button type="button" wire:click="removeOption({{ $index }})"
                            class="btn btn-sm btn-danger mt-3 w-100">
                            Remove Option
                        </button>
                    </div>
                </div>
            @endforeach

        </div>

        <div class="mt-3">
            <button type="button" wire:click="addOption" class="btn btn-outline-primary">
                + Add another option
            </button>
            <button type="button" wire:click="generateVariants" class="btn btn-secondary ms-2">
                Generate Variants
            </button>
        </div>

        @if ($variants)
            <div class="table-responsive mt-4">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>Variant</th>
                            <th>SKU</th>
                            <th>Price</th>
                            <th>Cost</th>
                            <th>Stock</th>
                            {{-- <th>Color</th> --}}
                            <th>Image</th>
                            <th>Active</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($variants as $i => $variant)
                            <tr>
                                <td>{{ $variant['label'] }}</td>
                                <td><input type="text" class="form-control"
                                        wire:model="variants.{{ $i }}.sku"></td>
                                <td><input type="number" class="form-control"
                                        wire:model="variants.{{ $i }}.price"></td>
                                <td><input type="number" class="form-control"
                                        wire:model="variants.{{ $i }}.cost"></td>
                                <td><input type="number" class="form-control"
                                        wire:model="variants.{{ $i }}.stock"></td>
                                {{-- <td><input type="color" class="form-control form-control-color"
                                        wire:model="variants.{{ $i }}.color_code"></td> --}}
                                <td>
                                    {{-- file input --}}
                                    <input type="file" wire:model="variants.{{ $i }}.image"
                                        class="form-control">

                                    {{-- uploading indicator --}}
                                    <div wire:loading wire:target="variants.{{ $i }}.image"
                                        class="text-info small mt-1">
                                        Uploading...
                                    </div>

                                    {{-- TEMPORARY PREVIEW (before save) --}}
                                    @if (isset($variant['image']) &&
                                            is_object($variant['image']) &&
                                            $variant['image'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile)
                                        <div class="mt-2">
                                            <img src="{{ $variant['image']->temporaryUrl() }}" alt="Preview"
                                                class="img-thumbnail" style="max-height:80px;">
                                            <div class="mt-2">
                                                <button type="button"
                                                    wire:click.prevent="removeVariantImage({{ $i }})"
                                                    class="btn btn-sm btn-outline-danger">
                                                    x
                                                </button>
                                            </div>
                                        </div>

                                        {{-- SAVED IMAGE (string URL) --}}
                                    @elseif (isset($variant['image']) && is_string($variant['image']))
                                        <div class="mt-2">
                                            <img src="{{ $variant['image'] }}" alt="Variant Image"
                                                class="img-thumbnail" style="max-height:80px;">
                                            <div class="mt-2 d-flex gap-2">
                                                <button type="button"
                                                    wire:click.prevent="removeVariantImage({{ $i }})"
                                                    wire:loading.attr="disabled" class="btn btn-sm btn-danger">
                                                    x
                                                </button>

                                                {{-- Optionally let user re-upload (file input above handles that) --}}
                                            </div>
                                        </div>
                                    @endif
                                </td>



                                <td><input type="checkbox" wire:model="variants.{{ $i }}.active"></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <button type="button" class="btn btn-sm btn-primary float-right mb-3" wire:click="saveVariants"
                style="float: right;">Save Variants</button>

        @endif
    @endif
</div>
