@extends('layouts.website')

@section('title', 'Photo & Event Gallery | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Explore moments of joy, academic achievements, sports competitions, and cultural celebrations at Junior Gurukul School, Bhikangaon.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> Gallery
        </div>
        <span class="section-label justify-content-center mb-2">Campus Moments</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">Campus Life Gallery</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">Moments of joy, learning, sports triumphs, and cultural celebrations at Junior Gurukul School.</p>
    </div>
</section>

<!-- MASONRY GALLERY WITH LIGHTBOX -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4">
            @forelse($galleries as $g)
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <a href="{{ $g->image_path }}" class="glightbox hover-card d-block rounded-4 overflow-hidden position-relative" style="height: 260px;">
                        <img src="{{ $g->image_path }}" class="w-100 h-100 object-fit-cover" alt="{{ $g->title }}">
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white" style="background: linear-gradient(to top, rgba(7, 15, 30, 0.95), transparent);">
                            <span class="badge-gold mb-1" style="font-size: 0.7rem;">{{ $g->category }}</span>
                            <h6 class="fw-bold mb-0 text-white" style="font-family: var(--font-heading);">{{ $g->title }}</h6>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <a href="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1200&q=80" class="glightbox hover-card d-block rounded-4 overflow-hidden position-relative" style="height: 260px;">
                        <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="Annual Day">
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white" style="background: linear-gradient(to top, rgba(7, 15, 30, 0.95), transparent);">
                            <span class="badge-gold mb-1" style="font-size: 0.7rem;">Campus Event</span>
                            <h6 class="fw-bold mb-0 text-white" style="font-family: var(--font-heading);">Annual Cultural Festival</h6>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                    <a href="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=1200&q=80" class="glightbox hover-card d-block rounded-4 overflow-hidden position-relative" style="height: 260px;">
                        <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="Science Exhibition">
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white" style="background: linear-gradient(to top, rgba(7, 15, 30, 0.95), transparent);">
                            <span class="badge-gold mb-1" style="font-size: 0.7rem;">Academics</span>
                            <h6 class="fw-bold mb-0 text-white" style="font-family: var(--font-heading);">Science & Art Exhibition</h6>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                    <a href="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=1200&q=80" class="glightbox hover-card d-block rounded-4 overflow-hidden position-relative" style="height: 260px;">
                        <img src="https://images.unsplash.com/photo-1574629810360-7efbbe195018?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="Sports Meet">
                        <div class="position-absolute bottom-0 start-0 end-0 p-3 text-white" style="background: linear-gradient(to top, rgba(7, 15, 30, 0.95), transparent);">
                            <span class="badge-gold mb-1" style="font-size: 0.7rem;">Sports</span>
                            <h6 class="fw-bold mb-0 text-white" style="font-family: var(--font-heading);">Annual Sports Meet</h6>
                        </div>
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
