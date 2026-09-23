<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicWebsiteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Admin\ClassController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\FeeController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\TimetableController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\HomeworkController;
use App\Http\Controllers\Admin\OnlineAdmissionAdminController;
use App\Http\Controllers\Admin\CMSController;
use App\Http\Controllers\Admin\SettingController;

/*
|--------------------------------------------------------------------------
| Live Server Setup & Database Auto-Migration Routes
|--------------------------------------------------------------------------
*/
Route::get('/setup-storage', function () {
    try {
        @\Illuminate\Support\Facades\Artisan::call('storage:link');

        $target = storage_path('app/public');
        $link = public_path('storage');
        if (!file_exists($link)) {
            try {
                @app('files')->link($target, $link);
            } catch (\Throwable $e) {
                @symlink($target, $link);
            }
        }

        @\Illuminate\Support\Facades\Artisan::call('config:clear');
        @\Illuminate\Support\Facades\Artisan::call('cache:clear');
        @\Illuminate\Support\Facades\Artisan::call('view:clear');
        @\Illuminate\Support\Facades\Artisan::call('route:clear');

        return "<div style='font-family: Arial, sans-serif; padding: 40px; text-align: center; max-width: 600px; margin: 50px auto; border-radius: 16px; background: #E6FFFA; border: 2px solid #319795; color: #234E52; box-shadow: 0 10px 30px rgba(0,0,0,0.15);'>"
            . "<h2 style='color: #2C7A7B; margin-top: 0;'>🔗 Storage Link & Image System Fixed Successfully!</h2>"
            . "<p style='font-size: 16px; line-height: 1.6;'>Public storage symlink created and all view/config caches cleared for live server deployment.</p>"
            . "<div style='margin-top: 25px;'>"
            . "<a href='" . url('/') . "' style='display: inline-block; padding: 12px 28px; background: #319795; color: #FFFFFF; border-radius: 50px; text-decoration: none; font-weight: bold; margin-right: 10px;'>Open Website Homepage</a>"
            . "<a href='" . url('/admin/cms') . "' style='display: inline-block; padding: 12px 28px; background: #2B6CB0; color: #FFFFFF; border-radius: 50px; text-decoration: none; font-weight: bold;'>Open Admin CMS Manager</a>"
            . "</div>"
            . "</div>";
    } catch (\Throwable $e) {
        return "<div style='font-family: Arial, sans-serif; padding: 40px; max-width: 700px; margin: 50px auto; border-radius: 16px; background: #FFF5F5; border: 2px solid #E53E3E; color: #742A2A; box-shadow: 0 10px 30px rgba(0,0,0,0.15);'>"
            . "<h2 style='color: #C53030; margin-top: 0;'>❌ Storage Fix Error</h2>"
            . "<p><strong>Message:</strong> " . e($e->getMessage()) . "</p>"
            . "</div>";
    }
});

Route::get('/clear-cache', function () {
    try {
        @\Illuminate\Support\Facades\Artisan::call('config:clear');
        @\Illuminate\Support\Facades\Artisan::call('cache:clear');
        @\Illuminate\Support\Facades\Artisan::call('view:clear');
        @\Illuminate\Support\Facades\Artisan::call('route:clear');
        @\Illuminate\Support\Facades\Artisan::call('optimize:clear');

        return "<div style='font-family: Arial, sans-serif; padding: 40px; text-align: center; max-width: 600px; margin: 50px auto; border-radius: 16px; background: #E6FFFA; border: 2px solid #319795; color: #234E52; box-shadow: 0 10px 30px rgba(0,0,0,0.15);'>"
            . "<h2 style='color: #2C7A7B; margin-top: 0;'>⚡ All Caches Cleared Successfully!</h2>"
            . "<p style='font-size: 16px; line-height: 1.6;'>Config, View, Route, and Application cache cleared.</p>"
            . "<div style='margin-top: 25px;'>"
            . "<a href='" . url('/') . "' style='display: inline-block; padding: 12px 28px; background: #319795; color: #FFFFFF; border-radius: 50px; text-decoration: none; font-weight: bold;'>Open Website</a>"
            . "</div>"
            . "</div>";
    } catch (\Throwable $e) {
        return "Cache clear error: " . e($e->getMessage());
    }
});

Route::get('/setup-db', function () {
    try {
        // 1. Ensure storage directories exist with proper write permissions for sessions & cache
        $storageDirs = [
            storage_path('framework/sessions'),
            storage_path('framework/views'),
            storage_path('framework/cache'),
            storage_path('logs'),
            bootstrap_path('cache'),
        ];

        foreach ($storageDirs as $dir) {
            if (!file_exists($dir)) {
                @mkdir($dir, 0777, true);
            }
            @chmod($dir, 0777);
        }

        // 2. Ensure sqlite file exists if sqlite is active
        if (config('database.default') === 'sqlite') {
            $sqlitePath = database_path('database.sqlite');
            if (!file_exists($sqlitePath)) {
                @touch($sqlitePath);
                @chmod($sqlitePath, 0777);
            }
        }

        // 3. Clear all cached configs and sessions & create storage link
        @\Illuminate\Support\Facades\Artisan::call('storage:link');
        @\Illuminate\Support\Facades\Artisan::call('config:clear');
        @\Illuminate\Support\Facades\Artisan::call('cache:clear');
        @\Illuminate\Support\Facades\Artisan::call('view:clear');
        @\Illuminate\Support\Facades\Artisan::call('route:clear');

        // 4. Run migrate:fresh with seed and force flag for live servers
        \Illuminate\Support\Facades\Artisan::call('migrate:fresh', [
            '--force' => true,
            '--seed' => true,
        ]);

        return "<div style='font-family: Arial, sans-serif; padding: 40px; text-align: center; max-width: 600px; margin: 50px auto; border-radius: 16px; background: #E6FFFA; border: 2px solid #319795; color: #234E52; box-shadow: 0 10px 30px rgba(0,0,0,0.15);'>"
            . "<h2 style='color: #2C7A7B; margin-top: 0;'>✅ Database & Sessions Setup Completed!</h2>"
            . "<p style='font-size: 16px; line-height: 1.6;'>All tables, session storage directories, permissions, and database seeders have been initialized.</p>"
            . "<div style='margin-top: 25px;'>"
            . "<a href='" . url('/') . "' style='display: inline-block; padding: 12px 28px; background: #319795; color: #FFFFFF; border-radius: 50px; text-decoration: none; font-weight: bold; margin-right: 10px;'>Open Website Homepage</a>"
            . "<a href='" . url('/login') . "' style='display: inline-block; padding: 12px 28px; background: #2B6CB0; color: #FFFFFF; border-radius: 50px; text-decoration: none; font-weight: bold;'>Login to Admin Portal</a>"
            . "</div>"
            . "</div>";
    } catch (\Throwable $e) {
        return "<div style='font-family: Arial, sans-serif; padding: 40px; max-width: 700px; margin: 50px auto; border-radius: 16px; background: #FFF5F5; border: 2px solid #E53E3E; color: #742A2A; box-shadow: 0 10px 30px rgba(0,0,0,0.15);'>"
            . "<h2 style='color: #C53030; margin-top: 0;'>❌ Setup Error</h2>"
            . "<p><strong>Message:</strong> " . e($e->getMessage()) . "</p>"
            . "<pre style='background: #FFFFFF; padding: 15px; border-radius: 8px; overflow: auto; font-size: 13px; text-align: left;'>" . e($e->getTraceAsString()) . "</pre>"
            . "</div>";
    }
});

/*
|--------------------------------------------------------------------------
| Public School Website Routes (10 Dedicated Pages)
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicWebsiteController::class, 'index'])->name('website.home');
Route::get('/about', [PublicWebsiteController::class, 'about'])->name('website.about');
Route::get('/academics', [PublicWebsiteController::class, 'academics'])->name('website.academics');
Route::get('/faculty', [PublicWebsiteController::class, 'faculty'])->name('website.faculty');
Route::get('/facilities', [PublicWebsiteController::class, 'facilities'])->name('website.facilities');
Route::get('/admissions', [PublicWebsiteController::class, 'admissions'])->name('website.admissions');
Route::get('/gallery', [PublicWebsiteController::class, 'gallery'])->name('website.gallery');
Route::get('/news-events', [PublicWebsiteController::class, 'news'])->name('website.news');
Route::get('/testimonials', [PublicWebsiteController::class, 'testimonials'])->name('website.testimonials');
Route::get('/contact', [PublicWebsiteController::class, 'contact'])->name('website.contact');
Route::post('/enquiry', [PublicWebsiteController::class, 'submitEnquiry'])->name('website.enquiry.submit');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('auth.login');
    Route::post('/login', [AuthController::class, 'login'])->name('auth.login.submit');
    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('auth.forgot_password');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetLink'])->name('auth.forgot_password.submit');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

/*
|--------------------------------------------------------------------------
| Admin Panel Routes (Protected by Auth & Role-Based Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Students
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create')->middleware('role:school_admin,super_admin');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store')->middleware('role:school_admin,super_admin');
    Route::get('/students/{id}', [StudentController::class, 'show'])->name('students.show');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update')->middleware('role:school_admin,super_admin');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy')->middleware('role:school_admin,super_admin');

    // Teachers & Staff (Admin Only)
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index')->middleware('role:school_admin,super_admin');
    Route::post('/teachers', [TeacherController::class, 'store'])->name('teachers.store')->middleware('role:school_admin,super_admin');
    Route::put('/teachers/{id}', [TeacherController::class, 'update'])->name('teachers.update')->middleware('role:school_admin,super_admin');
    Route::delete('/teachers/{id}', [TeacherController::class, 'destroy'])->name('teachers.destroy')->middleware('role:school_admin,super_admin');

    // Academics (Classes, Sections & Subjects)
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::post('/classes', [ClassController::class, 'store'])->name('classes.store')->middleware('role:school_admin,super_admin');
    Route::put('/classes/{id}', [ClassController::class, 'update'])->name('classes.update')->middleware('role:school_admin,super_admin');
    Route::delete('/classes/{id}', [ClassController::class, 'destroy'])->name('classes.destroy')->middleware('role:school_admin,super_admin');
    
    Route::post('/sections', [ClassController::class, 'storeSection'])->name('sections.store')->middleware('role:school_admin,super_admin');
    Route::put('/sections/{id}', [ClassController::class, 'updateSection'])->name('sections.update')->middleware('role:school_admin,super_admin');
    Route::delete('/sections/{id}', [ClassController::class, 'destroySection'])->name('sections.destroy')->middleware('role:school_admin,super_admin');

    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store')->middleware('role:school_admin,super_admin,teacher');
    Route::put('/subjects/{id}', [SubjectController::class, 'update'])->name('subjects.update')->middleware('role:school_admin,super_admin,teacher');
    Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy')->middleware('role:school_admin,super_admin');

    Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');
    Route::post('/timetable', [TimetableController::class, 'store'])->name('timetable.store')->middleware('role:school_admin,super_admin');
    Route::put('/timetable/{id}', [TimetableController::class, 'update'])->name('timetable.update')->middleware('role:school_admin,super_admin');
    Route::delete('/timetable/{id}', [TimetableController::class, 'destroy'])->name('timetable.destroy')->middleware('role:school_admin,super_admin');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store')->middleware('role:school_admin,super_admin,teacher');
    Route::delete('/attendance/{id}', [AttendanceController::class, 'destroy'])->name('attendance.destroy')->middleware('role:school_admin,super_admin');

    // Fees
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index')->middleware('role:school_admin,super_admin,student,parent');
    Route::post('/fees/collect', [FeeController::class, 'collect'])->name('fees.collect')->middleware('role:school_admin,super_admin');
    Route::post('/fees/structure', [FeeController::class, 'storeStructure'])->name('fees.structure.store')->middleware('role:school_admin,super_admin');
    Route::put('/fees/structure/{id}', [FeeController::class, 'updateStructure'])->name('fees.structure.update')->middleware('role:school_admin,super_admin');
    Route::delete('/fees/structure/{id}', [FeeController::class, 'destroyStructure'])->name('fees.structure.destroy')->middleware('role:school_admin,super_admin');
    Route::delete('/fees/payment/{id}', [FeeController::class, 'destroyPayment'])->name('fees.payment.destroy')->middleware('role:school_admin,super_admin');

    // Exams & Marks
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');
    Route::post('/exams', [ExamController::class, 'store'])->name('exams.store')->middleware('role:school_admin,super_admin');
    Route::put('/exams/{id}', [ExamController::class, 'update'])->name('exams.update')->middleware('role:school_admin,super_admin');
    Route::delete('/exams/{id}', [ExamController::class, 'destroy'])->name('exams.destroy')->middleware('role:school_admin,super_admin');
    Route::post('/exams/marks', [ExamController::class, 'storeMarks'])->name('exams.marks.store')->middleware('role:school_admin,super_admin,teacher');
    Route::delete('/exams/marks/{id}', [ExamController::class, 'destroyMarks'])->name('exams.marks.destroy')->middleware('role:school_admin,super_admin');

    // Communication & Homework
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::post('/notices', [NoticeController::class, 'store'])->name('notices.store')->middleware('role:school_admin,super_admin');
    Route::put('/notices/{id}', [NoticeController::class, 'update'])->name('notices.update')->middleware('role:school_admin,super_admin');
    Route::delete('/notices/{id}', [NoticeController::class, 'destroy'])->name('notices.destroy')->middleware('role:school_admin,super_admin');

    Route::post('/events', [NoticeController::class, 'storeEvent'])->name('events.store')->middleware('role:school_admin,super_admin');
    Route::put('/events/{id}', [NoticeController::class, 'updateEvent'])->name('events.update')->middleware('role:school_admin,super_admin');
    Route::delete('/events/{id}', [NoticeController::class, 'destroyEvent'])->name('events.destroy')->middleware('role:school_admin,super_admin');

    Route::get('/homework', [HomeworkController::class, 'index'])->name('homework.index');
    Route::post('/homework', [HomeworkController::class, 'store'])->name('homework.store')->middleware('role:school_admin,super_admin,teacher');
    Route::put('/homework/{id}', [HomeworkController::class, 'update'])->name('homework.update')->middleware('role:school_admin,super_admin,teacher');
    Route::delete('/homework/{id}', [HomeworkController::class, 'destroy'])->name('homework.destroy')->middleware('role:school_admin,super_admin,teacher');

    // Online Admissions (Admin Only)
    Route::get('/admissions', [OnlineAdmissionAdminController::class, 'index'])->name('admissions.index')->middleware('role:school_admin,super_admin');
    Route::put('/admissions/{id}/status', [OnlineAdmissionAdminController::class, 'updateStatus'])->name('admissions.update_status')->middleware('role:school_admin,super_admin');
    Route::put('/admissions/{id}', [OnlineAdmissionAdminController::class, 'update'])->name('admissions.update')->middleware('role:school_admin,super_admin');
    Route::delete('/admissions/{id}', [OnlineAdmissionAdminController::class, 'destroy'])->name('admissions.destroy')->middleware('role:school_admin,super_admin');
    Route::delete('/enquiries/{id}', [OnlineAdmissionAdminController::class, 'destroyEnquiry'])->name('enquiries.destroy')->middleware('role:school_admin,super_admin');

    // CMS & Settings (Admin Only)
    Route::get('/cms', [CMSController::class, 'index'])->name('cms.index')->middleware('role:school_admin,super_admin');
    Route::post('/cms/hero', [CMSController::class, 'updateHeroSettings'])->name('cms.hero.update')->middleware('role:school_admin,super_admin');
    Route::post('/cms/news', [CMSController::class, 'storeNews'])->name('cms.news.store')->middleware('role:school_admin,super_admin');
    Route::put('/cms/news/{id}', [CMSController::class, 'updateNews'])->name('cms.news.update')->middleware('role:school_admin,super_admin');
    Route::delete('/cms/news/{id}', [CMSController::class, 'destroyNews'])->name('cms.news.destroy')->middleware('role:school_admin,super_admin');

    Route::post('/cms/testimonial', [CMSController::class, 'storeTestimonial'])->name('cms.testimonial.store')->middleware('role:school_admin,super_admin');
    Route::put('/cms/testimonial/{id}', [CMSController::class, 'updateTestimonial'])->name('cms.testimonial.update')->middleware('role:school_admin,super_admin');
    Route::delete('/cms/testimonial/{id}', [CMSController::class, 'destroyTestimonial'])->name('cms.testimonial.destroy')->middleware('role:school_admin,super_admin');

    Route::post('/cms/gallery', [CMSController::class, 'storeGallery'])->name('cms.gallery.store')->middleware('role:school_admin,super_admin');
    Route::put('/cms/gallery/{id}', [CMSController::class, 'updateGallery'])->name('cms.gallery.update')->middleware('role:school_admin,super_admin');
    Route::delete('/cms/gallery/{id}', [CMSController::class, 'destroyGallery'])->name('cms.gallery.destroy')->middleware('role:school_admin,super_admin');

    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('role:school_admin,super_admin');
    Route::post('/settings', [SettingController::class, 'updateSettings'])->name('settings.update')->middleware('role:school_admin,super_admin');
    Route::post('/settings/roles', [SettingController::class, 'storeRole'])->name('settings.role.store')->middleware('role:school_admin,super_admin');
    Route::put('/settings/roles/{id}', [SettingController::class, 'updateRole'])->name('settings.role.update')->middleware('role:school_admin,super_admin');
    Route::delete('/settings/roles/{id}', [SettingController::class, 'destroyRole'])->name('settings.role.destroy')->middleware('role:school_admin,super_admin');
});
