@extends('layouts.website')

@section('title', 'Faculty & Mentors | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Meet the passionate educators at Junior Gurukul School, Bhikangaon, dedicated to nurturing every student\'s academic and personal growth.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> Faculty Mentors
        </div>
        <span class="section-label justify-content-center mb-2">Our Educators</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">Our Faculty & Mentors</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">Passionate educators dedicated to nurturing every student's excellence.</p>
    </div>
</section>

<!-- FACULTY GRID -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4">
            @forelse($teachers as $t)
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="hover-card text-center p-4 h-100">
                        <div class="rounded-circle text-white fw-bold d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px; font-size: 2rem; font-family: var(--font-heading); background: linear-gradient(145deg, #E4C185, var(--gold-primary) 55%, #8E6A32); color: #0B192C;">
                            {{ strtoupper(substr($t->first_name, 0, 1)) }}
                        </div>
                        <h5 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">{{ $t->full_name }}</h5>
                        <span class="badge-gold mb-2">{{ $t->designation }}</span>
                        <div class="small text-muted mb-1"><i class="bi bi-mortarboard me-1 text-gold"></i> {{ $t->qualification }}</div>
                        <div class="small text-muted"><i class="bi bi-envelope me-1"></i> {{ $t->email }}</div>
                    </div>
                </div>
            @empty
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="hover-card text-center p-4 h-100">
                        <div class="rounded-circle text-white fw-bold d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px; font-size: 2rem; font-family: var(--font-heading); background: linear-gradient(145deg, #E4C185, var(--gold-primary) 55%, #8E6A32); color: #0B192C;">V</div>
                        <h5 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Vikram Malhotra</h5>
                        <span class="badge-gold mb-2">Senior Mathematics Faculty</span>
                        <p class="small text-muted mt-2 mb-0">M.Sc. Mathematics, B.Ed.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="hover-card text-center p-4 h-100">
                        <div class="rounded-circle text-white fw-bold d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px; font-size: 2rem; font-family: var(--font-heading); background: linear-gradient(145deg, #E4C185, var(--gold-primary) 55%, #8E6A32); color: #0B192C;">A</div>
                        <h5 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Anita Sharma</h5>
                        <span class="badge-gold mb-2">Primary Wing Head</span>
                        <p class="small text-muted mt-2 mb-0">M.A. Education, B.Ed.</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="hover-card text-center p-4 h-100">
                        <div class="rounded-circle text-white fw-bold d-inline-flex align-items-center justify-content-center mb-3 shadow" style="width: 80px; height: 80px; font-size: 2rem; font-family: var(--font-heading); background: linear-gradient(145deg, #E4C185, var(--gold-primary) 55%, #8E6A32); color: #0B192C;">P</div>
                        <h5 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Pooja Rathore</h5>
                        <span class="badge-gold mb-2">Science Faculty</span>
                        <p class="small text-muted mt-2 mb-0">M.Sc. Chemistry, B.Ed.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- WHY OUR FACULTY -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="row g-4 text-center">
            <div class="col-md-4" data-aos="fade-up">
                <div class="icon-circle-lg mx-auto mb-3"><i class="bi bi-mortarboard"></i></div>
                <h6 class="fw-bold text-dark" style="font-family: var(--font-heading);">Qualified & Experienced</h6>
                <p class="small text-muted">Trained, CBSE-experienced educators across every subject.</p>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="icon-circle-lg mx-auto mb-3"><i class="bi bi-people"></i></div>
                <h6 class="fw-bold text-dark" style="font-family: var(--font-heading);">Low Student Ratio</h6>
                <p class="small text-muted">A 1:15 teacher-student ratio for focused, individual mentorship.</p>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="icon-circle-lg mx-auto mb-3"><i class="bi bi-heart"></i></div>
                <h6 class="fw-bold text-dark" style="font-family: var(--font-heading);">Genuinely Caring</h6>
                <p class="small text-muted">Mentors who know every child by name and nurture their growth.</p>
            </div>
        </div>
    </div>
</section>

@endsection