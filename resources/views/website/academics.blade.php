@extends('layouts.website')

@section('title', 'Academics & Curriculum | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Explore the CBSE curriculum at Junior Gurukul School, Bhikangaon — from Pre-Primary play-based learning to rigorous Secondary board preparation.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> Academics
        </div>
        <span class="section-label justify-content-center mb-2">Curriculum</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">Academics & Curriculum</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">CBSE curriculum designed for curious minds and strong foundations, at every stage.</p>
    </div>
</section>

<!-- CURRICULUM PATHWAYS -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <div class="text-center mx-auto mb-5" style="max-width: 640px;" data-aos="fade-up">
            <span class="section-label justify-content-center mb-2">Academic Wings</span>
            <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">Four Wings of Learning</h2>
        </div>

        <div class="row g-4">
            <div class="col-md-6" data-aos="fade-up">
                <div class="hover-card p-4 h-100 border rounded-4">
                    <span class="badge-gold mb-3">Foundation Wing</span>
                    <h3 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Pre-Primary Education</h3>
                    <p class="text-muted leading-relaxed mb-3">Play-way methodology, social interaction, sensory awareness, phonics and motor skill development in a warm, joyful setting.</p>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2 mb-0">
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Play-based sensory & activity corners</li>
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Phonics & early English/Hindi reading</li>
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Rhythm, rhymes, and physical agility</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="100">
                <div class="hover-card p-4 h-100 border rounded-4">
                    <span class="badge-gold mb-3">Grades 1 to 5</span>
                    <h3 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Primary School</h3>
                    <p class="text-muted leading-relaxed mb-3">Interactive foundational courses in Mathematics, Science, English, Hindi, and Environmental Studies with hands-on activities.</p>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2 mb-0">
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Core numeracy & problem solving</li>
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Environmental studies & nature trips</li>
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Computer fundamentals & art craft</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="hover-card p-4 h-100 border rounded-4">
                    <span class="badge-gold mb-3">Grades 6 to 8</span>
                    <h3 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Middle School</h3>
                    <p class="text-muted leading-relaxed mb-3">Experimental laboratory science, algebra & geometry, computer basics, social studies and strong language skills.</p>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2 mb-0">
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Physics, Chemistry & Biology practicals</li>
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Computer lab coding & logic</li>
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Third language & public speaking</li>
                    </ul>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="hover-card p-4 h-100 border rounded-4">
                    <span class="badge-gold mb-3">Grades 9 & 10</span>
                    <h3 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Secondary School (CBSE)</h3>
                    <p class="text-muted leading-relaxed mb-3">Rigorous board examination preparation, competitive exam training, STEM practicals and career guidance.</p>
                    <ul class="list-unstyled text-muted small d-flex flex-column gap-2 mb-0">
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> CBSE Class X Board syllabus alignment</li>
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Olympiad & competitive exam foundation</li>
                        <li><i class="bi bi-check-circle-fill text-gold me-2"></i> Individual academic mentoring</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- DYNAMIC SUBJECTS LIST -->
<section class="py-5 bg-light">
    <div class="container py-4">
        <div class="text-center mx-auto mb-5" style="max-width: 640px;" data-aos="fade-up">
            <span class="section-label justify-content-center mb-2">Subject Spectrum</span>
            <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">Academic Subjects Offered</h2>
        </div>

        <div class="row g-3">
            @forelse($subjects ?? [] as $sub)
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="p-3 bg-white rounded-3 border d-flex align-items-center gap-3">
                        <div class="icon-circle" style="width: 44px; height: 44px; font-size: 1.1rem;"><i class="bi bi-book"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">{{ $sub->name }}</h6>
                            <span class="small text-muted">Code: {{ $sub->code ?? 'SUB101' }} | {{ ucfirst($sub->type ?? 'theory') }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="p-3 bg-white rounded-3 border d-flex align-items-center gap-3">
                        <div class="icon-circle" style="width: 44px; height: 44px; font-size: 1.1rem;"><i class="bi bi-calculator"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">Mathematics</h6>
                            <span class="small text-muted">Mandatory CBSE</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="p-3 bg-white rounded-3 border d-flex align-items-center gap-3">
                        <div class="icon-circle" style="width: 44px; height: 44px; font-size: 1.1rem;"><i class="bi bi-flask"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">General Science</h6>
                            <span class="small text-muted">Physics, Chemistry, Bio</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up">
                    <div class="p-3 bg-white rounded-3 border d-flex align-items-center gap-3">
                        <div class="icon-circle" style="width: 44px; height: 44px; font-size: 1.1rem;"><i class="bi bi-journal-text"></i></div>
                        <div>
                            <h6 class="fw-bold text-dark mb-0" style="font-family: var(--font-heading);">English Literature</h6>
                            <span class="small text-muted">Language & Grammar</span>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- APPROACH STRIP -->
<section class="py-5 bg-navy-bg">
    <div class="container py-4">
        <div class="text-center mx-auto mb-5" style="max-width: 640px;" data-aos="fade-up">
            <span class="section-label justify-content-center mb-2">Our Approach</span>
            <h2 class="display-6 fw-bold text-white mt-1" style="font-family: var(--font-heading);">How We Teach</h2>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="why-card text-center">
                    <div class="icon-circle mx-auto mb-3"><i class="bi bi-puzzle"></i></div>
                    <h6 class="fw-bold text-white mb-2" style="font-family: var(--font-heading);">Activity-Based Learning</h6>
                    <p class="small text-white-50 mb-0">Concepts taught through experiments, projects and real-world examples.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="why-card text-center">
                    <div class="icon-circle mx-auto mb-3"><i class="bi bi-person-check"></i></div>
                    <h6 class="fw-bold text-white mb-2" style="font-family: var(--font-heading);">Individual Mentorship</h6>
                    <p class="small text-white-50 mb-0">Small class sizes so every child gets the attention they need.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="why-card text-center">
                    <div class="icon-circle mx-auto mb-3"><i class="bi bi-graph-up-arrow"></i></div>
                    <h6 class="fw-bold text-white mb-2" style="font-family: var(--font-heading);">Continuous Assessment</h6>
                    <p class="small text-white-50 mb-0">Regular tests and feedback to track and support every student's growth.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-5 bg-light text-center">
    <div class="container py-3" data-aos="zoom-in">
        <h2 class="fw-bold text-dark mb-3" style="font-family: var(--font-heading);">Want to Know More About Our Curriculum?</h2>
        <a href="{{ route('website.admissions') }}" class="btn-gold btn-lg">Apply for Admission <i class="bi bi-arrow-right"></i></a>
    </div>
</section>

@endsection