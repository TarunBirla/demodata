@extends('layouts.website')

@section('title', 'Parent & Student Testimonials | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Read authentic parent and student testimonials about Junior Gurukul School, Bhikangaon — academic excellence, dedicated faculty, and character building.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> Testimonials
        </div>
        <span class="section-label justify-content-center mb-2">Community Voices</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">Parent & Student Testimonials</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">Real experiences shared directly by our parents, students, and guardians in Bhikangaon.</p>
    </div>
</section>

<!-- TESTIMONIALS GRID -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="row g-4">
            @forelse($testimonials as $t)
                <div class="col-md-6" data-aos="fade-up">
                    <div class="hover-card p-4 h-100 bg-light border-0">
                        <i class="bi bi-quote fs-1 text-gold mb-2 d-block"></i>
                        <p class="text-muted leading-relaxed mb-4">"{{ $t->content }}"</p>
                        <div class="d-flex align-items-center gap-3 border-top pt-3">
                            <div class="rounded-circle text-navy fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(145deg, #E4C185, var(--gold-primary)); color: #0B192C;">
                                {{ strtoupper(substr($t->name, 0, 1)) }}
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">{{ $t->name }}</h6>
                                <span class="small text-muted">{{ $t->role }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-6" data-aos="fade-up">
                    <div class="hover-card p-4 bg-light border-0">
                        <i class="bi bi-quote fs-1 text-gold mb-2 d-block"></i>
                        <p class="text-muted mb-4">"Junior Gurukul School has provided an amazing learning environment for my children. The teachers are deeply dedicated, individual focus is given to every child, and moral values are strongly taught."</p>
                        <div class="d-flex align-items-center gap-3 border-top pt-3">
                            <div class="rounded-circle fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(145deg, #E4C185, var(--gold-primary)); color: #0B192C;">
                                S
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">Mrs. Sunita Gupta</h6>
                                <span class="small text-muted">Parent of Grade 8 Student</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="hover-card p-4 bg-light border-0">
                        <i class="bi bi-quote fs-1 text-gold mb-2 d-block"></i>
                        <p class="text-muted mb-4">"The combination of smart classrooms, CBSE curriculum, and extracurricular activities at Junior Gurukul School Bhikangaon has brought tremendous confidence in my son."</p>
                        <div class="d-flex align-items-center gap-3 border-top pt-3">
                            <div class="rounded-circle fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(145deg, #E4C185, var(--gold-primary)); color: #0B192C;">
                                R
                            </div>
                            <div>
                                <h6 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">Mr. Rajesh Verma</h6>
                                <span class="small text-muted">Parent of Grade 5 Student</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

@endsection
