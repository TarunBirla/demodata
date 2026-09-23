@extends('layouts.website')

@section('title', 'News & Events | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Latest announcements, news, examination circulars, and event updates from Junior Gurukul School, Bhikangaon.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> News & Events
        </div>
        <span class="section-label justify-content-center mb-2">Campus Bulletin</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">News & Campus Events</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">Stay updated with latest announcements, circulars, and student achievements at Junior Gurukul School.</p>
    </div>
</section>

<!-- NEWS GRID -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4">
            @forelse($newsList as $n)
                <div class="col-md-4" data-aos="fade-up">
                    <div class="hover-card h-100 d-flex flex-column border">
                        <div class="card-img-wrapper" style="height: 200px;">
                            <img src="https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="News Image">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <span class="small text-muted mb-1"><i class="bi bi-calendar-event me-1 text-gold"></i> {{ $n->published_at ? $n->published_at->format('M d, Y') : 'Sep 15, 2026' }}</span>
                            <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">{{ $n->title }}</h5>
                            <p class="small text-muted mb-3 flex-grow-1">{{ $n->summary }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4" data-aos="fade-up">
                    <div class="hover-card p-4 border h-100">
                        <span class="badge-gold mb-2">Achievement</span>
                        <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">District Science Exhibition Champions</h5>
                        <p class="small text-muted mb-0">Junior Gurukul School student delegation bagged top honors at District Science Expo 2026.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="hover-card p-4 border h-100">
                        <span class="badge-gold mb-2">Notice</span>
                        <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Admissions Open for Session 2026-27</h5>
                        <p class="small text-muted mb-0">Registrations open for Pre-Primary to Grade 10 from Basant Panchami. Collect forms from school office.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="hover-card p-4 border h-100">
                        <span class="badge-gold mb-2">Events</span>
                        <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Annual Sports & Cultural Week</h5>
                        <p class="small text-muted mb-0">Inter-house athletic meet and cultural performances scheduled for next month at our Bhikangaon campus.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
