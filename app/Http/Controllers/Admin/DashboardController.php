<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\StudentAttendance;
use App\Models\FeePayment;
use App\Models\StudentFee;
use App\Models\SchoolClass;
use App\Models\OnlineAdmission;
use App\Models\Notice;
use App\Models\Event;
use App\Models\Homework;
use App\Models\ParentObject;
use App\Models\Section;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $schoolId = $user->school_id ?? 1;
        $userRole = $user->role_name ?? 'school_admin';

        // Base Data
        $totalStudents = Student::where('school_id', $schoolId)->count();
        $totalTeachers = Teacher::where('school_id', $schoolId)->count();
        $totalStaff = Staff::where('school_id', $schoolId)->count();
        $activeClasses = SchoolClass::where('school_id', $schoolId)->count();

        // Attendance stats for today
        $today = now()->format('Y-m-d');
        $presentToday = StudentAttendance::where('school_id', $schoolId)->where('date', $today)->where('status', 'present')->count();
        $absentToday = StudentAttendance::where('school_id', $schoolId)->where('date', $today)->where('status', 'absent')->count();
        $lateToday = StudentAttendance::where('school_id', $schoolId)->where('date', $today)->where('status', 'late')->count();
        $leaveToday = StudentAttendance::where('school_id', $schoolId)->where('date', $today)->where('status', 'leave')->count();

        $totalMarkedToday = $presentToday + $absentToday + $lateToday + $leaveToday;
        $attendanceRate = $totalMarkedToday > 0 ? round(($presentToday / $totalMarkedToday) * 100, 1) : 94.5;

        // Fees stats
        $totalFeeExpected = StudentFee::where('school_id', $schoolId)->sum('amount');
        $totalFeeCollected = FeePayment::where('school_id', $schoolId)->sum('amount');
        $totalFeePending = max(0, $totalFeeExpected - $totalFeeCollected);

        // Recent activity
        $recentPayments = FeePayment::with('student')->where('school_id', $schoolId)->latest()->take(5)->get();
        $recentNotices = Notice::where('school_id', $schoolId)->latest()->take(4)->get();
        $upcomingEvents = Event::where('school_id', $schoolId)->where('event_date', '>=', now()->toDateString())->orderBy('event_date')->take(4)->get();
        $recentAdmissions = OnlineAdmission::where('school_id', $schoolId)->latest()->take(4)->get();

        // Role-Specific Context Data
        $roleContext = [
            'role' => $userRole,
            'title' => 'Executive Dashboard',
            'subtitle' => 'Welcome to Junior Gurukul School Management Panel',
        ];

        if ($userRole === 'teacher') {
            $teacherObj = Teacher::where('user_id', $user->id)->first();
            $teacherIds = array_filter([$user->id, $teacherObj?->id]);
            $mySections = Section::whereIn('teacher_id', $teacherIds)->with('schoolClass')->get();
            $myHomework = !empty($teacherIds) ? Homework::whereIn('teacher_id', $teacherIds)->latest()->take(5)->get() : collect();

            $roleContext['title'] = 'Teacher Portal Dashboard';
            $roleContext['subtitle'] = 'Welcome, ' . ($teacherObj->full_name ?? $user->name) . ' (' . ($teacherObj->designation ?? 'Faculty Member') . ')';
            $roleContext['teacher'] = $teacherObj;
            $roleContext['mySections'] = $mySections;
            $roleContext['myHomework'] = $myHomework;
        } elseif ($userRole === 'student') {
            $studentObj = Student::where('user_id', $user->id)->with(['schoolClass', 'section'])->first();
            if (! $studentObj) {
                $studentObj = Student::where('school_id', $schoolId)->first();
            }

            $myFeeDues = StudentFee::where('student_id', $studentObj->id ?? 0)->get();
            $myPayments = FeePayment::where('student_id', $studentObj->id ?? 0)->get();
            $myAttendanceCount = StudentAttendance::where('student_id', $studentObj->id ?? 0)->where('status', 'present')->count();
            $totalMyAttendance = StudentAttendance::where('student_id', $studentObj->id ?? 0)->count();
            $myAttendancePct = $totalMyAttendance > 0 ? round(($myAttendanceCount / $totalMyAttendance) * 100, 1) : 95.0;

            $myHomework = Homework::where('class_id', $studentObj->class_id ?? 0)->latest()->take(5)->get();

            $roleContext['title'] = 'Student Portal Dashboard';
            $roleContext['subtitle'] = 'Welcome, ' . ($studentObj->full_name ?? $user->name) . ' (' . ($studentObj->schoolClass->name ?? 'Grade') . ' - ' . ($studentObj->section->name ?? 'Section') . ')';
            $roleContext['student'] = $studentObj;
            $roleContext['myFeeDues'] = $myFeeDues;
            $roleContext['myPayments'] = $myPayments;
            $roleContext['myAttendancePct'] = $myAttendancePct;
            $roleContext['myHomework'] = $myHomework;
        } elseif ($userRole === 'parent') {
            $parentObj = ParentObject::where('user_id', $user->id)->with('students.schoolClass')->first();
            if (! $parentObj) {
                $parentObj = ParentObject::where('school_id', $schoolId)->with('students.schoolClass')->first();
            }

            $children = $parentObj ? $parentObj->students : collect();
            $childrenCount = $children->count();

            $roleContext['title'] = 'Parent Portal Dashboard';
            $roleContext['subtitle'] = 'Welcome, ' . ($parentObj->father_name ?? $user->name) . ' (Parent/Guardian)';
            $roleContext['parent'] = $parentObj;
            $roleContext['children'] = $children;
            $roleContext['childrenCount'] = $childrenCount;
        }

        return view('admin.dashboard', compact(
            'totalStudents',
            'totalTeachers',
            'totalStaff',
            'activeClasses',
            'presentToday',
            'absentToday',
            'lateToday',
            'leaveToday',
            'attendanceRate',
            'totalFeeExpected',
            'totalFeeCollected',
            'totalFeePending',
            'recentPayments',
            'recentNotices',
            'upcomingEvents',
            'recentAdmissions',
            'roleContext'
        ));
    }
}
