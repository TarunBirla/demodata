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

    // Teachers & Staff (Admin & Teacher View)
    Route::get('/teachers', [TeacherController::class, 'index'])->name('teachers.index')->middleware('role:school_admin,super_admin,teacher');

    // Academics (Classes & Subjects)
    Route::get('/classes', [ClassController::class, 'index'])->name('classes.index');
    Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');

    // Attendance
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'store'])->name('attendance.store')->middleware('role:school_admin,super_admin,teacher');

    // Fees
    Route::get('/fees', [FeeController::class, 'index'])->name('fees.index')->middleware('role:school_admin,super_admin,student,parent');
    Route::post('/fees/collect', [FeeController::class, 'collect'])->name('fees.collect')->middleware('role:school_admin,super_admin');

    // Exams & Marks
    Route::get('/exams', [ExamController::class, 'index'])->name('exams.index');

    // Communication & Homework
    Route::get('/notices', [NoticeController::class, 'index'])->name('notices.index');
    Route::get('/homework', [HomeworkController::class, 'index'])->name('homework.index');

    // Online Admissions (Admin Only)
    Route::get('/admissions', [OnlineAdmissionAdminController::class, 'index'])->name('admissions.index')->middleware('role:school_admin,super_admin');

    // CMS & Settings (Admin Only)
    Route::get('/cms', [CMSController::class, 'index'])->name('cms.index')->middleware('role:school_admin,super_admin');
    Route::post('/cms/hero', [CMSController::class, 'updateHeroSettings'])->name('cms.hero.update')->middleware('role:school_admin,super_admin');
    Route::post('/cms/news', [CMSController::class, 'storeNews'])->name('cms.news.store')->middleware('role:school_admin,super_admin');
    Route::post('/cms/testimonial', [CMSController::class, 'storeTestimonial'])->name('cms.testimonial.store')->middleware('role:school_admin,super_admin');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index')->middleware('role:school_admin,super_admin');
});
