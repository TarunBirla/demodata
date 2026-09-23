@extends('layouts.website')

@section('title', 'About Us | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Learn about Junior Gurukul School, Bhikangaon — our history, vision, mission and the leadership guiding a tradition of excellence since our founding.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> About Us
        </div>
        <span class="section-label justify-content-center mb-2">Our Story</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">About Junior Gurukul School</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">Building legacy, character and academic brilliance in Bhikangaon since our founding.</p>
    </div>
</section>

<!-- SCHOOL HISTORY -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-6" data-aos="fade-right">
                <span class="section-label mb-2">School History & Legacy</span>
                <h2 class="display-6 fw-bold text-dark mt-2 mb-3" style="font-family: var(--font-heading);">A Journey Rooted in Values</h2>
                <p class="text-muted mb-3" style="line-height: 1.8;">
                    Junior Gurukul School began with a simple belief — that true education blends the wisdom of tradition with the tools of the modern world. What started as a small community initiative on Kedwa Road, Bhikangaon, has grown into a trusted CBSE affiliated institution serving over 600 students.
                </p>
                <p class="text-muted mb-0" style="line-height: 1.8;">
                    Over the years, our campus has expanded — smart classrooms, dedicated science and computer labs, a full playground and safe transport — while our founding principle has stayed the same: every child deserves individual attention, strong values and a joyful path to learning.
                </p>
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=80" class="img-fluid rounded-4 shadow-lg" alt="School History">
            </div>
        </div>
    </div>
</section>

<!-- VISION & MISSION -->
<section class="py-5 bg-light" id="vision">
    <div class="container py-4">
        <div class="text-center mx-auto mb-5" style="max-width: 640px;" data-aos="fade-up">
            <span class="section-label justify-content-center mb-2">What Drives Us</span>
            <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">Our Vision & Mission</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up">
                <div class="hover-card p-5 h-100 bg-white text-center">
                    <div class="icon-circle-lg mx-auto mb-3"><i class="bi bi-eye-fill"></i></div>
                    <h3 class="fw-bold text-dark mb-3" style="font-family: var(--font-heading);">Our Vision</h3>
                    <p class="text-muted mb-0" style="line-height: 1.8;">
                        To nurture confident, values-driven learners who are academically strong, culturally rooted and ready to thrive in a changing world.
                    </p>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="hover-card p-5 h-100 bg-white text-center">
                    <div class="icon-circle-lg mx-auto mb-3"><i class="bi bi-bullseye"></i></div>
                    <h3 class="fw-bold text-dark mb-3" style="font-family: var(--font-heading);">Our Mission</h3>
                    <p class="text-muted mb-0" style="line-height: 1.8;">
                        To provide a nurturing learning ecosystem that combines the rigour of the CBSE curriculum with Sanskar-based value education, STEM exposure and individual mentorship.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- PRINCIPAL'S DESK -->
<section class="py-5 bg-white" id="principal">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-5" data-aos="fade-right">
                <div class="position-relative">
                    <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-4 shadow-lg" alt="Principal">
                    <div class="position-absolute bottom-0 start-0 m-4 p-3 bg-navy-dark text-white rounded-3 shadow border-start border-4" style="border-color: var(--gold-primary) !important;">
                        <h6 class="fw-bold mb-0" style="font-family: var(--font-heading);">Mr. Devendra Patidar</h6>
                        <span class="small text-gold">Principal & Academic Director</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-7" data-aos="fade-left">
                <span class="section-label mb-2">Leadership Desk</span>
                <h2 class="display-6 fw-bold text-dark mt-2 mb-3" style="font-family: var(--font-heading);">A Message from the Principal</h2>
                <p class="text-muted mb-3" style="line-height: 1.8;">
                    "Welcome to Junior Gurukul School. We believe true education does not merely teach facts — it ignites a child's potential. Our dedicated teachers walk with every student through a journey of curiosity, character and academic growth."
                </p>
                <p class="text-muted mb-4" style="line-height: 1.8;">
                    "Rooted in the values of the Gurukul tradition and equipped for a modern world, our students leave us not just with marks, but with the confidence to shape their own future."
                </p>
                <div class="fw-bold text-dark fs-5" style="font-family: var(--font-heading);">Mr. Devendra Patidar</div>
                <div class="small text-muted">Principal & Academic Director, Junior Gurukul School</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="final-cta-section py-5 text-white text-center" style="background: radial-gradient(circle at 30% 20%, #132743 0%, #0B192C 65%, #070F1E 100%);">
    <div class="container py-4" data-aos="zoom-in">
        <span class="section-label justify-content-center mb-2">Come Visit Us</span>
        <h2 class="display-6 fw-bold text-white mt-2 mb-3" style="font-family: var(--font-heading);">See Our Campus for Yourself</h2>
        <p class="fs-5 text-white-50 mx-auto mb-4" style="max-width: 600px;">Schedule a visit and meet our teachers, explore our classrooms and experience Junior Gurukul School firsthand.</p>
        <a href="{{ route('website.contact') }}" class="btn-gold btn-lg">
            Schedule a Visit <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</section>

@endsection