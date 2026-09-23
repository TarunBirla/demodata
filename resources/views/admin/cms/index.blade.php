@extends('layouts.app')

@section('title', 'Website CMS Manager')

@section('content')

<x-breadcrumb :items="['Website CMS' => route('admin.cms.index')]" />

<x-page-header title="School Website CMS Manager" subtitle="Control public homepage hero banner, title, subtitle, news announcements, parent testimonials, and media gallery." />

<div class="row g-4 mb-4">
    <!-- HOMEPAGE HERO & BANNER CONTROL -->
    <div class="col-lg-12">
        <x-card title="Homepage Hero Section & Banner Manager" headerIcon="bi-sliders">
            @php
                $activeHeroImg = !empty($settings['hero_image']) ? $settings['hero_image'] : 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1800&q=80';
            @endphp
            <div class="mb-4 p-3 bg-light rounded-3 border d-flex flex-column flex-md-row align-items-center gap-3">
                <div class="rounded-3 overflow-hidden border shadow-sm flex-shrink-0" style="width: 200px; height: 110px;">
                    <img src="{{ $activeHeroImg }}" id="heroPreviewImg" class="w-100 h-100 object-fit-cover" alt="Hero Banner Preview" onerror="this.src='https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1800&q=80'">
                </div>
                <div>
                    <span class="badge bg-success mb-1">Active Homepage Hero Banner</span>
                    <h6 class="fw-bold text-dark mb-1">Current Banner Image Preview</h6>
                    <div class="small text-muted text-break" style="font-size:0.78rem;">{{ $activeHeroImg }}</div>
                </div>
            </div>

            <form action="{{ route('admin.cms.hero.update') }}" method="POST" enctype="multipart/form-data">
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

                    <div class="col-md-4">
                        <x-select name="hero_image_select" label="Option 1: Choose Preset Photo Dropdown" :options="[
                            'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1800&q=80' => 'Modern Campus & Classroom (Default)',
                            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1800&q=80' => 'Students Graduation & Campus Building',
                            'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=1800&q=80' => 'School Library & Reading Room',
                            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=1800&q=80' => 'Sports & Playground Activity'
                        ]" :selected="$activeHeroImg" />
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-medium text-secondary small mb-1">Option 2: Upload Image File</label>
                        <input type="file" name="hero_image_file" class="form-control form-control-md rounded-2" accept="image/*">
                    </div>
                    <div class="col-md-4">
                        <x-input name="hero_image_url" label="Option 3: Paste Direct Image URL" value="{{ filter_var($activeHeroImg, FILTER_VALIDATE_URL) ? $activeHeroImg : '' }}" placeholder="https://..." />
                    </div>

                    <div class="col-md-12">
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

<div class="row g-4 mb-4">
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
                <div class="p-3 bg-light rounded-3 mb-2 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-bold text-dark">{{ $news->title }}</div>
                        <p class="small text-muted mb-1">{{ $news->summary }}</p>
                        <x-badge variant="success">PUBLISHED</x-badge>
                    </div>
                    <div class="d-flex gap-1 ms-2">
                        <button class="btn btn-sm btn-light text-warning" data-bs-toggle="modal" data-bs-target="#editNewsModal{{ $news->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.cms.news.destroy', $news->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete news article {{ $news->title }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <!-- EDIT NEWS MODAL -->
                    <x-modal id="editNewsModal{{ $news->id }}" title="Edit News Article — {{ $news->title }}">
                        <form action="{{ route('admin.cms.news.update', $news->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="title" label="Article Title" value="{{ $news->title }}" required />
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small">Article Summary</label>
                                <textarea name="summary" class="form-control" rows="3" required>{{ $news->summary }}</textarea>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy">Save Article</button>
                            </div>
                        </form>
                    </x-modal>
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
                <div class="p-3 bg-light rounded-3 mb-2 d-flex justify-content-between align-items-start">
                    <div>
                        <div class="fw-bold text-dark">{{ $t->name }}</div>
                        <div class="small text-muted mb-1">{{ $t->role }}</div>
                        <p class="small text-dark fst-italic mb-0">"{{ $t->content }}"</p>
                    </div>
                    <div class="d-flex gap-1 ms-2">
                        <button class="btn btn-sm btn-light text-warning" data-bs-toggle="modal" data-bs-target="#editTestimonialModal{{ $t->id }}"><i class="bi bi-pencil"></i></button>
                        <form action="{{ route('admin.cms.testimonial.destroy', $t->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete testimonial from {{ $t->name }}?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-light text-danger"><i class="bi bi-trash"></i></button>
                        </form>
                    </div>

                    <!-- EDIT TESTIMONIAL MODAL -->
                    <x-modal id="editTestimonialModal{{ $t->id }}" title="Edit Testimonial — {{ $t->name }}">
                        <form action="{{ route('admin.cms.testimonial.update', $t->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <x-input name="name" label="Parent Name" value="{{ $t->name }}" required />
                            <x-input name="role" label="Role / Designation" value="{{ $t->role }}" required />
                            <div class="mb-3">
                                <label class="form-label fw-bold text-dark small">Testimonial Quote</label>
                                <textarea name="content" class="form-control" rows="3" required>{{ $t->content }}</textarea>
                            </div>
                            <div class="text-end mt-3">
                                <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                <button type="submit" class="btn btn-navy">Save Testimonial</button>
                            </div>
                        </form>
                    </x-modal>
                </div>
            @empty
                <x-empty-state title="No Testimonials" description="Add testimonials from happy parents and alumni." />
            @endforelse
        </x-card>
    </div>
</div>

<!-- MEDIA GALLERY MANAGER -->
<div class="row g-4">
    <div class="col-lg-12">
        <x-card title="Website Photo Gallery Manager" headerIcon="bi-images">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <span class="fw-bold text-dark">School Photo Gallery ({{ count($galleries) }} Photos)</span>
                <button class="btn btn-navy btn-sm" data-bs-toggle="modal" data-bs-target="#addGalleryModal"><i class="bi bi-plus-lg me-1"></i> Add Gallery Photo</button>
            </div>

            <div class="row g-3">
                @forelse($galleries as $gal)
                    <div class="col-md-4 col-lg-3">
                        <div class="card h-100 border shadow-sm rounded-3 overflow-hidden">
                            <img src="{{ $gal->image_path }}" class="card-img-top" style="height: 140px; object-fit: cover;" alt="{{ $gal->title }}">
                            <div class="card-body p-2">
                                <div class="fw-bold text-dark small text-truncate">{{ $gal->title }}</div>
                                <span class="badge bg-navy" style="font-size:0.65rem;">{{ strtoupper($gal->category) }}</span>
                                <div class="d-flex justify-content-end gap-1 mt-2">
                                    <button class="btn btn-sm btn-light py-0 px-2 text-warning" data-bs-toggle="modal" data-bs-target="#editGalleryModal{{ $gal->id }}"><i class="bi bi-pencil"></i></button>
                                    <form action="{{ route('admin.cms.gallery.destroy', $gal->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete photo {{ $gal->title }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light py-0 px-2 text-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- EDIT GALLERY MODAL -->
                        <x-modal id="editGalleryModal{{ $gal->id }}" title="Edit Photo — {{ $gal->title }}">
                            <form action="{{ route('admin.cms.gallery.update', $gal->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <x-input name="title" label="Photo Caption Title" value="{{ $gal->title }}" required />
                                <x-select name="category" label="Category Choice" :options="['Campus' => 'Campus & Buildings', 'Events' => 'Events & Festivals', 'Sports' => 'Sports & Playground', 'Academics' => 'Lab & Library']" :value="$gal->category" required />
                                <x-select name="image_select" label="Choose Preset Photo" :options="[
                                    'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80' => 'School Library',
                                    'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80' => 'Science Lab',
                                    'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80' => 'Modern Classroom',
                                    'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=800&q=80' => 'Campus Sports Field'
                                ]" :selected="$gal->image_path" />
                                <div class="mb-3">
                                    <label class="form-label fw-bold text-dark small">Or Upload Custom Photo</label>
                                    <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*">
                                </div>
                                <div class="text-end mt-3">
                                    <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-navy">Save Photo</button>
                                </div>
                            </form>
                        </x-modal>
                    </div>
                @empty
                    <div class="col-12 py-3 text-center text-muted">No gallery photos uploaded yet.</div>
                @endforelse
            </div>
        </x-card>
    </div>
</div>

<!-- ADD GALLERY PHOTO MODAL -->
<x-modal id="addGalleryModal" title="Add New Gallery Photo">
    <form action="{{ route('admin.cms.gallery.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <x-input name="title" label="Photo Caption Title" placeholder="e.g. Science Fair Lab Experiment" required />
        <x-select name="category" label="Category Choice" :options="['Campus' => 'Campus & Buildings', 'Events' => 'Events & Festivals', 'Sports' => 'Sports & Playground', 'Academics' => 'Lab & Library']" required />
        <x-select name="image_select" label="Choose Photo Choice (No URL Typing Required!)" :options="[
            'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80' => 'School Library',
            'https://images.unsplash.com/photo-1580582932707-520aed937b7b?auto=format&fit=crop&w=800&q=80' => 'Science Lab',
            'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80' => 'Modern Classroom',
            'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=800&q=80' => 'Campus Sports Field'
        ]" required />
        <div class="mb-3">
            <label class="form-label fw-bold text-dark small">Or Upload Photo File from Computer</label>
            <input type="file" name="image_file" class="form-control form-control-sm" accept="image/*">
        </div>
        <div class="text-end mt-3">
            <button type="button" class="btn btn-light me-2" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-navy"><i class="bi bi-check-lg me-1"></i> Add Photo to Gallery</button>
        </div>
    </form>
</x-modal>

@endsection
