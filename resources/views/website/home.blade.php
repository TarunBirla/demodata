@extends('layouts.website')

@section('title', 'Junior Gurukul School, Bhikangaon | A Tradition of Excellence')
@section('meta_description', 'Junior Gurukul School, Kedwa Road, Bhikangaon — a CBSE affiliated school nurturing character, curiosity and academic excellence from Pre-Primary to Grade 10.')

@push('styles')
    <style>
        /* ===== Full-bleed Hero ===== */
        .hero-fullbleed {
            position: relative;
            padding: 150px 0 100px;
            overflow: hidden;
            color: #fff;
        }

        .hero-bg-image {
            position: absolute;
            inset: 0;
            background-image: url('{{ $settings["hero_image"] ?? "https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1800&q=80" }}');
            background-size: cover;
            background-position: center 30%;
            transform: scale(1.02);
            transition: background-image 0.5s ease;
        }

        .hero-gradient {
            position: absolute;
            inset: 0;
            background:
                linear-gradient(100deg, rgba(7, 15, 30, 0.97) 10%, rgba(7, 15, 30, 0.88) 40%, rgba(7, 15, 30, 0.45) 78%),
                linear-gradient(to top, rgba(7, 15, 30, 0.98) 0%, rgba(7, 15, 30, 0.55) 35%, rgba(7, 15, 30, 0.15) 65%);
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-stat-bar {
            background: linear-gradient(180deg, rgba(23, 42, 68, 0.94), rgba(15, 28, 46, 0.97));
            border: 1px solid rgba(197, 160, 89, 0.25);
            border-top: 1px solid rgba(197, 160, 89, 0.5);
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(6px);
        }

        .hero-stat-icon {
            width: 46px;
            height: 46px;
            background: rgba(197, 160, 89, 0.15);
            color: var(--gold-primary);
            flex-shrink: 0;
        }

        .hero-stat-item {
            flex: 1 1 200px;
            min-width: 200px;
        }

        .testimonial-card {
            background: var(--navy-card);
            border-radius: 18px;
            padding: 2rem;
            border: 1px solid rgba(197, 160, 89, 0.15);
            height: 100%;
            position: relative;
        }

        .testimonial-card i.bi-quote {
            font-size: 2.2rem;
            color: var(--gold-primary);
            opacity: 0.5;
        }

        .swiper-pagination-bullet {
            background: #fff;
            opacity: 0.4;
        }

        .swiper-pagination-bullet-active {
            background: var(--gold-primary);
            opacity: 1;
        }

        .news-date-badge {
            position: absolute;
            top: 14px;
            left: 14px;
            background: var(--gold-primary);
            color: #0B192C;
            font-weight: 700;
            font-size: 0.75rem;
            padding: 6px 12px;
            border-radius: 8px;
            font-family: var(--font-heading);
            z-index: 2;
        }

        .stat-counter-strip {
            background: radial-gradient(circle at 15% 20%, #16304f 0%, #0B192C 60%, #070F1E 100%);
            border-top: 1px solid rgba(197, 160, 89, 0.15);
            border-bottom: 1px solid rgba(197, 160, 89, 0.15);
        }

        .stat-counter-num {
            font-family: var(--font-heading);
            font-size: clamp(2.2rem, 4vw, 3.2rem);
            font-weight: 700;
            color: var(--gold-primary);
            line-height: 1;
        }

        .stat-counter-item {
            border-right: 1px solid rgba(255, 255, 255, 0.1);
        }

        .stat-counter-item:last-child {
            border-right: none;
        }

        .tradition-card {
            border-radius: 18px;
            overflow: hidden;
            position: relative;
            height: 320px;
            display: flex;
            align-items: flex-end;
        }

        .tradition-card img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease;
        }

        .tradition-card:hover img {
            transform: scale(1.08);
        }

        .tradition-card .tradition-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(7, 15, 30, 0.95) 0%, rgba(7, 15, 30, 0.5) 45%, transparent 80%);
        }

        .tradition-card .tradition-body {
            position: relative;
            z-index: 2;
            padding: 1.5rem;
            color: #fff;
        }

        .tradition-card .tradition-icon {
            width: 42px;
            height: 42px;
            background: var(--gold-primary);
            color: #0B192C;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 0.75rem;
            font-size: 1.1rem;
        }

        .faculty-photo-wrap {
            width: 100%;
            aspect-ratio: 1/1;
            border-radius: 18px;
            overflow: hidden;
            margin-bottom: 1rem;
            position: relative;
        }

        .faculty-photo-wrap img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .faculty-card:hover .faculty-photo-wrap img {
            transform: scale(1.08);
        }

        .result-band {
            background: linear-gradient(135deg, #C5A059 0%, #E4C185 50%, #A87F3C 100%);
            color: #0B192C;
        }

        .result-num {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: clamp(2rem, 3.5vw, 2.8rem);
            line-height: 1;
        }

        .gallery-item {
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            display: block;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;
            background: rgba(7, 15, 30, 0.55);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 1.6rem;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }
    </style>
@endpush

@section('content')

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show rounded-0 mb-0 text-center" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- ===== 1. HERO SECTION (100% DYNAMIC CMS) ===== -->
    <section class="hero-fullbleed">
        <div class="hero-bg-image"></div>
        <div class="hero-gradient"></div>

        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-8 col-xl-7" data-aos="fade-right">
                    <span class="section-label mb-3">{{ $settings['hero_badge'] ?? 'CBSE Affiliated · Admissions Open 2026-27' }}</span>

                    <h1 class="display-3 fw-bold text-white mb-3"
                        style="font-family: var(--font-heading); line-height: 1.08;">
                        {{ $settings['hero_title'] ?? 'Where Global Minds & Timeless Values Grow' }}
                    </h1>

                    <p class="fs-5 text-white-50 mb-4" style="max-width: 580px; line-height: 1.7;">
                        {{ $settings['hero_subtitle'] ?? 'Junior Gurukul School, Bhikangaon — a CBSE affiliated campus where timeless values and modern learning come together.' }}
                    </p>

                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                        <a href="{{ route('website.admissions') }}" class="btn-gold btn-lg">
                            <i class="bi bi-calendar-event"></i> Apply for 2026-27 <i class="bi bi-arrow-right"></i>
                        </a>
                        <a href="{{ route('website.academics') }}" class="btn-glass-outline">
                            <i class="bi bi-play-circle"></i> Explore Academics
                        </a>
                    </div>
                </div>
            </div>

            <!-- BOTTOM STAT BAR -->
            <div class="mt-5 pt-3" data-aos="fade-up" data-aos-delay="200">
                <div class="hero-stat-bar p-4 rounded-4 d-flex flex-wrap gap-4 text-white">

                    <div class="hero-stat-item d-flex align-items-center gap-3">
                        <div class="hero-stat-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-patch-check-fill fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white small" style="font-family: var(--font-heading);">CBSE Affiliated</div>
                            <div class="small text-white-50" style="font-size: 0.75rem;">Recognised curriculum & board</div>
                        </div>
                    </div>

                    <div class="hero-stat-item d-flex align-items-center gap-3">
                        <div class="hero-stat-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-people fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white small" style="font-family: var(--font-heading);">Pre-Primary to Grade 10</div>
                            <div class="small text-white-50" style="font-size: 0.75rem;">One campus, every stage</div>
                        </div>
                    </div>

                    <div class="hero-stat-item d-flex align-items-center gap-3">
                        <div class="hero-stat-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-mortarboard fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white small" style="font-family: var(--font-heading);">Sanskar + Academics</div>
                            <div class="small text-white-50" style="font-size: 0.75rem;">Values-based, modern teaching</div>
                        </div>
                    </div>

                    <div class="hero-stat-item d-flex align-items-center gap-3">
                        <div class="hero-stat-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-lightbulb fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white small" style="font-family: var(--font-heading);">STEM + Arts</div>
                            <div class="small text-white-50" style="font-size: 0.75rem;">Curiosity, craft & critical thinking</div>
                        </div>
                    </div>

                    <div class="hero-stat-item d-flex align-items-center gap-3">
                        <div class="hero-stat-icon rounded-circle d-flex align-items-center justify-content-center">
                            <i class="bi bi-shield-check fs-4"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-white small" style="font-family: var(--font-heading);">Safe & Nurturing</div>
                            <div class="small text-white-50" style="font-size: 0.75rem;">A caring campus for every child</div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <!-- ===== 2. ABOUT US SECTION ===== -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-6" data-aos="fade-right">
                    <div class="position-relative">
                        <img src="https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80"
                            alt="Principal Welcome" class="img-fluid rounded-4 shadow-lg">
                        <div class="position-absolute bottom-0 start-0 m-4 p-3 bg-navy-dark text-white rounded-3 shadow border-start border-4"
                            style="border-color: var(--gold-primary) !important;">
                            <h6 class="fw-bold mb-0" style="font-family: var(--font-heading);">Principal's Message</h6>
                            <span class="small text-gold">{{ $settings['school_name'] ?? 'Junior Gurukul School' }}</span>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6" data-aos="fade-left">
                    <span class="section-label mb-2">Welcome to Junior Gurukul</span>
                    <h2 class="display-6 fw-bold text-dark mt-2 mb-3" style="font-family: var(--font-heading);">Rooted in Tradition, Preparing for Tomorrow</h2>
                    <p class="text-muted mb-4" style="line-height: 1.8;">
                        {{ $settings['principal_message'] ?? 'At Junior Gurukul School, Bhikangaon, education goes beyond textbooks. We combine the discipline and values of the Gurukul tradition with modern, activity-based CBSE learning.' }}
                    </p>

                    <div class="row g-3">
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 hover-card h-100">
                                <div class="icon-circle mb-2"><i class="bi bi-shield-check"></i></div>
                                <h6 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Safe & Secure Campus</h6>
                                <p class="small text-muted mb-0">Supervised campus, transport care and a nurturing environment.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 hover-card h-100">
                                <div class="icon-circle mb-2"><i class="bi bi-cpu"></i></div>
                                <h6 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">STEM & Computer Lab</h6>
                                <p class="small text-muted mb-0">Hands-on science, computer skills and activity-based learning.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 hover-card h-100">
                                <div class="icon-circle mb-2"><i class="bi bi-trophy"></i></div>
                                <h6 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Sports Ground</h6>
                                <p class="small text-muted mb-0">Open play area for athletics, yoga and team sports.</p>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="p-3 bg-light rounded-3 hover-card h-100">
                                <div class="icon-circle mb-2"><i class="bi bi-person-check"></i></div>
                                <h6 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">Personal Attention</h6>
                                <p class="small text-muted mb-0">Small class sizes for focused, individual mentorship.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== 3. OUR UNIQUE TRADITIONS ===== -->
    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="text-center mx-auto mb-5" style="max-width: 640px;" data-aos="fade-up">
                <span class="section-label justify-content-center mb-2">Our Unique Traditions</span>
                <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">Rooted in Indian Culture, Growing with Knowledge</h2>
                <p class="text-muted mt-2">Where every day begins with values and ends with growth.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="tradition-card">
                        <img src="https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=600&q=80" alt="Sanskar Assembly">
                        <div class="tradition-overlay"></div>
                        <div class="tradition-body">
                            <div class="tradition-icon"><i class="bi bi-sun"></i></div>
                            <h6 class="fw-bold mb-1" style="font-family: var(--font-heading);">Sanskar Assembly</h6>
                            <p class="small text-white-50 mb-0">Daily value education, shlok recitation & mindfulness.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="tradition-card">
                        <img src="https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=600&q=80" alt="Yoga & Wellness">
                        <div class="tradition-overlay"></div>
                        <div class="tradition-body">
                            <div class="tradition-icon"><i class="bi bi-heart-pulse"></i></div>
                            <h6 class="fw-bold mb-1" style="font-family: var(--font-heading);">Yoga & Wellness</h6>
                            <p class="small text-white-50 mb-0">Building a strong body and a calm, focused mind.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="tradition-card">
                        <img src="https://images.unsplash.com/photo-1604881991720-f91add269bed?auto=format&fit=crop&w=600&q=80" alt="Cultural Festivals">
                        <div class="tradition-overlay"></div>
                        <div class="tradition-body">
                            <div class="tradition-icon"><i class="bi bi-stars"></i></div>
                            <h6 class="fw-bold mb-1" style="font-family: var(--font-heading);">Cultural Heritage</h6>
                            <p class="small text-white-50 mb-0">Celebrating Indian festivals with joy, colour and meaning.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="tradition-card">
                        <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80" alt="Guru-Shishya Mentorship">
                        <div class="tradition-overlay"></div>
                        <div class="tradition-body">
                            <div class="tradition-icon"><i class="bi bi-people"></i></div>
                            <h6 class="fw-bold mb-1" style="font-family: var(--font-heading);">Guru-Shishya Bond</h6>
                            <p class="small text-white-50 mb-0">Personal guidance and mentorship rooted in tradition.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== 4. ACADEMIC PROGRAM PATHWAYS ===== -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="text-center mx-auto mb-5" style="max-width: 640px;" data-aos="fade-up">
                <span class="section-label justify-content-center mb-2">Academic Pathways</span>
                <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">A Structured Curriculum for Every Age</h2>
                <p class="text-muted mt-2">Designed to ignite curiosity, logical thinking and strong foundations.</p>
            </div>

            <div class="row g-4">
                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="hover-card h-100 d-flex flex-column border">
                        <div class="card-img-wrapper" style="height: 180px;">
                            <img src="https://images.unsplash.com/photo-1503676260728-1c00da094a0b?auto=format&fit=crop&w=600&q=80"
                                class="w-100 h-100 object-fit-cover" alt="Pre Primary">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <span class="badge-gold mb-2" style="font-size: 0.7rem;">Foundation Stage</span>
                            <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Pre-Primary</h5>
                            <p class="small text-muted mb-3 flex-grow-1">Play-based experiential learning, sensory activities and motor skills development.</p>
                            <a href="{{ route('website.academics') }}" class="link-arrow">Learn More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="200">
                    <div class="hover-card h-100 d-flex flex-column border">
                        <div class="card-img-wrapper" style="height: 180px;">
                            <img src="https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=600&q=80"
                                class="w-100 h-100 object-fit-cover" alt="Primary">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <span class="badge-gold mb-2" style="font-size: 0.7rem;">Primary Wing</span>
                            <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Primary (Grade 1-5)</h5>
                            <p class="small text-muted mb-3 flex-grow-1">Core foundational literacy, arithmetic, environmental science and creative arts.</p>
                            <a href="{{ route('website.academics') }}" class="link-arrow">Learn More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="300">
                    <div class="hover-card h-100 d-flex flex-column border">
                        <div class="card-img-wrapper" style="height: 180px;">
                            <img src="https://images.unsplash.com/photo-1427504494785-3a9ca7044f45?auto=format&fit=crop&w=600&q=80"
                                class="w-100 h-100 object-fit-cover" alt="Middle">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <span class="badge-gold mb-2" style="font-size: 0.7rem;">Middle School</span>
                            <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Middle (Grade 6-8)</h5>
                            <p class="small text-muted mb-3 flex-grow-1">Inquiry-driven science experiments, computer basics and language mastery.</p>
                            <a href="{{ route('website.academics') }}" class="link-arrow">Learn More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3" data-aos="fade-up" data-aos-delay="400">
                    <div class="hover-card h-100 d-flex flex-column border">
                        <div class="card-img-wrapper" style="height: 180px;">
                            <img src="https://images.unsplash.com/photo-1524178232363-1fb2b075b655?auto=format&fit=crop&w=600&q=80"
                                class="w-100 h-100 object-fit-cover" alt="Secondary">
                        </div>
                        <div class="p-4 d-flex flex-column flex-grow-1">
                            <span class="badge-gold mb-2" style="font-size: 0.7rem;">Secondary CBSE</span>
                            <h5 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">Secondary (Grade 9-10)</h5>
                            <p class="small text-muted mb-3 flex-grow-1">Rigorous CBSE board exam preparation with dedicated academic mentorship.</p>
                            <a href="{{ route('website.academics') }}" class="link-arrow">Learn More <i class="bi bi-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== 5. DYNAMIC STATS COUNTER STRIP ===== -->
    <section class="stat-counter-strip py-5">
        <div class="container py-3">
            <div class="row g-4 text-center text-white">
                <div class="col-6 col-lg-3 stat-counter-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-counter-num">{{ $stats['students'] }}</div>
                    <div class="text-white-50 small text-uppercase mt-1" style="letter-spacing: 1px;">Enrolled Students</div>
                </div>
                <div class="col-6 col-lg-3 stat-counter-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-counter-num">{{ $stats['faculty'] }}</div>
                    <div class="text-white-50 small text-uppercase mt-1" style="letter-spacing: 1px;">Faculty Mentors</div>
                </div>
                <div class="col-6 col-lg-3 stat-counter-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="stat-counter-num">{{ $stats['years'] }}</div>
                    <div class="text-white-50 small text-uppercase mt-1" style="letter-spacing: 1px;">Academic Years</div>
                </div>
                <div class="col-6 col-lg-3 stat-counter-item" data-aos="fade-up" data-aos-delay="400">
                    <div class="stat-counter-num">{{ $stats['classes'] }}</div>
                    <div class="text-white-50 small text-uppercase mt-1" style="letter-spacing: 1px;">Active Classes</div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== 6. MEET OUR FACULTY (DYNAMIC SWIPER SLIDER TOP 5-8) ===== -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="d-flex flex-wrap align-items-end justify-content-between mb-5" data-aos="fade-up">
                <div>
                    <span class="section-label mb-2">Our Educators</span>
                    <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">Meet Our Faculty Mentors</h2>
                </div>
                <a href="{{ route('website.faculty') }}" class="link-arrow d-none d-md-inline-flex">View All Faculty <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="swiper" id="facultySwiper" data-aos="fade-up" data-aos-delay="150">
                <div class="swiper-wrapper pb-5">
                    @forelse($teachers as $teacher)
                        <div class="swiper-slide">
                            <div class="faculty-card hover-card p-3 rounded-4 h-100 bg-white">
                                <div class="faculty-photo-wrap mb-3">
                                    <img src="{{ $teacher->photo ?? 'https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80' }}" alt="{{ $teacher->full_name }}">
                                </div>
                                <h6 class="fw-bold text-dark mb-1" style="font-family: var(--font-heading);">{{ $teacher->full_name }}</h6>
                                <span class="badge-gold mb-2" style="font-size: 0.68rem;">{{ $teacher->designation ?? 'Senior Faculty' }}</span>
                                <p class="small text-muted mb-0">{{ $teacher->qualification ?? 'M.Sc. Education' }}</p>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="faculty-card p-3 rounded-4 bg-white">
                                <div class="faculty-photo-wrap mb-3"><img src="https://images.unsplash.com/photo-1580489944761-15a19d654956?auto=format&fit=crop&w=400&q=80" alt="Teacher"></div>
                                <h6 class="fw-bold text-dark mb-1">Anita Sharma</h6>
                                <span class="badge-gold mb-2">Primary Wing Head</span>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- ===== 7. TESTIMONIALS (DYNAMIC SWIPER SLIDER TOP 5-8) ===== -->
    <section class="py-5 bg-navy-bg text-white">
        <div class="container py-4">
            <div class="text-center mx-auto mb-5" style="max-width: 640px;" data-aos="fade-up">
                <span class="section-label justify-content-center mb-2">Parents & Community</span>
                <h2 class="display-6 fw-bold text-white mt-1" style="font-family: var(--font-heading);">What Our Parents Say</h2>
            </div>

            <div class="swiper" id="testimonialSwiper" data-aos="fade-up" data-aos-delay="150">
                <div class="swiper-wrapper pb-5">
                    @forelse($testimonials as $t)
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <i class="bi bi-quote d-block mb-2"></i>
                                <p class="text-white-50 mb-4" style="line-height: 1.7;">"{{ $t->content }}"</p>
                                <div class="d-flex align-items-center gap-3 border-top border-secondary pt-3">
                                    <div class="rounded-circle text-navy fw-bold d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; background: linear-gradient(145deg, #E4C185, #C5A059); color: #0B192C;">
                                        {{ strtoupper(substr($t->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold small text-white" style="font-family: var(--font-heading);">{{ $t->name }}</div>
                                        <div class="text-white-50" style="font-size: 0.75rem;">{{ $t->role }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="testimonial-card">
                                <i class="bi bi-quote d-block mb-2"></i>
                                <p class="text-white-50 mb-4">"Junior Gurukul School has given my daughter a strong foundation in both academics and values."</p>
                                <div class="fw-bold small text-white">Sunita Patidar</div>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- ===== 8. PHOTO GALLERY (DYNAMIC SWIPER SLIDER TOP 5-8) ===== -->
    <section class="py-5 bg-light">
        <div class="container py-4">
            <div class="d-flex flex-wrap align-items-end justify-content-between mb-5" data-aos="fade-up">
                <div>
                    <span class="section-label mb-2">Campus Moments</span>
                    <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">Photo Gallery</h2>
                </div>
                <a href="{{ route('website.gallery') }}" class="link-arrow d-none d-md-inline-flex">View Full Gallery <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="swiper" id="gallerySwiper" data-aos="fade-up" data-aos-delay="150">
                <div class="swiper-wrapper pb-5">
                    @forelse($galleries as $g)
                        <div class="swiper-slide">
                            <a href="{{ $g->image_path }}" class="gallery-item glightbox d-block rounded-4 overflow-hidden position-relative" style="height: 250px;">
                                <img src="{{ $g->image_path }}" class="w-100 h-100 object-fit-cover" alt="{{ $g->title }}">
                                <div class="gallery-overlay"><i class="bi bi-zoom-in"></i></div>
                            </a>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <a href="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1200&q=80" class="gallery-item glightbox d-block rounded-4 overflow-hidden position-relative" style="height: 250px;">
                                <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80" alt="Campus">
                                <div class="gallery-overlay"><i class="bi bi-zoom-in"></i></div>
                            </a>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- ===== 9. LATEST EVENTS & NEWS (DYNAMIC SWIPER SLIDER TOP 5-8) ===== -->
    <section class="py-5 bg-white">
        <div class="container py-4">
            <div class="d-flex flex-wrap align-items-end justify-content-between mb-5" data-aos="fade-up">
                <div>
                    <span class="section-label mb-2">Stay Updated</span>
                    <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">Latest Events & News</h2>
                </div>
                <a href="{{ route('website.news') }}" class="link-arrow d-none d-md-inline-flex">View All News <i class="bi bi-arrow-right"></i></a>
            </div>

            <div class="swiper" id="newsSwiper" data-aos="fade-up" data-aos-delay="150">
                <div class="swiper-wrapper pb-5">
                    @forelse($newsList as $n)
                        <div class="swiper-slide">
                            <div class="hover-card h-100 border">
                                <div class="card-img-wrapper position-relative" style="height: 190px;">
                                    <span class="news-date-badge">{{ $n->published_at ? $n->published_at->format('d M') : 'Sep 15' }}</span>
                                    <img src="https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=600&q=80" class="w-100 h-100 object-fit-cover" alt="News Image">
                                </div>
                                <div class="p-4">
                                    <h6 class="fw-bold text-dark mb-2" style="font-family: var(--font-heading);">{{ $n->title }}</h6>
                                    <p class="small text-muted mb-2">{{ \Illuminate\Support\Str::limit($n->summary, 80) }}</p>
                                    <a href="{{ route('website.news') }}" class="link-arrow">Read Article <i class="bi bi-arrow-right"></i></a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="hover-card h-100 border p-4">
                                <h6 class="fw-bold text-dark">Admissions Open 2026-27</h6>
                                <p class="small text-muted">Applications are now open across Grade 1 to 10.</p>
                            </div>
                        </div>
                    @endforelse
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- ===== 10. QUICK ADMISSION ENQUIRY FORM ===== -->
    <section class="py-5 bg-light" id="quickEnquiry">
        <div class="container py-4">
            <div class="row align-items-center g-5">
                <div class="col-lg-5" data-aos="fade-right">
                    <span class="section-label mb-2">Quick Enquiry</span>
                    <h2 class="display-6 fw-bold text-dark mt-1" style="font-family: var(--font-heading);">Have Questions? Send Us a Message</h2>
                    <p class="text-muted" style="line-height: 1.7;">
                        Interested in enrolling your child at Junior Gurukul School, Bhikangaon? Fill out the quick form and our admissions desk will get in touch with you.
                    </p>
                    <div class="d-flex flex-column gap-2 mt-4 text-dark small fw-medium">
                        <div><i class="bi bi-telephone-fill text-gold me-2"></i> 096176 14788</div>
                        <div><i class="bi bi-envelope-fill text-gold me-2"></i> info@juniorgurukulschool.in</div>
                        <div><i class="bi bi-geo-alt-fill text-gold me-2"></i> Kedwa Road, Bhikangaon, Madhya Pradesh</div>
                    </div>
                </div>

                <div class="col-lg-7" data-aos="fade-left">
                    <div class="bg-white p-4 p-md-5 rounded-4 shadow-sm border border-secondary border-opacity-10">
                        <form action="{{ route('website.enquiry.submit') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Parent / Guardian Name *</label>
                                    <input type="text" name="parent_name" class="form-control" placeholder="Enter your full name" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Mobile Phone Number *</label>
                                    <input type="tel" name="phone" class="form-control" placeholder="10-digit phone number" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Student Name</label>
                                    <input type="text" name="student_name" class="form-control" placeholder="Child's name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small fw-bold text-dark">Grade Seeking Admission</label>
                                    <select name="grade_seeking" class="form-select">
                                        <option value="">Select Grade Level</option>
                                        <option value="Pre-Primary">Pre-Primary (Nursery/KG)</option>
                                        <option value="Grade 1-5">Primary (Grade 1 to 5)</option>
                                        <option value="Grade 6-8">Middle School (Grade 6 to 8)</option>
                                        <option value="Grade 9-10">Secondary CBSE (Grade 9 & 10)</option>
                                    </select>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small fw-bold text-dark">Message / Questions</label>
                                    <textarea name="message" class="form-control" rows="3" placeholder="How can we help you?"></textarea>
                                </div>
                                <div class="col-12 mt-4">
                                    <button type="submit" class="btn-gold w-100 justify-content-center py-3">
                                        Submit Quick Enquiry <i class="bi bi-send-fill ms-2"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== 11. READY TO JOIN OUR FAMILY (FINAL CTA) ===== -->
    <section class="final-cta-section  py-5 text-white text-center">
        <div class="container py-4" data-aos="zoom-in" style="position: relative; z-index: 2;">
            <span class="section-label justify-content-center mb-2">Admissions 2026-27</span>
            <h2 class="display-5 fw-bold text-white mt-2 mb-3" style="font-family: var(--font-heading);">Ready to Join Our Family?</h2>
            <p class="fs-5 text-white-50 mx-auto mb-4" style="max-width: 620px;">
                Admissions open from Basant Panchami (January). Visit us at Kedwa Road, Bhikangaon, and take the first step towards your child's bright future.
            </p>
            <div class="d-flex flex-wrap justify-content-center gap-3">
                <a href="{{ route('website.admissions') }}" class="btn-gold btn-lg">
                    Apply Online Now <i class="bi bi-arrow-right"></i>
                </a>
                <a href="tel:+919617614788" class="btn-glass-outline btn-lg">
                    <i class="bi bi-telephone-fill"></i> Call 096176 14788
                </a>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Testimonials Swiper
            new Swiper('#testimonialSwiper', {
                slidesPerView: 1,
                spaceBetween: 24,
                loop: true,
                autoplay: { delay: 4500, disableOnInteraction: false },
                pagination: { el: '#testimonialSwiper .swiper-pagination', clickable: true },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    1200: { slidesPerView: 3 }
                }
            });

            // Faculty Swiper
            new Swiper('#facultySwiper', {
                slidesPerView: 2,
                spaceBetween: 20,
                loop: true,
                autoplay: { delay: 4000, disableOnInteraction: false },
                pagination: { el: '#facultySwiper .swiper-pagination', clickable: true },
                breakpoints: {
                    768: { slidesPerView: 3 },
                    1200: { slidesPerView: 4 }
                }
            });

            // Gallery Swiper
            new Swiper('#gallerySwiper', {
                slidesPerView: 2,
                spaceBetween: 16,
                loop: true,
                autoplay: { delay: 3800, disableOnInteraction: false },
                pagination: { el: '#gallerySwiper .swiper-pagination', clickable: true },
                breakpoints: {
                    768: { slidesPerView: 3 },
                    1200: { slidesPerView: 4 }
                }
            });

            // News Swiper
            new Swiper('#newsSwiper', {
                slidesPerView: 1,
                spaceBetween: 20,
                loop: true,
                autoplay: { delay: 5000, disableOnInteraction: false },
                pagination: { el: '#newsSwiper .swiper-pagination', clickable: true },
                breakpoints: {
                    768: { slidesPerView: 2 },
                    1200: { slidesPerView: 3 }
                }
            });
        });
    </script>
@endpush