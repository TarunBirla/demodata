<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;
use App\Models\SchoolSetting;
use App\Models\Teacher;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Student;
use App\Models\CmsNews;
use App\Models\CmsTestimonial;
use App\Models\CmsGallery;
use App\Models\Event;
use App\Models\Enquiry;

class PublicWebsiteController extends Controller
{
    private function getSettings()
    {
        $school = School::first();
        $schoolId = $school->id ?? 1;
        $dbSettings = SchoolSetting::where('school_id', $schoolId)->pluck('value', 'key')->toArray();

        $defaults = [
            'school_name' => 'Junior Gurukul School',
            'school_tagline' => 'School · Bhikangaon, M.P.',
            'school_email' => 'info@juniorgurukulschool.in',
            'school_phone' => '096176 14788',
            'school_address' => 'Junior Gurukul School, Seavri Dhaam, Kedwa Road, Bhikangaon, Panchamba, Madhya Pradesh 451331',
            'currency_symbol' => '₹',
            'receipt_prefix' => 'REC-2026-',
            'hero_badge' => 'CBSE Affiliated · Admissions Open 2026-27',
            'hero_title' => 'Where Global Minds & Timeless Values Grow',
            'hero_subtitle' => 'Junior Gurukul School, Bhikangaon — blending traditional values with modern, holistic CBSE education to shape confident, capable learners.',
            'hero_image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1800&q=80',
            'principal_message' => 'Welcome to Junior Gurukul School, Bhikangaon. We believe that true education nurtures both intellect and character.',
            'stat_students' => '600+',
            'stat_faculty' => '40+',
            'stat_years' => '9+',
            'stat_classes' => '20+',
        ];

        return array_merge($defaults, $dbSettings);
    }

    public function index()
    {
        $school = School::first();
        $settings = $this->getSettings();

        // Top 5-8 items for Swiper Sliders on Homepage
        $teachers = Teacher::where('status', 'active')->take(8)->get();
        if ($teachers->isEmpty()) {
            $teachers = Teacher::take(8)->get();
        }

        $newsList = CmsNews::where('status', 'published')->latest()->take(6)->get();
        if ($newsList->isEmpty()) {
            $newsList = CmsNews::latest()->take(6)->get();
        }

        $events = Event::where('status', 'active')->latest()->take(6)->get();
        $testimonials = CmsTestimonial::where('status', 'active')->take(8)->get();
        if ($testimonials->isEmpty()) {
            $testimonials = CmsTestimonial::take(8)->get();
        }

        $galleries = CmsGallery::latest()->take(8)->get();
        $classes = SchoolClass::with('sections')->where('status', 'active')->orderBy('display_order')->get();

        // Dynamic Counts
        $realStudentCount = Student::count();
        $realTeacherCount = Teacher::count();
        $realClassCount = SchoolClass::count();

        $stats = [
            'students' => $realStudentCount > 0 ? $realStudentCount . '+' : ($settings['stat_students'] ?? '600+'),
            'faculty' => $realTeacherCount > 0 ? $realTeacherCount . '+' : ($settings['stat_faculty'] ?? '40+'),
            'years' => $settings['stat_years'] ?? '9+',
            'classes' => $realClassCount > 0 ? $realClassCount . '+' : ($settings['stat_classes'] ?? '20+'),
        ];

        return view('website.home', compact(
            'school',
            'settings',
            'teachers',
            'newsList',
            'events',
            'testimonials',
            'galleries',
            'classes',
            'stats'
        ));
    }

    public function about()
    {
        $school = School::first();
        $settings = $this->getSettings();
        return view('website.about', compact('school', 'settings'));
    }

    public function academics()
    {
        $settings = $this->getSettings();
        $classes = SchoolClass::with(['sections', 'subjects'])->where('status', 'active')->orderBy('display_order')->get();
        $subjects = Subject::where('status', 'active')->get();
        return view('website.academics', compact('settings', 'classes', 'subjects'));
    }

    public function faculty()
    {
        $settings = $this->getSettings();
        $teachers = Teacher::where('status', 'active')->get();
        if ($teachers->isEmpty()) {
            $teachers = Teacher::all();
        }
        return view('website.faculty', compact('settings', 'teachers'));
    }

    public function facilities()
    {
        $settings = $this->getSettings();
        return view('website.facilities', compact('settings'));
    }

    public function admissions()
    {
        $settings = $this->getSettings();
        $classes = SchoolClass::where('status', 'active')->orderBy('display_order')->get();
        return view('website.admissions', compact('settings', 'classes'));
    }

    public function gallery()
    {
        $settings = $this->getSettings();
        $galleries = CmsGallery::latest()->get();
        return view('website.gallery', compact('settings', 'galleries'));
    }

    public function news()
    {
        $settings = $this->getSettings();
        $newsList = CmsNews::where('status', 'published')->latest()->paginate(9);
        $events = Event::where('status', 'active')->latest()->get();
        return view('website.news', compact('settings', 'newsList', 'events'));
    }

    public function testimonials()
    {
        $settings = $this->getSettings();
        $testimonials = CmsTestimonial::where('status', 'active')->get();
        if ($testimonials->isEmpty()) {
            $testimonials = CmsTestimonial::all();
        }
        return view('website.testimonials', compact('settings', 'testimonials'));
    }

    public function contact()
    {
        $school = School::first();
        $settings = $this->getSettings();
        return view('website.contact', compact('school', 'settings'));
    }

    public function submitEnquiry(Request $request)
    {
        $validated = $request->validate([
            'parent_name' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'phone' => 'required|string|max:50',
            'email' => 'nullable|email|max:255',
            'student_name' => 'nullable|string|max:255',
            'grade_seeking' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:2000',
        ]);

        $parentName = $request->input('parent_name') ?: ($request->input('name') ?: 'Guest / Visitor');

        $school = School::first();
        Enquiry::create([
            'school_id' => $school->id ?? 1,
            'parent_name' => $parentName,
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'student_name' => $validated['student_name'] ?? null,
            'grade_seeking' => $validated['grade_seeking'] ?? null,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        return back()->with('success', 'Thank you! Your inquiry has been submitted successfully. Junior Gurukul team will reach out to you shortly.');
    }
}
