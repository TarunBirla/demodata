<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\School;
use App\Models\User;
use App\Models\AcademicYear;
use App\Models\SchoolClass;
use App\Models\Section;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Staff;
use App\Models\Student;
use App\Models\ParentObject;
use App\Models\StudentAttendance;
use App\Models\FeeStructure;
use App\Models\StudentFee;
use App\Models\FeePayment;
use App\Models\Exam;
use App\Models\ExamSubject;
use App\Models\MarkEntry;
use App\Models\Homework;
use App\Models\Notice;
use App\Models\Event;
use App\Models\CmsNews;
use App\Models\CmsTestimonial;
use App\Models\CmsGallery;
use App\Models\SchoolSetting;
use App\Models\OnlineAdmission;
use App\Models\Book;
use App\Models\Vehicle;
use App\Models\Route;

class DemoSchoolSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create School
        $school = School::create([
            'name' => 'Green Valley International School',
            'code' => 'GVIS001',
            'domain' => 'greenvalley.edu',
            'tagline' => 'Nurturing Future Global Leaders',
            'phone' => '+91 98765 43210',
            'email' => 'admin@greenvalley.edu',
            'address' => 'Knowledge Park II, Greater Noida, Delhi NCR - 201310',
            'principal_name' => 'Dr. Rajesh Sharma, Ph.D.',
            'status' => 'active',
        ]);

        // 2. Settings
        $settings = [
            'school_name' => 'Junior Gurukul School',
            'school_tagline' => 'School · Bhikangaon, M.P.',
            'school_email' => 'info@juniorgurukulschool.in',
            'school_phone' => '096176 14788',
            'school_address' => 'Junior Gurukul School, Seavri Dhaam, Kedwa Road, Bhikangaon, Panchamba, Madhya Pradesh 451331',
            'currency_symbol' => '₹',
            'receipt_prefix' => 'REC-2026-',
            'timezone' => 'Asia/Kolkata',
            'hero_badge' => 'CBSE Affiliated · Admissions Open 2026-27',
            'hero_title' => 'Where Global Minds & Timeless Values Grow',
            'hero_subtitle' => 'Junior Gurukul School, Bhikangaon — blending traditional values with modern, holistic CBSE education to shape confident, capable learners.',
            'hero_image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1800&q=80',
            'principal_message' => 'Welcome to Junior Gurukul School, Bhikangaon. We believe that true education nurtures both the intellect and character, fostering curiosity, moral strength, and academic brilliance.',
            'stat_students' => '600+',
            'stat_faculty' => '40+',
            'stat_years' => '9+',
            'stat_classes' => '20+',
        ];

        foreach ($settings as $k => $v) {
            SchoolSetting::updateOrCreate(
                ['school_id' => $school->id, 'key' => $k],
                ['value' => $v, 'group' => 'general']
            );
        }

        // 3. Academic Year
        $academicYear = AcademicYear::create([
            'school_id' => $school->id,
            'name' => '2026 - 2027',
            'start_date' => '2026-04-01',
            'end_date' => '2027-03-31',
            'is_current' => true,
            'status' => 'active',
        ]);

        // 4. Default Admin Users
        $superAdmin = User::create([
            'school_id' => null,
            'name' => 'Super Administrator',
            'email' => 'superadmin@system.com',
            'role_name' => 'super_admin',
            'phone' => '+91 99000 00000',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);

        $admin = User::create([
            'school_id' => $school->id,
            'name' => 'Dr. Rajesh Sharma',
            'email' => 'admin@greenvalley.edu',
            'role_name' => 'school_admin',
            'phone' => '+91 98765 43210',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);

        // 5. Teachers & Staff
        $teacherData = [
            ['name' => 'Vikram Malhotra', 'email' => 'vikram.m@greenvalley.edu', 'sub' => 'Mathematics', 'qual' => 'M.Sc. Mathematics, B.Ed.'],
            ['name' => 'Priya Sen', 'email' => 'priya.s@greenvalley.edu', 'sub' => 'English Literature', 'qual' => 'M.A. English, B.Ed.'],
            ['name' => 'Anil Verma', 'email' => 'anil.v@greenvalley.edu', 'sub' => 'Physics', 'qual' => 'M.Sc. Physics'],
            ['name' => 'Sunita Rao', 'email' => 'sunita.r@greenvalley.edu', 'sub' => 'Chemistry', 'qual' => 'M.Sc. Chemistry'],
            ['name' => 'Meenakshi Iyer', 'email' => 'meenakshi.i@greenvalley.edu', 'sub' => 'Biology', 'qual' => 'Ph.D. Botany'],
        ];

        $teacherUsers = [];
        foreach ($teacherData as $idx => $t) {
            $u = User::create([
                'school_id' => $school->id,
                'name' => $t['name'],
                'email' => $t['email'],
                'role_name' => 'teacher',
                'phone' => '+91 98111 ' . sprintf('%05d', $idx + 1),
                'password' => Hash::make('password123'),
                'status' => 'active',
            ]);

            Teacher::create([
                'school_id' => $school->id,
                'user_id' => $u->id,
                'employee_id' => 'EMP-T' . (100 + $idx),
                'first_name' => explode(' ', $t['name'])[0],
                'last_name' => explode(' ', $t['name'])[1] ?? '',
                'phone' => $u->phone,
                'email' => $u->email,
                'dob' => '1985-05-15',
                'qualification' => $t['qual'],
                'joining_date' => '2020-06-01',
                'designation' => 'Senior Faculty',
            ]);

            $teacherUsers[] = $u;
        }

        // 6. Classes & Sections
        $classes = [];
        $sections = [];
        for ($grade = 6; $grade <= 10; $grade++) {
            $cls = SchoolClass::create([
                'school_id' => $school->id,
                'name' => "Grade $grade",
                'numeric_value' => $grade,
                'display_order' => $grade,
                'status' => 'active',
            ]);
            $classes[] = $cls;

            foreach (['A', 'B'] as $secIdx => $secName) {
                $teacher = $teacherUsers[($grade + $secIdx) % count($teacherUsers)];
                $sec = Section::create([
                    'school_id' => $school->id,
                    'class_id' => $cls->id,
                    'name' => "Section $secName",
                    'capacity' => 40,
                    'teacher_id' => $teacher->id,
                    'status' => 'active',
                ]);
                $sections[] = $sec;
            }
        }

        // 7. Subjects
        $subjectsData = [
            ['name' => 'Mathematics', 'code' => 'MATH101', 'type' => 'theory'],
            ['name' => 'English Language', 'code' => 'ENG101', 'type' => 'theory'],
            ['name' => 'Physics', 'code' => 'PHY101', 'type' => 'theory'],
            ['name' => 'Chemistry', 'code' => 'CHEM101', 'type' => 'theory'],
            ['name' => 'Computer Science', 'code' => 'CS101', 'type' => 'practical'],
        ];

        $subjectModels = [];
        foreach ($subjectsData as $s) {
            $sub = Subject::create([
                'school_id' => $school->id,
                'name' => $s['name'],
                'code' => $s['code'],
                'type' => $s['type'],
                'status' => 'active',
            ]);
            $subjectModels[] = $sub;

            foreach ($classes as $c) {
                $c->subjects()->attach($sub->id, [
                    'school_id' => $school->id,
                    'teacher_id' => $teacherUsers[rand(0, count($teacherUsers) - 1)]->id,
                    'subject_type' => 'mandatory',
                ]);
            }
        }

        // 8. Parents & Students
        $parentUser = User::create([
            'school_id' => $school->id,
            'name' => 'Ramesh Gupta',
            'email' => 'parent@greenvalley.edu',
            'role_name' => 'parent',
            'phone' => '+91 98222 33344',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);

        $parentObj = ParentObject::create([
            'school_id' => $school->id,
            'user_id' => $parentUser->id,
            'father_name' => 'Ramesh Gupta',
            'mother_name' => 'Sunita Gupta',
            'phone' => '+91 98222 33344',
            'email' => $parentUser->email,
            'occupation' => 'Senior Software Architect',
            'address' => 'Flat 402, Royal Palms, Sector 62, Noida',
        ]);

        $studentNames = [
            ['first' => 'Aarav', 'last' => 'Gupta', 'gender' => 'male', 'is_child' => true],
            ['first' => 'Ananya', 'last' => 'Gupta', 'gender' => 'female', 'is_child' => true],
            ['first' => 'Rohan', 'last' => 'Mehta', 'gender' => 'male', 'is_child' => false],
            ['first' => 'Ishita', 'last' => 'Chawla', 'gender' => 'female', 'is_child' => false],
            ['first' => 'Kabir', 'last' => 'Deshmukh', 'gender' => 'male', 'is_child' => false],
            ['first' => 'Diya', 'last' => 'Kapur', 'gender' => 'female', 'is_child' => false],
            ['first' => 'Aditya', 'last' => 'Joshi', 'gender' => 'male', 'is_child' => false],
            ['first' => 'Sanya', 'last' => 'Nair', 'gender' => 'female', 'is_child' => false],
        ];

        $studentModels = [];
        foreach ($studentNames as $idx => $st) {
            $stEmail = strtolower($st['first']) . '.' . strtolower($st['last']) . '@greenvalley.edu';
            $stUser = User::create([
                'school_id' => $school->id,
                'name' => $st['first'] . ' ' . $st['last'],
                'email' => $stEmail,
                'role_name' => 'student',
                'phone' => '+91 97000 ' . sprintf('%05d', $idx + 1),
                'password' => Hash::make('password123'),
                'status' => 'active',
            ]);

            $class = $classes[$idx % count($classes)];
            $sec = $sections[$idx % count($sections)];

            $studentObj = Student::create([
                'school_id' => $school->id,
                'user_id' => $stUser->id,
                'admission_number' => 'GVIS-2026-' . sprintf('%04d', $idx + 101),
                'first_name' => $st['first'],
                'last_name' => $st['last'],
                'gender' => $st['gender'],
                'dob' => '2012-08-20',
                'blood_group' => 'O+',
                'address' => 'Greater Noida, UP',
                'phone' => $stUser->phone,
                'email' => $stUser->email,
                'academic_year_id' => $academicYear->id,
                'class_id' => $class->id,
                'section_id' => $sec->id,
                'roll_number' => (string)($idx + 1),
                'admission_date' => '2026-04-05',
                'status' => 'active',
            ]);

            $studentModels[] = $studentObj;

            if ($st['is_child']) {
                $parentObj->students()->attach($studentObj->id, ['relationship' => 'father']);
            }

            // Attendance
            for ($d = 1; $d <= 5; $d++) {
                StudentAttendance::create([
                    'school_id' => $school->id,
                    'academic_year_id' => $academicYear->id,
                    'class_id' => $class->id,
                    'section_id' => $sec->id,
                    'student_id' => $studentObj->id,
                    'date' => "2026-09-1$d",
                    'status' => ($d === 3) ? 'absent' : (($d === 4) ? 'late' : 'present'),
                ]);
            }
        }

        // 9. Fee Structures & Payments
        $feeStruct = FeeStructure::create([
            'school_id' => $school->id,
            'academic_year_id' => $academicYear->id,
            'class_id' => $classes[0]->id,
            'name' => 'Q2 Tuition & Composite Fee',
            'amount' => 15000.00,
            'frequency' => 'term',
            'due_date' => '2026-10-15',
            'is_mandatory' => true,
        ]);

        foreach ($studentModels as $st) {
            $stFee = StudentFee::create([
                'school_id' => $school->id,
                'academic_year_id' => $academicYear->id,
                'student_id' => $st->id,
                'fee_structure_id' => $feeStruct->id,
                'amount' => 15000.00,
                'paid_amount' => 15000.00,
                'status' => 'paid',
                'due_date' => '2026-10-15',
            ]);

            FeePayment::create([
                'school_id' => $school->id,
                'student_fee_id' => $stFee->id,
                'student_id' => $st->id,
                'receipt_number' => 'REC-2026-' . rand(10000, 99999),
                'amount' => 15000.00,
                'payment_date' => '2026-09-10',
                'payment_mode' => 'online',
                'reference_number' => 'TXN' . rand(100000, 999999),
                'created_by' => $admin->id,
            ]);
        }

        // 10. Exam & Marks
        $exam = Exam::create([
            'school_id' => $school->id,
            'academic_year_id' => $academicYear->id,
            'name' => 'First Term Examination 2026',
            'start_date' => '2026-09-01',
            'end_date' => '2026-09-10',
            'is_published' => true,
            'status' => 'active',
        ]);

        foreach ($subjectModels as $sub) {
            $examSub = ExamSubject::create([
                'exam_id' => $exam->id,
                'class_id' => $classes[0]->id,
                'subject_id' => $sub->id,
                'exam_date' => '2026-09-02',
                'max_marks' => 100.00,
                'pass_marks' => 35.00,
            ]);

            foreach ($studentModels as $st) {
                $marks = rand(65, 98);
                MarkEntry::create([
                    'exam_subject_id' => $examSub->id,
                    'student_id' => $st->id,
                    'marks_obtained' => $marks,
                    'grade' => ($marks >= 90) ? 'A+' : (($marks >= 80) ? 'A' : 'B'),
                    'result_status' => 'pass',
                    'remarks' => 'Excellent performance',
                    'is_locked' => true,
                ]);
            }
        }

        // 11. Homework & Notices
        Homework::create([
            'school_id' => $school->id,
            'class_id' => $classes[0]->id,
            'section_id' => $sections[0]->id,
            'subject_id' => $subjectModels[0]->id,
            'teacher_id' => $teacherUsers[0]->id,
            'title' => 'Quadratic Equations Worksheet 4',
            'description' => 'Complete problems 1 to 15 from Chapter 4 of the textbook.',
            'assigned_date' => '2026-09-20',
            'due_date' => '2026-09-25',
        ]);

        Notice::create([
            'school_id' => $school->id,
            'title' => 'Parent-Teacher Meeting (PTM) Announcement',
            'description' => 'The First Term PTM will be held on Saturday, 28th September 2026 from 9:00 AM to 1:00 PM.',
            'audience' => 'everyone',
            'publish_date' => '2026-09-20',
        ]);

        Event::create([
            'school_id' => $school->id,
            'title' => 'Annual Inter-House Sports Meet 2026',
            'description' => 'Annual athletic competitions, relay races and sports exhibitions at the school sports complex.',
            'event_date' => '2026-10-10',
            'location' => 'Main Sports Complex',
            'status' => 'active',
        ]);

        // 12. CMS Content
        CmsNews::create([
            'school_id' => $school->id,
            'title' => 'Green Valley Students Win Regional Robotics Championship',
            'slug' => 'robotics-championship-win',
            'summary' => 'Our STEM team bagged 1st prize at the National EdTech Innovation Summit.',
            'content' => 'We are proud to announce that the robotics team of Green Valley International School secured top honors at the National EdTech Innovation Summit...',
            'published_at' => '2026-09-15',
            'status' => 'published',
        ]);

        CmsTestimonial::create([
            'school_id' => $school->id,
            'name' => 'Mrs. Sunita Gupta',
            'role' => 'Parent of Grade 8 Student',
            'content' => 'Green Valley has provided an amazing learning environment for my children. The teachers are deeply dedicated and the facilities are world-class.',
            'is_featured' => true,
        ]);
    }
}
