@extends('layouts.website')

@section('title', 'Contact Us | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Get in touch with Junior Gurukul School, Kedwa Road, Bhikangaon. Call 096176 14788 or send us a message — we would love to welcome you to our campus.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> Contact
        </div>
        <span class="section-label justify-content-center mb-2">Get in Touch</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">Contact Us</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">We're here to answer your questions and welcome you to our campus.</p>
    </div>
</section>

<!-- CONTACT DETAILS & FORM -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <h3 class="fw-bold text-dark mb-4" style="font-family: var(--font-heading);">Reach Out to Us</h3>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="icon-circle-lg"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Campus Address</h6>
                        <p class="text-muted small mb-0">Junior Gurukul School, Seavri Dhaam, Bhikangaon, Panchamba, Madhya Pradesh 451331<br>(Kedwa Road, Bhikangaon)</p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="icon-circle-lg"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Phone Number</h6>
                        <p class="text-muted small mb-0"><a href="tel:+919617614788" class="text-muted text-decoration-none">096176 14788</a></p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3 mb-4">
                    <div class="icon-circle-lg"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Email Queries</h6>
                        <p class="text-muted small mb-0"><a href="mailto:info@juniorgurukulschool.in" class="text-muted text-decoration-none">info@juniorgurukulschool.in</a></p>
                    </div>
                </div>

                <div class="d-flex align-items-start gap-3">
                    <div class="icon-circle-lg"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <h6 class="fw-bold text-dark mb-1">Visiting Hours</h6>
                        <p class="text-muted small mb-0">Monday to Saturday: 8:00 AM – 3:30 PM</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-7" data-aos="fade-left">
                <div class="card border-0 rounded-4 shadow-lg p-4 bg-light">
                    <h4 class="fw-bold text-dark mb-3" style="font-family: var(--font-heading);">Send a Message</h4>

                    @if(session('success'))
                        <div class="alert alert-success small mb-3">{{ session('success') }}</div>
                    @endif

                    <form action="{{ route('website.enquiry.submit') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="contact">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Your Name *</label>
                                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small mb-1">Your Phone *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="98765 43210" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small mb-1">Your Email</label>
                                <input type="email" name="email" class="form-control" placeholder="name@example.com">
                            </div>
                            <div class="col-12">
                                <label class="form-label small mb-1">Message *</label>
                                <textarea name="message" class="form-control" rows="4" placeholder="How can we assist you?" required></textarea>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn-gold py-3 px-4 fw-bold border-0">
                                    Send Message <i class="bi bi-send"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- MAP -->
<section class="pb-5 bg-white">
    <div class="container">
        <div class="rounded-4 overflow-hidden shadow-lg" style="height: 380px;" data-aos="fade-up">
            <iframe
                src="https://www.google.com/maps?q=Bhikangaon,+Madhya+Pradesh+451331&output=embed"
                width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</section>

@endsection