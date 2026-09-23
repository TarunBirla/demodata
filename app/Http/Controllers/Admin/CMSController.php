<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SchoolSetting;
use App\Models\CmsNews;
use App\Models\CmsTestimonial;
use App\Models\CmsGallery;

class CMSController extends Controller
{
    public function index()
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $settings = SchoolSetting::where('school_id', $schoolId)->pluck('value', 'key')->toArray();

        $newsList = CmsNews::where('school_id', $schoolId)->latest()->get();
        $testimonials = CmsTestimonial::where('school_id', $schoolId)->latest()->get();
        $galleries = CmsGallery::where('school_id', $schoolId)->latest()->get();

        return view('admin.cms.index', compact('settings', 'newsList', 'testimonials', 'galleries'));
    }

    public function updateHeroSettings(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $fields = $request->only([
            'hero_badge',
            'hero_title',
            'hero_subtitle',
            'hero_image',
            'principal_message',
            'stat_students',
            'stat_faculty',
            'stat_years',
            'stat_classes',
        ]);

        if ($request->filled('hero_image_select')) {
            $fields['hero_image'] = $request->hero_image_select;
        }

        if ($request->hasFile('hero_image_file')) {
            $path = $request->file('hero_image_file')->store('cms', 'public');
            $fields['hero_image'] = asset('storage/' . $path);
        }

        foreach ($fields as $key => $value) {
            if ($value !== null) {
                SchoolSetting::updateOrCreate(
                    ['school_id' => $schoolId, 'key' => $key],
                    ['value' => $value, 'group' => 'general']
                );
            }
        }

        return back()->with('success', 'Website Homepage Hero Banner & Content updated successfully!');
    }

    public function storeNews(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:1000',
        ]);

        CmsNews::create([
            'school_id' => $schoolId,
            'title' => $request->title,
            'slug' => \Illuminate\Support\Str::slug($request->title) . '-' . rand(100, 999),
            'summary' => $request->summary,
            'content' => $request->summary,
            'published_at' => now(),
            'status' => 'published',
        ]);

        return back()->with('success', 'News article published successfully to school website!');
    }

    public function updateNews(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $news = CmsNews::where('school_id', $schoolId)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:1000',
        ]);

        $news->update([
            'title' => $request->title,
            'summary' => $request->summary,
            'content' => $request->summary,
        ]);

        return back()->with('success', 'News article updated successfully!');
    }

    public function destroyNews($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $news = CmsNews::where('school_id', $schoolId)->findOrFail($id);
        $news->delete();

        return back()->with('success', 'News article deleted successfully.');
    }

    public function storeTestimonial(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'content' => 'required|string|max:2000',
        ]);

        CmsTestimonial::create([
            'school_id' => $schoolId,
            'name' => $request->name,
            'role' => $request->role,
            'content' => $request->content,
            'rating' => 5,
            'status' => 'active',
        ]);

        return back()->with('success', 'Parent testimonial added successfully!');
    }

    public function updateTestimonial(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $testimonial = CmsTestimonial::where('school_id', $schoolId)->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
            'content' => 'required|string|max:2000',
        ]);

        $testimonial->update([
            'name' => $request->name,
            'role' => $request->role,
            'content' => $request->content,
        ]);

        return back()->with('success', 'Testimonial updated successfully!');
    }

    public function destroyTestimonial($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $testimonial = CmsTestimonial::where('school_id', $schoolId)->findOrFail($id);
        $testimonial->delete();

        return back()->with('success', 'Testimonial deleted successfully.');
    }

    public function storeGallery(Request $request)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $imagePath = $request->image_select ?? 'https://images.unsplash.com/photo-1577896851231-70ef18881754?auto=format&fit=crop&w=800&q=80';

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('gallery', 'public');
            $imagePath = asset('storage/' . $path);
        }

        CmsGallery::create([
            'school_id' => $schoolId,
            'title' => $request->title,
            'category' => $request->category,
            'image_path' => $imagePath,
            'description' => $request->description,
        ]);

        return back()->with('success', 'Gallery item added successfully!');
    }

    public function updateGallery(Request $request, $id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $gallery = CmsGallery::where('school_id', $schoolId)->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:255',
        ]);

        $data = [
            'title' => $request->title,
            'category' => $request->category,
            'description' => $request->description,
        ];

        if ($request->filled('image_select')) {
            $data['image_path'] = $request->image_select;
        }

        if ($request->hasFile('image_file')) {
            $path = $request->file('image_file')->store('gallery', 'public');
            $data['image_path'] = asset('storage/' . $path);
        }

        $gallery->update($data);

        return back()->with('success', 'Gallery item updated successfully!');
    }

    public function destroyGallery($id)
    {
        $schoolId = auth()->user()->school_id ?? 1;
        $gallery = CmsGallery::where('school_id', $schoolId)->findOrFail($id);
        $gallery->delete();

        return back()->with('success', 'Gallery item deleted successfully.');
    }
}
