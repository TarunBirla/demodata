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
}
