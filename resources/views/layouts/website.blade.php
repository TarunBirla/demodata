<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Junior Gurukul School | A Tradition of Excellence')</title>
    <meta name="description"
        content="@yield('meta_description', 'Junior Gurukul School, Bhikangaon — a CBSE affiliated school blending traditional values with modern, holistic education for every child.')">
    <meta property="og:title" content="@yield('title', 'Junior Gurukul School | A Tradition of Excellence')">
    <meta property="og:description"
        content="@yield('meta_description', 'A CBSE affiliated school in Bhikangaon, Madhya Pradesh, nurturing character, curiosity and academic excellence.')">
    <meta property="og:type" content="website">
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Google Fonts: Space Grotesk & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Grotesk:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Bootstrap 5 CSS & Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- AOS.js Scroll Animations CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <!-- Swiper.js Slider CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- GLightbox Photo Gallery Lightbox CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

    <style>
        :root {
            --navy-dark: #070F1E;
            --navy-bg: #0B192C;
            --navy-card: #13243B;
            --gold-primary: #C5A059;
            --gold-hover: #B38E46;
            --gold-light: #F4E8D0;
            --text-white: #FFFFFF;
            --text-muted: #94A3B8;
            --font-heading: 'Space Grotesk', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        * {
            font-family: var(--font-body);
        }

        body {
            font-family: var(--font-body);
            color: #1E293B;
            background-color: #F8FAFC;
            overflow-x: hidden;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .font-heading,
        .navbar-brand,
        .nav-link-custom,
        .dropdown-item-custom,
        .btn-gold,
        .btn-glass-outline,
        .btn-outline-gold {
            font-family: var(--font-heading) !important;
            letter-spacing: -0.01em;
        }

        section-label,
        .section-label {
            font-family: var(--font-heading);
        }

        /* ===== Luxury Dark Theme Utilities ===== */
        .bg-navy-dark {
            background-color: var(--navy-dark) !important;
        }

        .bg-navy-bg {
            background-color: var(--navy-bg) !important;
        }

        .bg-navy-card {
            background-color: var(--navy-card) !important;
        }

        .text-gold {
            color: var(--gold-primary) !important;
        }

        .section-label {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-weight: 700;
            font-size: 0.78rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold-primary);
        }

        .section-label::before {
            content: "";
            width: 26px;
            height: 2px;
            background: var(--gold-primary);
            display: inline-block;
        }

        /* ===== Premium Buttons (outstanding level) ===== */
        .btn-gold,
        .btn-glass-outline,
        .btn-outline-gold {
            font-weight: 700;
            font-size: 0.92rem;
            border: none;
            padding: 0.8rem 1.75rem;
            border-radius: 50px;
            position: relative;
            overflow: hidden;
            display: inline-flex;
            align-items: center;
            gap: 0.55rem;
            text-decoration: none;
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
            isolation: isolate;
        }

        .btn-gold {
            background: linear-gradient(135deg, #E4C185 0%, var(--gold-primary) 45%, #A87F3C 100%);
            color: #0B192C;
            box-shadow: 0 6px 20px rgba(197, 160, 89, 0.35), inset 0 1px 0 rgba(255, 255, 255, 0.4);
        }

        .btn-gold::before {
            content: "";
            position: absolute;
            inset: 0;
            z-index: -1;
            background: linear-gradient(120deg, transparent 20%, rgba(255, 255, 255, 0.55) 45%, transparent 70%);
            transform: translateX(-120%);
            transition: transform 0.6s ease;
        }

        .btn-gold:hover {
            color: #0B192C;
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(197, 160, 89, 0.5), inset 0 1px 0 rgba(255, 255, 255, 0.5);
        }

        .btn-gold:hover::before {
            transform: translateX(120%);
        }

        .btn-gold:active {
            transform: translateY(-1px) scale(0.98);
        }

        .btn-gold.btn-lg {
            padding: 1rem 2.25rem;
            font-size: 1rem;
        }

        .btn-glass-outline {
            background: rgba(255, 255, 255, 0.06);
            border: 1.5px solid rgba(255, 255, 255, 0.28);
            color: #FFFFFF;
            font-weight: 600;
            backdrop-filter: blur(12px);
        }

        .btn-glass-outline:hover {
            background: rgba(197, 160, 89, 0.12);
            border-color: var(--gold-primary);
            color: var(--gold-primary);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .btn-outline-gold {
            background: transparent;
            border: 1.5px solid var(--gold-primary);
            color: var(--gold-primary);
            font-weight: 600;
        }

        .btn-outline-gold:hover {
            background: var(--gold-primary);
            color: #0B192C;
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(197, 160, 89, 0.35);
        }

        .link-arrow {
            color: var(--gold-primary);
            font-weight: 700;
            text-decoration: none;
            font-size: 0.88rem;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            position: relative;
        }

        .link-arrow i {
            transition: transform 0.3s ease;
        }

        .link-arrow:hover {
            color: var(--gold-hover);
        }

        .link-arrow:hover i {
            transform: translateX(5px);
        }

        /* ===== Glassmorphism Header ===== */
        .header-navbar {
            background: rgba(11, 25, 44, 0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s ease;
        }

        .header-navbar.shrunk {
            padding-top: 0.5rem !important;
            padding-bottom: 0.5rem !important;
            background: rgba(7, 15, 30, 0.98);
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.3);
        }

        .brand-mark {
            width: 46px;
            height: 46px;
            background: linear-gradient(145deg, #E4C185, #C5A059 55%, #8E6A32);
            color: #0B192C;
            border: 1px solid rgba(255, 255, 255, 0.25);
            box-shadow: 0 4px 14px rgba(197, 160, 89, 0.4), inset 0 1px 1px rgba(255, 255, 255, 0.5);
        }

        /* ===== Hover Dropdown Navigation ===== */
        .nav-item.dropdown:hover .dropdown-menu-custom {
            display: block;
            margin-top: 0;
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-menu-custom {
            display: block;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transform: translateY(10px);
            transition: all 0.25s ease;
            background: rgba(11, 25, 44, 0.98);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(197, 160, 89, 0.25);
            border-radius: 14px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.45);
            padding: 0.6rem 0;
            min-width: 250px;
        }

        .nav-item.dropdown:hover .dropdown-menu-custom {
            pointer-events: auto;
        }

        .dropdown-item-custom {
            color: rgba(255, 255, 255, 0.85);
            font-size: 0.88rem;
            font-weight: 500;
            padding: 0.6rem 1.25rem;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .dropdown-item-custom i {
            color: var(--gold-primary);
            font-size: 0.95rem;
        }

        .dropdown-item-custom:hover {
            color: var(--gold-primary);
            background: rgba(197, 160, 89, 0.1);
            padding-left: 1.5rem;
        }

        /* ===== Final CTA & Footer Styling ===== */
        .final-cta-section {
            background: linear-gradient(135deg, #070F1E 0%, #112544 50%, #0B192C 100%);
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(197, 160, 89, 0.25);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: inset 0 0 100px rgba(0, 0, 0, 0.5);
        }

        .final-cta-section::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: radial-gradient(circle, rgba(197, 160, 89, 0.12) 0%, transparent 60%);
            pointer-events: none;
        }

        .footer-dark {
            background: #070F1E;
            color: rgba(255, 255, 255, 0.75);
            padding-top: 4.5rem;
            padding-bottom: 2rem;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
        }

        .social-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.08);
            color: var(--gold-primary);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid rgba(197, 160, 89, 0.2);
        }

        .social-icon:hover {
            background: var(--gold-primary);
            color: #0B192C;
            transform: translateY(-3px);
            box-shadow: 0 6px 15px rgba(197, 160, 89, 0.35);
        }

        .nav-link-custom {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            font-size: 0.92rem;
            padding: 0.6rem 0.9rem !important;
            transition: color 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            position: relative;
        }

        .nav-link-custom::after {
            content: "";
            position: absolute;
            left: 0.9rem;
            right: 0.9rem;
            bottom: 2px;
            height: 2px;
            background: var(--gold-primary);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.25s ease;
        }

        .nav-link-custom:hover,
        .nav-link-custom.active {
            color: var(--gold-primary) !important;
        }

        .nav-link-custom:hover::after,
        .nav-link-custom.active::after {
            transform: scaleX(1);
        }

        /* ===== Cards & Hover Effects ===== */
        .hover-card {
            background: #FFFFFF;
            border-radius: 18px;
            border: 1px solid #E2E8F0;
            overflow: hidden;
            transition: all 0.35s cubic-bezier(0.165, 0.84, 0.44, 1);
        }

        .hover-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 45px rgba(11, 25, 44, 0.12);
            border-color: var(--gold-primary);
        }

        .hover-card .card-img-wrapper {
            overflow: hidden;
            position: relative;
        }

        .hover-card .card-img-wrapper img {
            transition: transform 0.6s ease;
        }

        .hover-card:hover .card-img-wrapper img {
            transform: scale(1.06);
        }

        .icon-circle {
            width: 52px;
            height: 52px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, rgba(197, 160, 89, 0.15), rgba(197, 160, 89, 0.05));
            color: var(--gold-primary);
            font-size: 1.35rem;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }

        .hover-card:hover .icon-circle {
            background: var(--gold-primary);
            color: #0B192C;
            transform: scale(1.08) rotate(-4deg);
        }

        /* ===== Floating Scroll to Top ===== */
        #scrollTopBtn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            z-index: 999;
            width: 48px;
            height: 48px;
            border-radius: 50%;
            background: linear-gradient(135deg, #E4C185, var(--gold-primary));
            color: #0B192C;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        #scrollTopBtn.show {
            opacity: 1;
            visibility: visible;
        }

        #scrollTopBtn:hover {
            transform: translateY(-4px) scale(1.06);
            box-shadow: 0 8px 26px rgba(197, 160, 89, 0.5);
        }

        .footer-dark {
            background-color: var(--navy-dark);
            color: #94A3B8;
            padding: 70px 0 30px 0;
            border-top: 1px solid rgba(197, 160, 89, 0.15);
        }

        .footer-dark a.social-icon {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1px solid rgba(255, 255, 255, 0.2);
            color: #fff;
            transition: all 0.3s ease;
        }

        .footer-dark a.social-icon:hover {
            background: var(--gold-primary);
            border-color: var(--gold-primary);
            color: #0B192C;
            transform: translateY(-4px);
        }

        .footer-dark ul.list-unstyled a {
            transition: all 0.2s ease;
        }

        .footer-dark ul.list-unstyled a:hover {
            color: var(--gold-primary) !important;
            padding-left: 4px;
        }

        /* ===== Sub-page Breadcrumb Hero & Helper Component Styles ===== */
        .breadcrumb-hero {
            background: linear-gradient(135deg, var(--navy-dark) 0%, var(--navy-bg) 60%, #132742 100%);
            padding: 85px 0 55px;
            position: relative;
            border-bottom: 1px solid rgba(197, 160, 89, 0.2);
        }

        .breadcrumb-trail {
            font-size: 0.88rem;
            color: var(--text-muted);
            font-family: var(--font-heading);
        }

        .breadcrumb-trail a {
            color: var(--gold-primary);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .breadcrumb-trail a:hover {
            color: var(--gold-hover);
        }

        .badge-gold {
            background: rgba(197, 160, 89, 0.15);
            color: var(--gold-primary);
            border: 1px solid rgba(197, 160, 89, 0.3);
            padding: 0.35rem 0.85rem;
            border-radius: 50px;
            font-size: 0.78rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: inline-block;
            font-family: var(--font-heading);
        }

        .icon-circle-lg {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(145deg, rgba(197, 160, 89, 0.2), rgba(197, 160, 89, 0.05));
            color: var(--gold-primary);
            font-size: 1.6rem;
            flex-shrink: 0;
            border: 1px solid rgba(197, 160, 89, 0.25);
        }

        .doc-checklist-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            background: #F8FAFC;
            border-radius: 12px;
            margin-bottom: 10px;
            font-weight: 500;
            border: 1px solid #E2E8F0;
        }

        .doc-checklist-item i {
            color: var(--gold-primary);
            font-size: 1.2rem;
        }

        .step-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 16px;
            padding: 20px 16px;
            text-center;
            transition: all 0.3s ease;
        }

        .step-card:hover {
            border-color: var(--gold-primary);
            transform: translateY(-4px);
            box-shadow: 0 12px 30px rgba(11, 25, 44, 0.08);
        }

        .step-card .step-num {
            font-family: var(--font-heading);
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--gold-primary);
            line-height: 1;
            margin-bottom: 6px;
        }
    </style>
    @stack('styles')
</head>

<body>

    <!-- STICKY HEADER WITH HOVER DROPDOWNS -->
    <nav class="navbar navbar-expand-xl navbar-dark header-navbar sticky-top py-3" id="mainHeader">
        <div class="container">
            <!-- Brand Logo Left -->
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('website.home') }}">
                <div class="brand-mark rounded-3 d-flex align-items-center justify-content-center">
                    <i class="bi bi-mortarboard-fill fs-5"></i>
                </div>
                <div>
                    <span class="fw-bold fs-5 text-white d-block lh-1"
                        style="font-family: var(--font-heading); letter-spacing: 0.3px;">JUNIOR GURUKUL</span>
                    <span class="text-gold small text-uppercase fw-semibold"
                        style="font-size: 0.63rem; letter-spacing: 1.8px;">School · Bhikangaon, M.P.</span>
                </div>
            </a>

            <!-- Toggler for Mobile -->
            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#mobileMenuDrawer">
                <i class="bi bi-list text-white fs-1"></i>
            </button>

            <!-- Center Menu Items with Hover Dropdowns -->
            <div class="collapse navbar-collapse d-none d-xl-flex">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0 align-items-center gap-1">
                    <li class="nav-item"><a
                            class="nav-link nav-link-custom {{ request()->routeIs('website.home') ? 'active' : '' }}"
                            href="{{ route('website.home') }}">Home</a></li>

                    <!-- About Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="{{ route('website.about') }}"
                            id="aboutDropdown">
                            About <i class="bi bi-chevron-down small"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('website.about') }}"><i
                                        class="bi bi-clock-history"></i> School History & Legacy</a></li>
                            <li><a class="dropdown-item dropdown-item-custom"
                                    href="{{ route('website.about') }}#principal"><i class="bi bi-person-badge"></i>
                                    Principal's Message</a></li>
                            <li><a class="dropdown-item dropdown-item-custom"
                                    href="{{ route('website.about') }}#vision"><i class="bi bi-stars"></i> Vision &
                                    Mission</a></li>

                                    <li ><a
                            class="dropdown-item dropdown-item-custom"
                            href="{{ route('website.news') }}"><i class="bi bi-newspaper"></i>    News</a></li>
                    <li ><a
                            class="dropdown-item dropdown-item-custom"
                            href="{{ route('website.contact') }}"><i class="bi bi-telephone"></i>   Contact</a></li>
                        </ul>
                    </li>

                    <!-- Academics Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="{{ route('website.academics') }}"
                            id="academicsDropdown">
                            Academics <i class="bi bi-chevron-down small"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('website.academics') }}"><i
                                        class="bi bi-flower1"></i> Pre-Primary Curriculum</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('website.academics') }}"><i
                                        class="bi bi-book"></i> Primary School (Grades 1-5)</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('website.academics') }}"><i
                                        class="bi bi-journal-bookmark"></i> Middle School (Grades 6-8)</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('website.academics') }}"><i
                                        class="bi bi-mortarboard"></i> Secondary CBSE (Grades 9-10)</a></li>
                        </ul>
                    </li>

                    <!-- Admissions Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="{{ route('website.admissions') }}"
                            id="admissionsDropdown">
                            Admissions <i class="bi bi-chevron-down small"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item dropdown-item-custom"
                                    href="{{ route('website.admissions') }}"><i class="bi bi-list-check"></i> Admission
                                    Process 2026-27</a></li>
                            <li><a class="dropdown-item dropdown-item-custom"
                                    href="{{ route('website.admissions') }}#checklist"><i
                                        class="bi bi-file-earmark-check"></i> Required Document Checklist</a></li>
                            <li><a class="dropdown-item dropdown-item-custom"
                                    href="{{ route('website.admissions') }}#apply"><i class="bi bi-pencil-square"></i>
                                    Online Application Form</a></li>
                        </ul>
                    </li>

                    <!-- Campus Life Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link nav-link-custom dropdown-toggle" href="{{ route('website.facilities') }}"
                            id="campusDropdown">
                            Campus Life <i class="bi bi-chevron-down small"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-custom">
                            <li><a class="dropdown-item dropdown-item-custom"
                                    href="{{ route('website.facilities') }}"><i class="bi bi-cpu"></i> STEM & Computer
                                    Labs</a></li>
                            <li><a class="dropdown-item dropdown-item-custom"
                                    href="{{ route('website.facilities') }}"><i class="bi bi-book-half"></i> Library</a>
                            </li>
                            <li><a class="dropdown-item dropdown-item-custom"
                                    href="{{ route('website.facilities') }}"><i class="bi bi-trophy"></i> Sports
                                    Ground</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('website.faculty') }}"><i
                                        class="bi bi-people"></i> Faculty Mentors</a></li>
                            <li><a class="dropdown-item dropdown-item-custom" href="{{ route('website.gallery') }}"><i
                                        class="bi bi-images"></i> Photo Gallery</a></li>
                        </ul>
                    </li>

                    
                </ul>

                <!-- Right Header CTAs -->
                <div class="d-flex align-items-center gap-3">
                    <!-- <div class="dropdown">
                        <button
                            class="btn btn-sm btn-link text-white text-decoration-none dropdown-toggle px-1 fw-medium"
                            style="font-family: var(--font-heading);" type="button" data-bs-toggle="dropdown">
                            <i class="bi bi-globe me-1 text-gold"></i> EN
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end bg-navy-bg border-secondary text-white">
                            <li><a class="dropdown-item text-white small" href="#">English</a></li>
                            <li><a class="dropdown-item text-white small" href="#">Hindi</a></li>
                        </ul>
                    </div> -->

                    <a href="{{ route('auth.login') }}" class="btn-glass-outline me-1" style="padding: 0.55rem 1.15rem; font-size: 0.85rem;">
                        <i class="bi bi-lock-fill text-gold"></i> Login
                    </a>
                    <a href="{{ route('website.admissions') }}" class="btn-gold" style="padding: 0.55rem 1.25rem; font-size: 0.85rem;">
                        Apply <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- MOBILE SLIDE-IN DRAWER -->
    <div class="offcanvas offcanvas-end bg-navy-dark text-white" tabindex="-1" id="mobileMenuDrawer">
        <div class="offcanvas-header border-bottom border-secondary">
            <div class="d-flex align-items-center gap-2">
                <div class="brand-mark rounded d-flex align-items-center justify-content-center"
                    style="width: 38px; height: 38px;"><i class="bi bi-mortarboard-fill"></i></div>
                <span class="fw-bold text-white fs-5" style="font-family: var(--font-heading);">Junior Gurukul</span>
            </div>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column justify-content-between">
            <ul class="nav flex-column gap-2">
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.home') }}">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.about') }}">About Us</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.academics') }}">Academics</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.faculty') }}">Faculty Mentors</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.facilities') }}">Facilities</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.admissions') }}">Admissions</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.gallery') }}">Gallery</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.news') }}">News & Events</a></li>
                <li class="nav-item"><a class="nav-link text-white fs-5 py-2" style="font-family: var(--font-heading);"
                        href="{{ route('website.contact') }}">Contact Us</a></li>
            </ul>

            <div class="pt-4 border-top border-secondary">
                <a href="{{ route('website.admissions') }}"
                    class="btn btn-gold w-100 py-3 mb-2 justify-content-center">Apply Now 2026-27 <i
                        class="bi bi-arrow-right ms-1"></i></a>
                <a href="{{ route('auth.login') }}"
                    class="btn btn-glass-outline w-100 py-2.5 justify-content-center">Login</a>
            </div>
        </div>
    </div>

    <!-- MAIN CONTENT -->
    <main>
        @yield('content')
    </main>

    <!-- FOOTER -->
    <footer class="footer-dark">
        <div class="container">
            <div class="row g-4 mb-5">
                <div class="col-lg-4 col-md-6" data-aos="fade-up">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <div class="brand-mark rounded d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;"><i class="bi bi-mortarboard-fill"></i></div>
                        <h4 class="fw-bold text-white mb-0" style="font-family: var(--font-heading);">JUNIOR GURUKUL
                            SCHOOL</h4>
                    </div>
                    <p class="text-white-50 small mb-4" style="line-height: 1.7;">
                        A Tradition of Excellence — blending timeless values with modern, holistic education to shape
                        confident, capable learners.
                    </p>
                    <div class="d-flex gap-2">
                        <a href="#" class="social-icon"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-youtube"></i></a>
                        <a href="#" class="social-icon"><i class="bi bi-whatsapp"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <h6 class="fw-bold text-gold text-uppercase mb-3"
                        style="font-size: 0.85rem; letter-spacing: 1px; font-family: var(--font-heading);">Quick Links
                    </h6>
                    <ul class="list-unstyled d-flex flex-column gap-2 small">
                        <li><a href="{{ route('website.about') }}" class="text-white-50 text-decoration-none">About
                                Us</a></li>
                        <li><a href="{{ route('website.academics') }}"
                                class="text-white-50 text-decoration-none">Academics</a></li>
                        <li><a href="{{ route('website.faculty') }}" class="text-white-50 text-decoration-none">Faculty
                                Mentors</a></li>
                        <li><a href="{{ route('website.facilities') }}"
                                class="text-white-50 text-decoration-none">Facilities</a></li>
                        <li><a href="{{ route('website.admissions') }}"
                                class="text-white-50 text-decoration-none">Admissions</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <h6 class="fw-bold text-gold text-uppercase mb-3"
                        style="font-size: 0.85rem; letter-spacing: 1px; font-family: var(--font-heading);">Contact Desk
                    </h6>
                    <ul class="list-unstyled d-flex flex-column gap-3 small text-white-50">
                        <li class="d-flex gap-2"><i class="bi bi-geo-alt-fill text-gold mt-1"></i> <span>Junior Gurukul
                                School, Seavri Dhaam, Bhikangaon, Panchamba, Madhya Pradesh 451331</span></li>
                        <li class="d-flex gap-2"><i class="bi bi-telephone-fill text-gold mt-1"></i> <a
                                href="tel:+919617614788" class="text-white-50 text-decoration-none">096176 14788</a>
                        </li>
                        <li class="d-flex gap-2"><i class="bi bi-envelope-fill text-gold mt-1"></i> <a
                                href="mailto:info@juniorgurukulschool.in"
                                class="text-white-50 text-decoration-none">info@juniorgurukulschool.in</a></li>
                    </ul>
                </div>

                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <h6 class="fw-bold text-gold text-uppercase mb-3"
                        style="font-size: 0.85rem; letter-spacing: 1px; font-family: var(--font-heading);">Admissions
                        Open</h6>
                    <p class="small text-white-50 mb-3">Enrolling for Academic Session 2026-27 across Pre-Primary to
                        Grade 10.</p>
                    <a href="{{ route('website.admissions') }}" class="btn-gold w-100 justify-content-center py-2.5">
                        Apply Now <i class="bi bi-arrow-right"></i>
                    </a>
                </div>
            </div>

            <div
                class="border-top border-secondary pt-3 text-center small text-white-50 d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
                <div>&copy; {{ date('Y') }} Junior Gurukul School, Bhikangaon. All Rights Reserved.</div>
                <a href="{{ route('auth.login') }}" class="text-gold text-decoration-none"><i
                        class="bi bi-lock-fill"></i> Employee Portal Login</a>
            </div>
        </div>
    </footer>

    <!-- SCROLL TO TOP BUTTON -->
    <button id="scrollTopBtn" title="Back to top"><i class="bi bi-arrow-up"></i></button>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AOS.js Scroll Animation JS -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <!-- Swiper.js Slider JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- GLightbox Photo Gallery JS -->
    <script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            AOS.init({ duration: 800, once: true, offset: 100 });
            GLightbox({ selector: '.glightbox' });

            const mainHeader = document.getElementById('mainHeader');
            const scrollTopBtn = document.getElementById('scrollTopBtn');

            window.addEventListener('scroll', function () {
                if (window.scrollY > 80) {
                    mainHeader.classList.add('shrunk');
                    scrollTopBtn.classList.add('show');
                } else {
                    mainHeader.classList.remove('shrunk');
                    scrollTopBtn.classList.remove('show');
                }
            });

            scrollTopBtn.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        });
    </script>
    @stack('scripts')
</body>

</html>