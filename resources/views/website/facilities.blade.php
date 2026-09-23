@extends('layouts.website')

@section('title', 'Campus Facilities | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Explore the modern campus facilities at Junior Gurukul School, Bhikangaon — smart classrooms, library, science labs, sports ground and safe transport.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> Campus Life
        </div>
        <span class="section-label justify-content-center mb-2">Campus Life</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">Campus Facilities</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">Modern infrastructure on Kedwa Road, Bhikangaon, built for holistic student development.</p>
    </div>
</section>

<!-- FACILITIES LIST -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up">
                <div class="hover-card rounded-4 overflow-hidden">
                    <div class="card-img-wrapper" style="height: 240px;">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80" class="w-100 h-100 object-fit-cover" alt="Smart Class">
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold text-dark" style="font-family: var(--font-heading);">Smart Classrooms</h4>
                        <p class="text-muted small mb-0">Digital boards, audio-visual learning tools and comfortable, well-lit seating in every classroom.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="hover-card rounded-4 overflow-hidden">
                    <div class="card-img-wrapper" style="height: 240px;">
                        <img src="https://images.unsplash.com/photo-1521587760476-6c12a4b040da?auto=format&fit=crop&w=800&q=80" class="w-100 h-100 object-fit-cover" alt="Library">
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold text-dark" style="font-family: var(--font-heading);">Library</h4>
                        <p class="text-muted small mb-0">A growing collection of books, reference material and quiet study corners for young readers.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="hover-card rounded-4 overflow-hidden">
                    <div class="card-img-wrapper" style="height: 240px;">
                        <img src="https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=800&q=80" class="w-100 h-100 object-fit-cover" alt="Labs">
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold text-dark" style="font-family: var(--font-heading);">STEM & Computer Labs</h4>
                        <p class="text-muted small mb-0">Dedicated science and computer labs for hands-on experiments and early coding skills.</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="hover-card rounded-4 overflow-hidden">
                    <div class="card-img-wrapper" style="height: 240px;">
                        <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=800&q=80" class="w-100 h-100 object-fit-cover" alt="Sports">
                    </div>
                    <div class="p-4">
                        <h4 class="fw-bold text-dark" style="font-family: var(--font-heading);">Sports Ground & Transport</h4>
                        <p class="text-muted small mb-0">An open playground for athletics and team sports, plus safe, supervised bus routes across Bhikangaon.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- QUICK FACTS STRIP -->
<section class="stat-counter-strip py-5">
    <div class="container py-3">
        <div class="row g-4 text-center text-white">
            <div class="col-6 col-lg-3 stat-counter-item" data-aos="fade-up" data-aos-delay="100">
                <div class="stat-counter-num">4+</div>
                <div class="text-white-50 small text-uppercase mt-1" style="letter-spacing: 1px;">Core Facilities</div>
            </div>
            <div class="col-6 col-lg-3 stat-counter-item" data-aos="fade-up" data-aos-delay="200">
                <div class="stat-counter-num">20+</div>
                <div class="text-white-50 small text-uppercase mt-1" style="letter-spacing: 1px;">Classrooms</div>
            </div>
            <div class="col-6 col-lg-3 stat-counter-item" data-aos="fade-up" data-aos-delay="300">
                <div class="stat-counter-num">24/7</div>
                <div class="text-white-50 small text-uppercase mt-1" style="letter-spacing: 1px;">Campus Surveillance</div>
            </div>
            <div class="col-6 col-lg-3 stat-counter-item" data-aos="fade-up" data-aos-delay="400">
                <div class="stat-counter-num">100%</div>
                <div class="text-white-50 small text-uppercase mt-1" style="letter-spacing: 1px;">Supervised Transport</div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-light text-center">
    <div class="container py-3" data-aos="zoom-in">
        <h2 class="fw-bold text-dark mb-3" style="font-family: var(--font-heading);">Want to See the Campus in Person?</h2>
        <a href="{{ route('website.contact') }}" class="btn-gold btn-lg">Schedule a Visit <i class="bi bi-arrow-right"></i></a>
    </div>
</section>

@endsection