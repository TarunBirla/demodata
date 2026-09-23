@extends('layouts.website')

@section('title', 'Admissions 2026-27 | Junior Gurukul School, Bhikangaon')
@section('meta_description', 'Admissions open for Session 2026-27 at Junior Gurukul School, Bhikangaon — Pre-Primary to Grade 10. Simple 4-step admission process, apply online today.')

@section('content')

<!-- BREADCRUMB HERO -->
<section class="breadcrumb-hero text-white">
    <div class="container position-relative text-center" data-aos="fade-up">
        <div class="breadcrumb-trail mb-3">
            <a href="{{ route('website.home') }}">Home</a> <i class="bi bi-chevron-right"></i> Admissions
        </div>
        <span class="section-label justify-content-center mb-2">Enrollment 2026-27</span>
        <h1 class="display-4 fw-bold mb-2" style="font-family: var(--font-heading);">Admissions 2026-2027</h1>
        <p class="text-white-50 fs-5 mx-auto" style="max-width: 640px;">Join the Junior Gurukul family. Admissions open from Basant Panchami — a simple 4-step process.</p>
    </div>
</section>

<!-- STEPPER PROCESS & FORM -->
<section class="py-5 bg-white">
    <div class="container py-4">
        <!-- 4 Step Indicator -->
        <div class="row g-3 mb-5" data-aos="fade-up">
            <div class="col-6 col-md-3">
                <div class="step-card">
                    <div class="step-num">01</div>
                    <div class="small fw-semibold text-dark">Submit Application</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="step-card">
                    <div class="step-num">02</div>
                    <div class="small fw-semibold text-dark">Campus Visit</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="step-card">
                    <div class="step-num">03</div>
                    <div class="small fw-semibold text-dark">Interaction / Test</div>
                </div>
            </div>
            <div class="col-6 col-md-3">
                <div class="step-card">
                    <div class="step-num">04</div>
                    <div class="small fw-semibold text-dark">Enrollment Confirmation</div>
                </div>
            </div>
        </div>

        <div class="row g-5">
            <div class="col-lg-6" data-aos="fade-right" id="checklist">
                <h3 class="fw-bold text-dark mb-3" style="font-family: var(--font-heading);">Required Documents Checklist</h3>
                <div class="mb-4">
                    <div class="doc-checklist-item"><i class="bi bi-check-circle-fill"></i> Student Birth Certificate (Original & Copy)</div>
                    <div class="doc-checklist-item"><i class="bi bi-check-circle-fill"></i> Previous School Transfer Certificate (TC)</div>
                    <div class="doc-checklist-item"><i class="bi bi-check-circle-fill"></i> Report Card of Previous Grade</div>
                    <div class="doc-checklist-item"><i class="bi bi-check-circle-fill"></i> Passport Size Photographs (Student & Parents)</div>
                    <div class="doc-checklist-item"><i class="bi bi-check-circle-fill"></i> Parent Residence Address Proof</div>
                </div>

                <div class="p-4 rounded-4 bg-navy-dark text-white shadow">
                    <h5 class="fw-bold mb-2 text-white" style="font-family: var(--font-heading);">Need Admission Guidance?</h5>
                    <p class="small text-white-50 mb-3">Speak directly with our admissions desk at Kedwa Road, Bhikangaon.</p>
                    <div class="fw-bold fs-5 text-gold"><i class="bi bi-telephone me-2"></i> <a href="tel:+919617614788" class="text-gold text-decoration-none">096176 14788</a></div>
                </div>
            </div>

            <div class="col-lg-6" data-aos="fade-left" id="apply">
                <div class="card border-0 rounded-4 shadow-lg p-4 bg-light">
                    <h4 class="fw-bold text-dark mb-3" style="font-family: var(--font-heading);">Online Application Form</h4>

                    @if(session('success'))
                        <div class="alert alert-success small mb-3"><i class="bi bi-check-circle me-1"></i> {{ session('success') }}</div>
                    @endif

                    <form action="{{ route('website.enquiry.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark mb-1">Parent / Guardian Full Name *</label>
                            <input type="text" name="parent_name" class="form-control" placeholder="e.g. Ramesh Patidar" required>
                        </div>
                        <div class="row g-2 mb-3">
                            <div class="col-6">
                                <label class="form-label small fw-bold text-dark mb-1">Parent Phone *</label>
                                <input type="tel" name="phone" class="form-control" placeholder="10-digit number" required>
                            </div>
                            <div class="col-6">
                                <label class="form-label small fw-bold text-dark mb-1">Parent Email</label>
                                <input type="email" name="email" class="form-control" placeholder="parent@example.com">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark mb-1">Student Full Name *</label>
                            <input type="text" name="student_name" class="form-control" placeholder="e.g. Aarav Patidar" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold text-dark mb-1">Class Applying For *</label>
                            <select name="grade_seeking" class="form-select" required>
                                <option value="">Select Grade</option>
                                <option value="Pre-Primary">Pre-Primary (Nursery/KG)</option>
                                <option value="Grade 1">Grade 1</option>
                                <option value="Grade 2">Grade 2</option>
                                <option value="Grade 3">Grade 3</option>
                                <option value="Grade 4">Grade 4</option>
                                <option value="Grade 5">Grade 5</option>
                                <option value="Grade 6">Grade 6</option>
                                <option value="Grade 7">Grade 7</option>
                                <option value="Grade 8">Grade 8</option>
                                <option value="Grade 9">Grade 9</option>
                                <option value="Grade 10">Grade 10</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-gold w-100 justify-content-center py-3 fw-bold border-0">
                            Submit Admission Application <i class="bi bi-send ms-1"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection