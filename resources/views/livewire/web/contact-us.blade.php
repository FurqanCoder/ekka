<div>
    @php
        $settings = \App\Helpers\WebsiteHelper::getSettings();
    @endphp
    <!-- Ec breadcrumb start -->
    <div class="sticky-header-next-sec ec-breadcrumb section-space-mb">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row ec_breadcrumb_inner">
                        <div class="col-md-6 col-sm-12">
                            <h2 class="ec-breadcrumb-title">Contact Us</h2>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <ul class="ec-breadcrumb-list">
                                <li class="ec-breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                                <li class="ec-breadcrumb-item active">Contact Us</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Ec breadcrumb end -->

    <!-- Ec Contact Us page -->
    <section class="ec-page-content section-space-p">
        <div class="container">
            <div class="row">
                <div class="ec-common-wrapper">
                    <div class="ec-contact-leftside">
                        <div class="ec-contact-container">
                            <!-- Success Message -->
                            @if ($success)
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <i class="ecicon eci-check-circle me-2"></i>
                                    <strong>Thank You!</strong> Your message has been sent successfully. We will get
                                    back to you soon.
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <div class="ec-contact-form">
                                <h3 class="ec-contact-title">Send Us a Message</h3>
                                <p class="ec-contact-subtitle">We'd love to hear from you. Please fill out the form
                                    below and we'll get back to you as soon as possible.</p>

                                <form wire:submit.prevent="submit">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label">
                                                    Full Name <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="name"
                                                    class="form-control @error('name') is-invalid @enderror"
                                                    wire:model="name" placeholder="Enter your full name" required>
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label">
                                                    Email Address <span class="text-danger">*</span>
                                                </label>
                                                <input type="email" id="email"
                                                    class="form-control @error('email') is-invalid @enderror"
                                                    wire:model="email" placeholder="Enter your email address" required>
                                                @error('email')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="phone" class="form-label">Phone Number</label>
                                                <input type="text" id="phone"
                                                    class="form-control @error('phone') is-invalid @enderror"
                                                    wire:model="phone" placeholder="Enter your phone number">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="subject" class="form-label">
                                                    Subject <span class="text-danger">*</span>
                                                </label>
                                                <input type="text" id="subject"
                                                    class="form-control @error('subject') is-invalid @enderror"
                                                    wire:model="subject" placeholder="Enter subject" required>
                                                @error('subject')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group mb-3">
                                                <label for="message" class="form-label">
                                                    Message <span class="text-danger">*</span>
                                                </label>
                                                <textarea id="message" class="form-control @error('message') is-invalid @enderror" wire:model="message" rows="5"
                                                    placeholder="Please leave your comments here..." required></textarea>
                                                @error('message')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                                <small class="text-muted">Minimum 10 characters</small>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-lg"
                                                wire:loading.attr="disabled">
                                                <span wire:loading.remove>
                                                    <i class="ecicon eci-paper-plane me-2"></i> Send Message
                                                </span>
                                                <span wire:loading>
                                                    <i class="ecicon eci-spinner fa-spin me-2"></i> Sending...
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Info Side -->
                    <div class="ec-contact-rightside">
                        <!-- Map -->
                        <div class="ec_contact_map">
                            <div class="ec_map_canvas">
                                <iframe id="ec_map_canvas"
                                    src="{{ $settings->location_url}}"
                                    allowfullscreen="" loading="lazy">
                                </iframe>
                            </div>
                        </div>

                        <!-- Contact Info -->
                        <div class="ec_contact_info">
                            <h1 class="ec_contact_info_head">Contact Information</h1>
                            <p class="text-muted small mb-3">We're here to help! Reach out to us through any of the
                                following channels.</p>

                            <ul>
                                <li class="ec-contact-item">
                                    <div class="contact-icon">
                                        <i class="ecicon eci-map-marker"></i>
                                    </div>
                                    <div class="contact-detail">
                                        <span class="contact-label">Address</span>
                                        <span class="contact-value">{{ $settings->address }}</span>
                                    </div>
                                </li>
                                <li class="ec-contact-item">
                                    <div class="contact-icon">
                                        <i class="ecicon eci-phone"></i>
                                    </div>
                                    <div class="contact-detail">
                                        <span class="contact-label">Phone</span>
                                        <a href="tel:+440123456789" class="contact-value">{{ $settings->phone }}</a>
                                    </div>
                                </li>
                                <li class="ec-contact-item">
                                    <div class="contact-icon">
                                        <i class="ecicon eci-envelope"></i>
                                    </div>
                                    <div class="contact-detail">
                                        <span class="contact-label">Email</span>
                                        <a href="mailto:example@ec-email.com"
                                            class="contact-value">{{$settings->email}}</a>
                                    </div>
                                </li>
                                <li class="ec-contact-item">
                                    <div class="contact-icon">
                                        <i class="ecicon eci-clock"></i>
                                    </div>
                                    <div class="contact-detail">
                                        <span class="contact-label">Working Hours</span>
                                        <span class="contact-value">Mon - Sat: 9:00 AM - 9:00 PM</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
