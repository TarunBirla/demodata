@extends('layouts.app')

@section('title', 'Website CMS Manager')

@section('content')

<x-breadcrumb :items="['Website CMS' => route('admin.cms.index')]" />

<x-page-header title="School Website CMS Manager" subtitle="Control public homepage hero banner, title, subtitle, news announcements, parent testimonials, and media gallery." />

<div class="row g-4 mb-4">
    <!-- HOMEPAGE HERO & BANNER CONTROL -->
    <div class="col-lg-12">
        <x-card title="Homepage Hero Section & Banner Manager" headerIcon="bi-sliders">
            <form action="{{ route('admin.cms.hero.update') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <x-input name="hero_badge" label="Hero Top Badge" value="{{ $settings['hero_badge'] ?? 'CBSE Affiliated · Admissions Open 2026-27' }}" required />
                    </div>
                    <div class="col-md-6">
                        <x-input name="hero_title" label="Hero Main Title" value="{{ $settings['hero_title'] ?? 'Where Global Minds & Timeless Values Grow' }}" required />
                    </div>
                    <div class="col-md-12">
                        <x-input name="hero_subtitle" label="Hero Subtitle Description" value="{{ $settings['hero_subtitle'] ?? 'Junior Gurukul School, Bhikangaon — blending traditional values with modern, holistic CBSE education.' }}" required />
                    </div>
                    <div class="col-md-6">
                        <x-input name="hero_image" label="Hero Background Image URL" value="{{ $settings['hero_image'] ?? 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1800&q=80' }}" required />
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-bold text-dark small">Principal's Message (Homepage & About)</label>
                        <textarea name="principal_message" class="form-control form-control-sm" rows="2" required>{{ $settings['principal_message'] ?? 'Welcome to Junior Gurukul School, Bhikangaon. We believe that true education nurtures both the intellect and character.' }}</textarea>
                    </div>
                </div>

                <div class="mt-3 text-end">
                    <button type="submit" class="btn btn-navy"><i class="bi bi-save me-1"></i> Save Homepage Hero Settings</button>
                </div>
            </form>
        </x-card>
    </div>
</div>

<div class="row g-4">
    <!-- NEWS PUBLISHER & LIST -->
    <div class="col-lg-6">
        <x-card title="Publish News & Achievements" headerIcon="bi-newspaper">
            <form action="{{ route('admin.cms.news.store') }}" method="POST" class="mb-4 pb-3 border-bottom">
                @csrf
                <x-input name="title" label="Article Title" placeholder="e.g. Annual Science Exhibition Winners" required />
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Article Summary</label>
                    <textarea name="summary" class="form-control form-control-sm" rows="2" placeholder="Brief summary of news item..." required></textarea>
                </div>
                <button type="submit" class="btn btn-navy btn-sm"><i class="bi bi-megaphone me-1"></i> Publish News Article</button>
            </form>

            <h6 class="fw-bold text-dark mb-3">Published Articles ({{ count($newsList) }})</h6>
            @forelse($newsList as $news)
                <div class="p-3 bg-light rounded-3 mb-2">
                    <div class="fw-bold text-dark">{{ $news->title }}</div>
                    <p class="small text-muted mb-1">{{ $news->summary }}</p>
                    <x-badge variant="success">PUBLISHED</x-badge>
                </div>
            @empty
                <x-empty-state title="No News Articles" description="Create news articles to feature on the school website homepage." />
            @endforelse
        </x-card>
    </div>

    <!-- TESTIMONIALS MANAGER -->
    <div class="col-lg-6">
        <x-card title="Parent & Student Testimonials" headerIcon="bi-quote">
            <form action="{{ route('admin.cms.testimonial.store') }}" method="POST" class="mb-4 pb-3 border-bottom">
                @csrf
                <div class="row g-2 mb-2">
                    <div class="col-md-6">
                        <x-input name="name" label="Parent / Student Name" placeholder="e.g. Mrs. Sunita Gupta" required />
                    </div>
                    <div class="col-md-6">
                        <x-input name="role" label="Role / Designation" placeholder="e.g. Parent of Grade 8 Student" required />
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-bold text-dark small">Testimonial Quote</label>
                    <textarea name="content" class="form-control form-control-sm" rows="2" placeholder="Write quote here..." required></textarea>
                </div>
                <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-plus-circle me-1"></i> Add Testimonial</button>
            </form>

            <h6 class="fw-bold text-dark mb-3">Parent Reviews ({{ count($testimonials) }})</h6>
            @forelse($testimonials as $t)
                <div class="p-3 bg-light rounded-3 mb-2">
                    <div class="fw-bold text-dark">{{ $t->name }}</div>
                    <div class="small text-muted mb-1">{{ $t->role }}</div>
                    <p class="small text-dark fst-italic mb-0">"{{ $t->content }}"</p>
                </div>
            @empty
                <x-empty-state title="No Testimonials" description="Add testimonials from happy parents and alumni." />
            @endforelse
        </x-card>
    </div>
</div>

@endsection
