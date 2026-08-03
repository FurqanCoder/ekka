<div>
    <div class="body-wrapper">
        <div class="container-fluid">
            <!-- Header -->
            <div class="card card-body py-3">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="d-sm-flex align-items-center justify-space-between">
                            <h4 class="mb-4 mb-sm-0 card-title">Website Settings</h4>
                            <nav aria-label="breadcrumb" class="ms-auto">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item d-flex align-items-center">
                                        <a class="text-muted text-decoration-none d-flex" href="#">
                                            <iconify-icon icon="solar:home-2-line-duotone" class="fs-6"></iconify-icon>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item" aria-current="page">
                                        <span class="badge fw-medium fs-2 bg-primary-subtle text-primary">
                                            Settings
                                        </span>
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <ul class="nav nav-tabs mb-4" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'general' ? 'active' : '' }}" 
                            wire:click="setActiveTab('general')" 
                            type="button">
                        <iconify-icon icon="solar:settings-bold" class="me-1"></iconify-icon>
                        General
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'logos' ? 'active' : '' }}" 
                            wire:click="setActiveTab('logos')" 
                            type="button">
                        <iconify-icon icon="solar:gallery-bold" class="me-1"></iconify-icon>
                        Logos & Images
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'social' ? 'active' : '' }}" 
                            wire:click="setActiveTab('social')" 
                            type="button">
                        <iconify-icon icon="solar:share-bold" class="me-1"></iconify-icon>
                        Social Links
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'seo' ? 'active' : '' }}" 
                            wire:click="setActiveTab('seo')" 
                            type="button">
                        <iconify-icon icon="solar:seo-bold" class="me-1"></iconify-icon>
                        SEO
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'theme' ? 'active' : '' }}" 
                            wire:click="setActiveTab('theme')" 
                            type="button">
                        <iconify-icon icon="solar:palette-bold" class="me-1"></iconify-icon>
                        Theme
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'scripts' ? 'active' : '' }}" 
                            wire:click="setActiveTab('scripts')" 
                            type="button">
                        <iconify-icon icon="solar:code-bold" class="me-1"></iconify-icon>
                        Scripts
                    </button>
                </li>
            </ul>

            <!-- Loading Indicator -->
            <div wire:loading wire:target="saveSettings" class="alert alert-info">
                <iconify-icon icon="svg-spinners:bars-scale" class="me-2"></iconify-icon>
                Saving settings...
            </div>

            <!-- Form -->
            <form wire:submit.prevent="saveSettings">
                <div class="card">
                    <div class="card-body">
                        <!-- General Tab -->
                        @if($activeTab == 'general')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        Website Name <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" 
                                           class="form-control @error('websiteSettings.website_name') is-invalid @enderror" 
                                           placeholder="Enter website name"
                                           wire:model="websiteSettings.website_name">
                                    @error('websiteSettings.website_name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Website Tagline</label>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Enter tagline"
                                           wire:model="websiteSettings.website_tagline">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Website Description</label>
                                    <textarea class="form-control" 
                                              rows="3" 
                                              placeholder="Describe your website"
                                              wire:model="websiteSettings.website_description"></textarea>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Email</label>
                                    <input type="email" 
                                           class="form-control @error('websiteSettings.email') is-invalid @enderror" 
                                           placeholder="admin@example.com"
                                           wire:model="websiteSettings.email">
                                    @error('websiteSettings.email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Phone</label>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="+1 234 567 890"
                                           wire:model="websiteSettings.phone">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">WhatsApp Number</label>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="+1 234 567 890"
                                           wire:model="websiteSettings.whatsapp">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Location URL (Google Maps)</label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.location_url') is-invalid @enderror" 
                                           placeholder="https://maps.google.com/..."
                                           wire:model="websiteSettings.location_url">
                                    @error('websiteSettings.location_url')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <textarea class="form-control" 
                                              rows="2" 
                                              placeholder="Enter your address"
                                              wire:model="websiteSettings.address"></textarea>
                                </div>
                            </div>
                        @endif

                        <!-- Logos & Images Tab -->
                        @if($activeTab == 'logos')
                            <div class="row">
                                <!-- Light Logo -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Light Logo</label>
                                    <div class="logo-preview mb-2" 
                                         style="width: 100%; height: 150px; border: 2px dashed #ddd; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa; padding: 10px;">
                                        @if($logo_light_temp)
                                            <img src="{{ $logo_light_temp->temporaryUrl() }}" 
                                                 alt="Light Logo" 
                                                 style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @elseif(isset($websiteSettings['logo_light_url']) && $websiteSettings['logo_light_url'])
                                            <img src="{{ $websiteSettings['logo_light_url'] }}" 
                                                 alt="Light Logo" 
                                                 style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <div style="text-align: center; color: #999;">
                                                <iconify-icon icon="solar:image-bold" style="font-size: 48px;"></iconify-icon>
                                                <p class="mb-0">No Logo</p>
                                                <small>Upload light logo</small>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" 
                                           class="form-control" 
                                           accept="image/*"
                                           wire:model="logo_light_temp">
                                    @if(isset($websiteSettings['logo_light']) && $websiteSettings['logo_light'])
                                        <button type="button" class="btn btn-sm btn-danger mt-2" 
                                                wire:click="removeLogo('logo_light')">
                                            <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                                            Remove Logo
                                        </button>
                                    @endif
                                    <small class="text-muted">Recommended: 200x50px (PNG, SVG)</small>
                                    @error('logo_light_temp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Dark Logo -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Dark Logo</label>
                                    <div class="logo-preview mb-2" 
                                         style="width: 100%; height: 150px; border: 2px dashed #ddd; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #1a1a1a; padding: 10px;">
                                        @if($logo_dark_temp)
                                            <img src="{{ $logo_dark_temp->temporaryUrl() }}" 
                                                 alt="Dark Logo" 
                                                 style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @elseif(isset($websiteSettings['logo_dark_url']) && $websiteSettings['logo_dark_url'])
                                            <img src="{{ $websiteSettings['logo_dark_url'] }}" 
                                                 alt="Dark Logo" 
                                                 style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                        @else
                                            <div style="text-align: center; color: #666;">
                                                <iconify-icon icon="solar:image-bold" style="font-size: 48px;"></iconify-icon>
                                                <p class="mb-0">No Logo</p>
                                                <small>Upload dark logo</small>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" 
                                           class="form-control" 
                                           accept="image/*"
                                           wire:model="logo_dark_temp">
                                    @if(isset($websiteSettings['logo_dark']) && $websiteSettings['logo_dark'])
                                        <button type="button" class="btn btn-sm btn-danger mt-2" 
                                                wire:click="removeLogo('logo_dark')">
                                            <iconify-icon icon="solar:trash-bin-trash-bold"></iconify-icon>
                                            Remove Logo
                                        </button>
                                    @endif
                                    <small class="text-muted">Recommended: 200x50px (PNG, SVG)</small>
                                    @error('logo_dark_temp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- Favicon -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Favicon</label>
                                    <div class="logo-preview mb-2" 
                                         style="width: 100px; height: 100px; border: 2px dashed #ddd; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                        @if($favicon_temp)
                                            <img src="{{ $favicon_temp->temporaryUrl() }}" 
                                                 alt="Favicon" 
                                                 style="width: 100%; height: 100%; object-fit: contain;">
                                        @elseif(isset($websiteSettings['favicon_url']) && $websiteSettings['favicon_url'])
                                            <img src="{{ $websiteSettings['favicon_url'] }}" 
                                                 alt="Favicon" 
                                                 style="width: 100%; height: 100%; object-fit: contain;">
                                        @else
                                            <div style="text-align: center; color: #999; font-size: 12px;">
                                                <iconify-icon icon="solar:image-bold" style="font-size: 32px;"></iconify-icon>
                                                <p class="mb-0">No Icon</p>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" 
                                           class="form-control" 
                                           accept="image/*"
                                           wire:model="favicon_temp">
                                    <small class="text-muted">Recommended: 32x32px, 64x64px, or 128x128px</small>
                                    @error('favicon_temp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <!-- OG Image -->
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Open Graph Image (OG Image)</label>
                                    <div class="logo-preview mb-2" 
                                         style="width: 100%; height: 150px; border: 2px dashed #ddd; border-radius: 8px; overflow: hidden; display: flex; align-items: center; justify-content: center; background: #f8f9fa;">
                                        @if($og_image_temp)
                                            <img src="{{ $og_image_temp->temporaryUrl() }}" 
                                                 alt="OG Image" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @elseif(isset($websiteSettings['og_image_url']) && $websiteSettings['og_image_url'])
                                            <img src="{{ $websiteSettings['og_image_url'] }}" 
                                                 alt="OG Image" 
                                                 style="width: 100%; height: 100%; object-fit: cover;">
                                        @else
                                            <div style="text-align: center; color: #999;">
                                                <iconify-icon icon="solar:image-bold" style="font-size: 48px;"></iconify-icon>
                                                <p class="mb-0">No Image</p>
                                                <small>Upload OG image</small>
                                            </div>
                                        @endif
                                    </div>
                                    <input type="file" 
                                           class="form-control" 
                                           accept="image/*"
                                           wire:model="og_image_temp">
                                    <small class="text-muted">Recommended: 1200x630px (Max: 2MB)</small>
                                    @error('og_image_temp')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Logo Alt Text</label>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Enter alt text for logo"
                                           wire:model="websiteSettings.logo_alt_text">
                                    <small class="text-muted">Used for SEO and accessibility</small>
                                </div>
                            </div>
                        @endif

                        <!-- Social Links Tab -->
                        @if($activeTab == 'social')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <iconify-icon icon="logos:facebook"></iconify-icon>
                                        Facebook URL
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.facebook') is-invalid @enderror" 
                                           placeholder="https://facebook.com/yourpage"
                                           wire:model="websiteSettings.facebook">
                                    @error('websiteSettings.facebook')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <iconify-icon icon="logos:twitter"></iconify-icon>
                                        Twitter/X URL
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.twitter') is-invalid @enderror" 
                                           placeholder="https://twitter.com/yourhandle"
                                           wire:model="websiteSettings.twitter">
                                    @error('websiteSettings.twitter')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <iconify-icon icon="logos:instagram-icon"></iconify-icon>
                                        Instagram URL
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.instagram') is-invalid @enderror" 
                                           placeholder="https://instagram.com/yourprofile"
                                           wire:model="websiteSettings.instagram">
                                    @error('websiteSettings.instagram')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <iconify-icon icon="logos:youtube-icon"></iconify-icon>
                                        YouTube URL
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.youtube') is-invalid @enderror" 
                                           placeholder="https://youtube.com/@yourchannel"
                                           wire:model="websiteSettings.youtube">
                                    @error('websiteSettings.youtube')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <iconify-icon icon="logos:linkedin-icon"></iconify-icon>
                                        LinkedIn URL
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.linkedin') is-invalid @enderror" 
                                           placeholder="https://linkedin.com/company/yourcompany"
                                           wire:model="websiteSettings.linkedin">
                                    @error('websiteSettings.linkedin')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <iconify-icon icon="logos:pinterest"></iconify-icon>
                                        Pinterest URL
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.pinterest') is-invalid @enderror" 
                                           placeholder="https://pinterest.com/yourprofile"
                                           wire:model="websiteSettings.pinterest">
                                    @error('websiteSettings.pinterest')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <iconify-icon icon="logos:tiktok-icon"></iconify-icon>
                                        TikTok URL
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.tiktok') is-invalid @enderror" 
                                           placeholder="https://tiktok.com/@yourhandle"
                                           wire:model="websiteSettings.tiktok">
                                    @error('websiteSettings.tiktok')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">
                                        <iconify-icon icon="logos:github-icon"></iconify-icon>
                                        GitHub URL
                                    </label>
                                    <input type="url" 
                                           class="form-control @error('websiteSettings.github') is-invalid @enderror" 
                                           placeholder="https://github.com/yourusername"
                                           wire:model="websiteSettings.github">
                                    @error('websiteSettings.github')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        @endif

                        <!-- SEO Tab -->
                        @if($activeTab == 'seo')
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Meta Title</label>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Enter meta title"
                                           wire:model="websiteSettings.meta_title">
                                    <small class="text-muted">Recommended: 50-60 characters</small>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Meta Description</label>
                                    <textarea class="form-control" 
                                              rows="2" 
                                              placeholder="Enter meta description"
                                              wire:model="websiteSettings.meta_description"></textarea>
                                    <small class="text-muted">Recommended: 150-160 characters</small>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Meta Keywords</label>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="keyword1, keyword2, keyword3"
                                           wire:model="websiteSettings.meta_keywords">
                                    <small class="text-muted">Comma separated keywords</small>
                                </div>
                            </div>
                        @endif

                        <!-- Theme Tab -->
                        @if($activeTab == 'theme')
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Primary Color</label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="padding: 0;">
                                            <input type="color" 
                                                   class="form-control form-control-color" 
                                                   style="width: 40px; height: 38px; padding: 2px; border: none;"
                                                   wire:model="websiteSettings.primary_color">
                                        </span>
                                        <input type="text" 
                                               class="form-control" 
                                               wire:model="websiteSettings.primary_color">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Secondary Color</label>
                                    <div class="input-group">
                                        <span class="input-group-text" style="padding: 0;">
                                            <input type="color" 
                                                   class="form-control form-control-color" 
                                                   style="width: 40px; height: 38px; padding: 2px; border: none;"
                                                   wire:model="websiteSettings.secondary_color">
                                        </span>
                                        <input type="text" 
                                               class="form-control" 
                                               wire:model="websiteSettings.secondary_color">
                                    </div>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label class="form-label fw-bold">Dark Mode</label>
                                    <select class="form-select" wire:model="websiteSettings.dark_mode">
                                        <option value="auto">Auto (System Preference)</option>
                                        <option value="light">Always Light</option>
                                        <option value="dark">Always Dark</option>
                                    </select>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Footer Text</label>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="Enter footer text"
                                           wire:model="websiteSettings.footer_text">
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Copyright Text</label>
                                    <input type="text" 
                                           class="form-control" 
                                           placeholder="© 2024 Your Company. All rights reserved."
                                           wire:model="websiteSettings.copyright_text">
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               id="show_powered_by" 
                                               wire:model="websiteSettings.show_powered_by"
                                               value="1">
                                        <label class="form-check-label" for="show_powered_by">
                                            Show "Powered By" in footer
                                        </label>
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" 
                                               id="allow_registration" 
                                               wire:model="websiteSettings.allow_registration"
                                               value="1">
                                        <label class="form-check-label" for="allow_registration">
                                            Allow User Registration
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Scripts Tab -->
                        @if($activeTab == 'scripts')
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Google Analytics Code</label>
                                    <textarea class="form-control" 
                                              rows="3" 
                                              placeholder="<!-- Google Analytics -->"
                                              wire:model="websiteSettings.google_analytics"></textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Custom CSS</label>
                                    <textarea class="form-control font-monospace" 
                                              rows="4" 
                                              placeholder="/* Custom CSS */"
                                              wire:model="websiteSettings.custom_css"></textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Custom JavaScript</label>
                                    <textarea class="form-control font-monospace" 
                                              rows="4" 
                                              placeholder="// Custom JavaScript"
                                              wire:model="websiteSettings.custom_js"></textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Head Scripts (Before </head>)</label>
                                    <textarea class="form-control font-monospace" 
                                              rows="3" 
                                              placeholder="<!-- Scripts in head -->"
                                              wire:model="websiteSettings.head_scripts"></textarea>
                                </div>

                                <div class="col-12 mb-3">
                                    <label class="form-label fw-bold">Body Scripts (Before </body>)</label>
                                    <textarea class="form-control font-monospace" 
                                              rows="3" 
                                              placeholder="<!-- Scripts before closing body -->"
                                              wire:model="websiteSettings.body_scripts"></textarea>
                                </div>

                                <!-- Maintenance Mode -->
                                <div class="col-12 mb-3">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="form-check form-switch mb-3">
                                                <input class="form-check-input" type="checkbox" 
                                                       id="is_maintenance" 
                                                       wire:model="websiteSettings.is_maintenance"
                                                       value="1">
                                                <label class="form-check-label fw-bold" for="is_maintenance">
                                                    Maintenance Mode
                                                </label>
                                                <small class="text-muted d-block">
                                                    When enabled, only admins can access the website
                                                </small>
                                            </div>

                                            <label class="form-label fw-bold">Maintenance Message</label>
                                            <textarea class="form-control" 
                                                      rows="2" 
                                                      placeholder="We're currently updating our website. Please check back soon!"
                                                      wire:model="websiteSettings.maintenance_message"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Save Button -->
                    <div class="card-footer">
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-secondary" 
                                    wire:click="loadSettings">
                                <iconify-icon icon="solar:restart-bold" class="me-1"></iconify-icon>
                                Reset
                            </button>
                            <button type="submit" class="btn btn-success" 
                                    wire:loading.attr="disabled">
                                <iconify-icon icon="solar:check-circle-bold" class="me-1"></iconify-icon>
                                <span wire:loading.remove>Save Settings</span>
                                <span wire:loading>Saving...</span>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .nav-tabs .nav-link {
            color: #495057;
            border: none;
            padding: 10px 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        
        .nav-tabs .nav-link:hover {
            color: #0d6efd;
            background: #f8f9fa;
        }
        
        .nav-tabs .nav-link.active {
            color: #0d6efd;
            border-bottom: 2px solid #0d6efd;
            background: transparent;
        }
        
        .nav-tabs .nav-link iconify-icon {
            font-size: 18px;
            vertical-align: middle;
        }
        
        .logo-preview {
            transition: all 0.3s ease;
        }
        
        .logo-preview:hover {
            border-color: #0d6efd !important;
            background: #f0f8ff !important;
        }
        
        .form-check-input:checked {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
        
        .font-monospace {
            font-family: 'Courier New', monospace;
            font-size: 13px;
        }
    </style>

    @push('scripts')
    <script>
        document.addEventListener('livewire:initialized', function () {
            Livewire.on('notification', (data) => {
                showNotification(data.message, data.type);
            });
        });

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
            
            setTimeout(() => {
                notification.style.animation = 'slideOutRight 0.5s ease';
                setTimeout(() => notification.remove(), 500);
            }, 3000);
        }

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
    </script>
    @endpush
</div>