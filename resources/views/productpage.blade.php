<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Add Product</h4>
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
                                            Add Product
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- start Basic Area Chart -->
            {{-- resources/views/dashboard/product-create.blade.php --}}
            <div class="container-fluid py-4">

                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3 class="mb-0">Add Product</h3>
                    <div>
                        <button id="saveButton" class="btn btn-primary">Save Product</button>
                        <a href="#" class="btn bg-danger-subtle text-danger ms-2">Cancel</a>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">

                        {{-- Nav tabs --}}
                        <ul class="nav nav-tabs" id="productTabs" role="tablist">
                            <li class="nav-item nav-item-sm" role="presentation">
                                <button class="btn-sm nav-link active nav-button-sm" data-bs-toggle="tab"
                                    data-bs-target="#tab-general" type="button" role="tab">General</button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-media" type="button"
                                    role="tab">Media</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-pricing"
                                    type="button" role="tab">Pricing</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-inventory"
                                    type="button" role="tab">Inventory</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-variants"
                                    type="button" role="tab">Variants</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-associations"
                                    type="button" role="tab">Categories & Tags</button>
                            </li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#howtouse">How to
                                    Use</a></li>
                            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab"
                                    href="#ingredients">Ingredients</a></li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-seo" type="button"
                                    role="tab">SEO</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" data-bs-toggle="tab" data-bs-target="#tab-settings"
                                    type="button" role="tab">Settings</button>
                            </li>
                        </ul>

                        <div class="tab-content pt-4">

                            {{-- GENERAL --}}
                            <div class="tab-pane fade show active" id="tab-general" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label class="form-label">Product Name <span
                                                    class="text-danger">*</span></label>
                                            <input id="productName" type="text" class="form-control"
                                                placeholder="e.g., Wireless Headphones" />
                                            <small class="text-muted d-block mt-1">Make it unique and
                                                descriptive.</small>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Slug</label>
                                            <input id="productSlug" type="text" class="form-control"
                                                placeholder="auto-generated if left blank" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Description</label>
                                            <input id="x-description" type="hidden">
                                            <trix-editor id="trixDescription" input="x-description"></trix-editor>
                                            <small class="text-muted d-block mt-1">Set a detailed description for
                                                better visibility.</small>
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="mb-3">
                                            <label class="form-label">Brand</label>
                                            <select id="brandSelect" class="form-select">
                                                <option value="">— Select Brand —</option>
                                                <option>Acme</option>
                                                <option>Generic</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Status</label>
                                            <select id="statusSelect" class="form-select">
                                                <option value="published">Published</option>
                                                <option value="draft">Draft</option>
                                                <option value="scheduled">Scheduled</option>
                                                <option value="inactive">Inactive</option>
                                            </select>
                                        </div>

                                        <div class="mb-3" id="scheduleContainer" style="display:none;">
                                            <label class="form-label">Schedule Date/Time</label>
                                            <input id="scheduledAt" type="datetime-local" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- MEDIA --}}
                            <div class="tab-pane fade" id="tab-media" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Thumbnail</label>
                                        <input id="thumbnailInput" type="file" accept="image/*"
                                            class="form-control" />
                                        <div class="mt-2">
                                            <img id="thumbnailPreview" src="#" alt="thumb" class="rounded"
                                                style="display:none; max-width:180px;" />
                                        </div>
                                        <small class="text-muted d-block mt-2">Only *.png, *.jpg and *.jpeg files are
                                            accepted.</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Gallery</label>
                                        <input id="galleryInput" type="file" multiple accept="image/*"
                                            class="form-control" />
                                        <div id="galleryPreview" class="d-flex gap-2 flex-wrap mt-2"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- PRICING --}}
                            <div class="tab-pane fade" id="tab-pricing" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Cost Price (Your cost) <span
                                                    class="text-danger">*</span></label>
                                            <input id="costPrice" type="number" step="0.01" class="form-control"
                                                value="0" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Base Price (MRP) <span
                                                    class="text-danger">*</span></label>
                                            <input id="basePrice" type="number" step="0.01" class="form-control"
                                                value="0" />
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Discount</label>
                                            <div class="d-flex gap-2">
                                                <select id="discountType" class="form-select w-auto">
                                                    <option value="none">No Discount</option>
                                                    <option value="percent">Percent %</option>
                                                    <option value="fixed">Fixed</option>
                                                </select>
                                                <input id="discountValue" type="number" step="0.01"
                                                    class="form-control" placeholder="Value" value="0" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="mb-3">
                                            <label class="form-label">Tax Class</label>
                                            <select id="taxClass" class="form-select">
                                                <option value="tax_free">Tax Free</option>
                                                <option value="taxable">Taxable Goods</option>
                                                <option value="digital">Downloadable Products</option>
                                            </select>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">VAT (%)</label>
                                            <input id="vatPercent" type="number" step="0.01"
                                                class="form-control" value="0" />
                                            <small class="text-muted">Applied on discounted price if taxable.</small>
                                        </div>

                                        <div class="p-3 bg-light rounded">
                                            <div class="d-flex justify-content-between">
                                                <span>Effective Selling Price</span>
                                                <strong id="effectivePrice">0.00</strong>
                                            </div>
                                            <div class="d-flex justify-content-between mt-1">
                                                <span>Profit / Unit</span>
                                                <strong id="profitPerUnit">0.00</strong>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- INVENTORY --}}
                            <div class="tab-pane fade" id="tab-inventory" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">SKU</label>
                                        <input id="sku" type="text" class="form-control" />
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Barcode</label>
                                        <input id="barcode" type="text" class="form-control" />
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" id="trackStock" checked>
                                            <label class="form-check-label" for="trackStock">Track Stock</label>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Stock Quantity</label>
                                        <input id="stockQty" type="number" class="form-control" value="0" />
                                    </div>
                                </div>
                            </div>

                            {{-- VARIANTS --}}
                            <div class="tab-pane fade" id="tab-variants" role="tabpanel">
                                <div class="form-check form-switch mb-3">
                                    <input id="hasVariants" class="form-check-input" type="checkbox">
                                    <label class="form-check-label" for="hasVariants">This product has multiple
                                        options (e.g., Size, Color)</label>
                                </div>

                                <div id="variantsArea" style="display:none;">
                                    <div class="row g-3" id="optionsWrapper">
                                        <!-- Option blocks will be appended here -->
                                    </div>

                                    <div class="mt-3">
                                        <button id="addOptionBtn" class="btn bg-primary-subtle text-primary">+ Add
                                            another option</button>
                                        <button id="generateVariantsBtn" class="btn btn-secondary ms-2">Generate
                                            Variants</button>
                                    </div>

                                    <div id="variantsTableWrapper" class="table-responsive mt-4"
                                        style="display:none;">
                                        <table class="table table-bordered align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Variant</th>
                                                    <th>SKU</th>
                                                    <th style="width:120px">Price</th>
                                                    <th style="width:120px">Cost</th>
                                                    <th style="width:100px">Stock</th>
                                                    <th style="width:120px">Color</th>
                                                    <th style="width:180px">Image</th>
                                                    <th style="width:100px">Active</th>
                                                </tr>
                                            </thead>
                                            <tbody id="variantsTableBody"></tbody>

                                        </table>
                                    </div>
                                </div>

                            </div>

                            {{-- CATEGORIES & TAGS --}}
                            <div class="tab-pane fade" id="tab-associations" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Categories</label>
                                        <div class="border rounded p-2" style="max-height:240px; overflow:auto;">
                                            <div><input type="checkbox" value="1"> Computer</div>
                                            <div><input type="checkbox" value="2"> Watches</div>
                                            <div><input type="checkbox" value="3"> Headphones</div>
                                            <div><input type="checkbox" value="4"> Beauty</div>
                                        </div>
                                        <small class="text-muted d-block mt-1">Add product to one or more
                                            categories.</small>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Tags</label>
                                        <div class="border rounded p-2" style="max-height:240px; overflow:auto;">
                                            <div><input type="checkbox" value="1"> New</div>
                                            <div><input type="checkbox" value="2"> trending</div>
                                            <div><input type="checkbox" value="3"> Popular</div>
                                        </div>
                                        <small class="text-muted d-block mt-1">Use tags to improve search &
                                            collections.</small>
                                    </div>
                                </div>
                            </div>
                            <!-- How to Use -->
                            <div class="tab-pane fade" id="howtouse">
                                <div class="mb-3">
                                    <label class="form-label">How to Use</label>
                                    <input id="howToUse" type="hidden" name="howToUse">
                                    <trix-editor input="howToUse"></trix-editor>
                                </div>
                            </div>

                            <!-- Ingredients -->
                            <div class="tab-pane fade" id="ingredients">
                                <div class="mb-3">
                                    <label class="form-label">Ingredients</label>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Ingredient</th>
                                                <th>Percentage (%)</th>
                                                <th>Benefit</th>
                                                <th width="50">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="ingredientTable">
                                            <tr>
                                                <td><input type="text" class="form-control" placeholder="Water">
                                                </td>
                                                <td><input type="number" class="form-control" placeholder="25"></td>
                                                <td><input type="text" class="form-control"
                                                        placeholder="Glowing your skin"></td>
                                                <td><button type="button" class="btn btn-sm btn-danger"
                                                        onclick="removeRow(this)">×</button></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <button type="button" class="btn btn-sm btn-success"
                                        onclick="addIngredientRow()">+ Add Ingredient</button>
                                </div>
                            </div>

                            {{-- SEO --}}
                            <div class="tab-pane fade" id="tab-seo" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        <div class="mb-3">
                                            <label class="form-label">Meta Title</label>
                                            <input id="metaTitle" type="text" class="form-control" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Meta Description</label>
                                            <textarea id="metaDescription" rows="3" class="form-control"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Meta Keywords</label>
                                            <input id="metaKeywords" type="text" class="form-control"
                                                placeholder="keyword1, keyword2" />
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="p-3 bg-light rounded">
                                            <div><strong>SEO completeness</strong></div>
                                            <div class="progress mt-2">
                                                <div id="seoProgress" class="progress-bar" role="progressbar"
                                                    style="width: 0%"></div>
                                            </div>
                                            <small class="text-muted">Fill all fields for best results.</small>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- SETTINGS --}}
                            <div class="tab-pane fade" id="tab-settings" role="tabpanel">
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <label class="form-label">Product Template</label>
                                        <select id="templateSelect" class="form-select">
                                            <option value="default">Default Template</option>
                                            <option value="fashion">Fashion</option>
                                            <option value="office">Office Stationary</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button id="saveBottomBtn" class="btn btn-primary">Save Product</button>
                            <a href="#" class="btn bg-danger-subtle text-danger ms-2">Cancel</a>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Trix styles & script --}}
            <link rel="stylesheet" href="https://unpkg.com/trix@2.0.0/dist/trix.css">
            <script src="https://unpkg.com/trix@2.0.0/dist/trix.umd.min.js"></script>

            <script>
                // Simple frontend logic for the UI (no backend)
                document.addEventListener('DOMContentLoaded', () => {

                    // Schedule field toggle
                    const statusSelect = document.getElementById('statusSelect');
                    const scheduleContainer = document.getElementById('scheduleContainer');
                    statusSelect.addEventListener('change', () => {
                        scheduleContainer.style.display = statusSelect.value === 'scheduled' ? 'block' : 'none';
                    });

                    // Thumbnail preview
                    const thumbnailInput = document.getElementById('thumbnailInput');
                    const thumbnailPreview = document.getElementById('thumbnailPreview');
                    thumbnailInput.addEventListener('change', (e) => {
                        const file = e.target.files[0];
                        if (!file) return;
                        const url = URL.createObjectURL(file);
                        thumbnailPreview.src = url;
                        thumbnailPreview.style.display = 'block';
                    });

                    // Gallery preview
                    const galleryInput = document.getElementById('galleryInput');
                    const galleryPreview = document.getElementById('galleryPreview');
                    galleryInput.addEventListener('change', (e) => {
                        galleryPreview.innerHTML = '';
                        Array.from(e.target.files).forEach(file => {
                            const img = document.createElement('img');
                            img.src = URL.createObjectURL(file);
                            img.style.width = '80px';
                            img.style.height = '80px';
                            img.style.objectFit = 'cover';
                            img.className = 'rounded';
                            galleryPreview.appendChild(img);
                        });
                    });

                    // Pricing calculations
                    const costPrice = document.getElementById('costPrice');
                    const basePrice = document.getElementById('basePrice');
                    const discountType = document.getElementById('discountType');
                    const discountValue = document.getElementById('discountValue');
                    const vatPercent = document.getElementById('vatPercent');
                    const taxClass = document.getElementById('taxClass');
                    const effectivePriceEl = document.getElementById('effectivePrice');
                    const profitEl = document.getElementById('profitPerUnit');

                    function computeEffective() {
                        let price = parseFloat(basePrice.value || 0);
                        const cost = parseFloat(costPrice.value || 0);
                        const dtype = discountType.value;
                        const dvalue = parseFloat(discountValue.value || 0);

                        if (dtype === 'percent') {
                            price = price * Math.max(0, (100 - dvalue)) / 100;
                        } else if (dtype === 'fixed') {
                            price = Math.max(0, price - dvalue);
                        }

                        if (taxClass.value !== 'tax_free') {
                            const vat = parseFloat(vatPercent.value || 0);
                            if (vat > 0) price = price * (1 + vat / 100);
                        }

                        effectivePriceEl.textContent = price.toFixed(2);
                        profitEl.textContent = Math.max(0, price - cost).toFixed(2);
                    }

                    [costPrice, basePrice, discountType, discountValue, vatPercent, taxClass].forEach(el => {
                        el.addEventListener('input', computeEffective);
                        el.addEventListener('change', computeEffective);
                    });
                    computeEffective();

                    // Variants: dynamic options & generator (client-side)
                    const hasVariants = document.getElementById('hasVariants');
                    const variantsArea = document.getElementById('variantsArea');
                    const addOptionBtn = document.getElementById('addOptionBtn');
                    const optionsWrapper = document.getElementById('optionsWrapper');
                    const generateVariantsBtn = document.getElementById('generateVariantsBtn');
                    const variantsTableWrapper = document.getElementById('variantsTableWrapper');
                    const variantsTableBody = document.getElementById('variantsTableBody');

                    function createOptionBlock(index, name = '', values = '') {
                        const col = document.createElement('div');
                        col.className = 'col-md-4';
                        col.innerHTML = `
        <label class="form-label">Option Name</label>
        <input type="text" class="form-control mb-2 opt-name" data-idx="${index}" placeholder="e.g., Size" value="${name}">
        <label class="form-label">Values (comma separated)</label>
        <input type="text" class="form-control opt-values" data-idx="${index}" placeholder="S, M, L" value="${values}">
        <div class="mt-2 d-flex gap-2">
          <button class="btn btn-sm bg-danger-subtle text-danger remove-option">Remove</button>
        </div>
      `;
                        return col;
                    }

                    let optionCount = 0;

                    function addOption(name = '', values = '') {
                        if (optionCount >= 3) return;
                        const block = createOptionBlock(optionCount, name, values);
                        optionsWrapper.appendChild(block);
                        optionCount++;
                        updateOptionRemoveButtons();
                    }

                    function updateOptionRemoveButtons() {
                        optionsWrapper.querySelectorAll('.remove-option').forEach(btn => {
                            btn.onclick = (e) => {
                                e.target.closest('.col-md-4').remove();
                                optionCount--;
                            };
                        });
                    }

                    hasVariants.addEventListener('change', () => {
                        variantsArea.style.display = hasVariants.checked ? 'block' : 'none';
                    });

                    addOptionBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        addOption();
                    });

                    // start with one option block when variants toggled on
                    hasVariants.addEventListener('click', () => {
                        if (hasVariants.checked && optionsWrapper.children.length === 0) addOption('Size',
                            'S, M, L');
                    });

                    // Variant generator: reads option blocks, computes product
                    generateVariantsBtn.addEventListener('click', (e) => {
                        e.preventDefault();
                        // gather options
                        const optNames = [];
                        const optValues = [];
                        optionsWrapper.querySelectorAll('.col-md-4').forEach(col => {
                            const name = (col.querySelector('.opt-name').value || '').trim();
                            const vals = (col.querySelector('.opt-values').value || '').split(',').map(v =>
                                v.trim()).filter(Boolean);
                            if (name && vals.length) {
                                optNames.push(name);
                                optValues.push(vals);
                            }
                        });

                        // if no options -> hide table
                        if (optValues.length === 0) {
                            variantsTableWrapper.style.display = 'none';
                            variantsTableBody.innerHTML = '';
                            return;
                        }

                        // compute cartesian product
                        function cartesian(arr) {
                            return arr.reduce((a, b) => a.flatMap(d => b.map(e => [...d, e])), [
                                []
                            ]);
                        }
                        const combos = cartesian(optValues);

                        // build rows
                        variantsTableBody.innerHTML = '';
                        combos.forEach(parts => {
                            const labelParts = parts.map((v, idx) => `${optNames[idx]}:${v}`);
                            const key = labelParts.join(' | ');
                            const tr = document.createElement('tr');
                            tr.innerHTML = `
  <td>${key}</td>
  <td><input type="text" class="form-control variant-sku" /></td>
  <td><input type="number" step="0.01" class="form-control variant-price" /></td>
  <td><input type="number" step="0.01" class="form-control variant-cost" /></td>
  <td><input type="number" class="form-control variant-stock" value="0" /></td>
  <td>
    <input type="color" class="form-control form-control-color variant-color" value="#000000" />
  </td>
  <td>
    <input type="file" class="form-control variant-image" accept="image/*" />
    <div class="mt-1"><img class="img-thumbnail variant-preview" style="max-height:50px;display:none;"></div>
  </td>
  <td class="text-center">
    <input type="checkbox" class="form-check-input variant-active" checked />
  </td>
`;

                            variantsTableBody.appendChild(tr);
                        });
                        variantsTableWrapper.style.display = 'block';
                        // Preview image when file selected
                        variantsTableBody.addEventListener('change', (e) => {
                            if (e.target.classList.contains('variant-image')) {
                                const fileInput = e.target;
                                const preview = fileInput.parentElement.querySelector('.variant-preview');
                                if (fileInput.files && fileInput.files[0]) {
                                    const reader = new FileReader();
                                    reader.onload = (ev) => {
                                        preview.src = ev.target.result;
                                        preview.style.display = 'block';
                                    };
                                    reader.readAsDataURL(fileInput.files[0]);
                                }
                            }
                        });

                    });

                    // SEO progress
                    const metaTitle = document.getElementById('metaTitle');
                    const metaDescription = document.getElementById('metaDescription');
                    const metaKeywords = document.getElementById('metaKeywords');
                    const seoProgress = document.getElementById('seoProgress');

                    function updateSEOProgress() {
                        let score = 0;
                        if (metaTitle.value.trim()) score += 33;
                        if (metaDescription.value.trim()) score += 33;
                        if (metaKeywords.value.trim()) score += 34;
                        seoProgress.style.width = score + '%';
                        seoProgress.textContent = score + '%';
                    }
                    [metaTitle, metaDescription, metaKeywords].forEach(el => el.addEventListener('input',
                        updateSEOProgress));
                    updateSEOProgress();

                    // Auto-slugger
                    const productName = document.getElementById('productName');
                    const productSlug = document.getElementById('productSlug');
                    productName.addEventListener('input', () => {
                        if (!productSlug.value) {
                            productSlug.value = productName.value.trim().toLowerCase().replace(/[^a-z0-9]+/g, '-')
                                .replace(/(^-|-$)/g, '');
                        }
                    });

                    // Trix change -> copy into hidden
                    const trixEditor = document.getElementById('trixDescription');
                    if (trixEditor) {
                        trixEditor.addEventListener('trix-change', () => {
                            document.getElementById('x-description').value = trixEditor.innerHTML;
                        });
                    }

                    // Save button (client-side collect)
                    function collectForm() {
                        const data = {
                            name: productName.value,
                            slug: productSlug.value,
                            description: document.getElementById('x-description').value,
                            brand: document.getElementById('brandSelect').value,
                            status: document.getElementById('statusSelect').value,
                            scheduled_at: document.getElementById('scheduledAt').value,
                            pricing: {
                                cost: parseFloat(costPrice.value || 0),
                                base: parseFloat(basePrice.value || 0),
                                discountType: discountType.value,
                                discountValue: parseFloat(discountValue.value || 0),
                                vat: parseFloat(vatPercent.value || 0),
                                taxClass: taxClass.value,
                            },
                            inventory: {
                                sku: document.getElementById('sku').value,
                                barcode: document.getElementById('barcode').value,
                                stock: parseInt(document.getElementById('stockQty').value || 0),
                                track_stock: document.getElementById('trackStock').checked
                            },
                            seo: {
                                title: metaTitle.value,
                                description: metaDescription.value,
                                keywords: metaKeywords.value
                            }
                        };

                        // collect options
                        data.options = [];
                        optionsWrapper.querySelectorAll('.col-md-4').forEach(col => {
                            data.options.push({
                                name: col.querySelector('.opt-name').value,
                                values: col.querySelector('.opt-values').value.split(',').map(v => v.trim())
                                    .filter(Boolean)
                            });
                        });

                        // collect variants table values
                        data.variants = [];
                        variantsTableBody.querySelectorAll('tr').forEach(tr => {
                            data.variants.push({
                                key: tr.cells[0].textContent.trim(),
                                sku: tr.querySelector('.variant-sku').value,
                                price: parseFloat(tr.querySelector('.variant-price').value || 0),
                                cost_price: parseFloat(tr.querySelector('.variant-cost').value || 0),
                                stock: parseInt(tr.querySelector('.variant-stock').value || 0)
                            });
                        });

                        return data;
                    }

                    function showCollectedPreview() {
                        const payload = collectForm();
                        // for demo we print to console. Replace with actual ajax/livewire call later.
                        console.log('PRODUCT PAYLOAD (frontend only):', payload);
                        alert('Check console: product payload collected (frontend only).');
                    }

                    document.getElementById('saveButton').addEventListener('click', showCollectedPreview);
                    document.getElementById('saveBottomBtn').addEventListener('click', showCollectedPreview);

                    // initialize with 1 option block (hidden until variants on)
                    addOption('Size', 'S, M, L');

                });

                function addIngredientRow() {
                    const table = document.getElementById('ingredientTable');
                    const row = document.createElement('tr');
                    row.innerHTML = `
      <td><input type="text" class="form-control" placeholder="Ingredient name"></td>
      <td><input type="number" class="form-control" placeholder="%"></td>
      <td><input type="text" class="form-control" placeholder="Benefit"></td>
      <td><button type="button" class="btn btn-sm btn-danger" onclick="removeRow(this)">×</button></td>
    `;
                    table.appendChild(row);
                }

                function removeRow(btn) {
                    btn.closest('tr').remove();
                }
            </script>

            <style>
                /* small visual tweaks */
                .trix-content {
                    min-height: 180px;
                    border: 1px solid #e9ecef;
                    border-radius: .375rem;
                    padding: .5rem;
                }

                .bg-primary-subtle {
                    background-color: rgba(13, 110, 253, 0.06);
                }

                .bg-danger-subtle {
                    background-color: rgba(220, 53, 69, 0.06);
                }
            </style>

            <!-- end Basic Area Chart -->
        </div>
    </div>
</div>
