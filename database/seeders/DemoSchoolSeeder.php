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
        // 1. Create Primary School (Junior Gurukul School - ID 1)
        $school = School::create([
            'name' => 'Junior Gurukul School',
            'code' => 'JGS001',
            'domain' => 'juniorgurukulschool.in',
            'tagline' => 'Nurturing Future Global Leaders',
            'phone' => '096176 14788',
            'email' => 'info@juniorgurukulschool.in',
            'address' => 'Junior Gurukul School, Seavri Dhaam, Kedwa Road, Bhikangaon, M.P.',
            'principal_name' => 'Dr. Rajesh Sharma, Ph.D.',
            'status' => 'active',
        ]);

        // 4. Seed User Accounts for All System Roles
        // Super Admin
        $superAdmin = User::create([
            'school_id' => $school->id,
            'name' => 'Super Administrator',
            'email' => 'superadmin@system.com',
            'role_name' => 'super_admin',
            'phone' => '+91 99000 00000',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);

        // School Admin (Junior Gurukul School)
        $admin = User::create([
            'school_id' => $school->id,
            'name' => 'School Admin',
            'email' => 'admin@juniorgurukulschool.in',
            'role_name' => 'school_admin',
            'phone' => '+91 98765 43210',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);

        // Accountant
        $accountant = User::create([
            'school_id' => $school->id,
            'name' => 'Ramesh Finance Officer',
            'email' => 'accountant@juniorgurukulschool.in',
            'role_name' => 'accountant',
            'phone' => '+91 98222 11111',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);
        Staff::create([
            'school_id' => $school->id,
            'user_id' => $accountant->id,
            'employee_id' => 'EMP-FIN-01',
            'name' => 'Ramesh Finance Officer',
            'department' => 'Accounts & Finance',
            'designation' => 'Head Accountant',
            'phone' => $accountant->phone,
            'email' => $accountant->email,
            'joining_date' => '2021-04-01',
            'basic_salary' => 45000,
            'status' => 'active',
        ]);

        // Librarian
        $librarian = User::create([
            'school_id' => $school->id,
            'name' => 'Suman Library Incharge',
            'email' => 'librarian@juniorgurukulschool.in',
            'role_name' => 'librarian',
            'phone' => '+91 98222 22222',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);
        Staff::create([
            'school_id' => $school->id,
            'user_id' => $librarian->id,
            'employee_id' => 'EMP-LIB-01',
            'name' => 'Suman Library Incharge',
            'department' => 'Library Services',
            'designation' => 'Chief Librarian',
            'phone' => $librarian->phone,
            'email' => $librarian->email,
            'joining_date' => '2021-05-15',
            'basic_salary' => 38000,
            'status' => 'active',
        ]);

        // Transport Manager
        $transportMgr = User::create([
            'school_id' => $school->id,
            'name' => 'Mahesh Transport Head',
            'email' => 'transport@juniorgurukulschool.in',
            'role_name' => 'transport_manager',
            'phone' => '+91 98222 33333',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);
        Staff::create([
            'school_id' => $school->id,
            'user_id' => $transportMgr->id,
            'employee_id' => 'EMP-TRN-01',
            'name' => 'Mahesh Transport Head',
            'department' => 'Logistics & Transport',
            'designation' => 'Transport Manager',
            'phone' => $transportMgr->phone,
            'email' => $transportMgr->email,
            'joining_date' => '2022-01-10',
            'basic_salary' => 40000,
            'status' => 'active',
        ]);

        // HR Manager
        $hrMgr = User::create([
            'school_id' => $school->id,
            'name' => 'Anita HR Officer',
            'email' => 'hr@juniorgurukulschool.in',
            'role_name' => 'hr_manager',
            'phone' => '+91 98222 44444',
            'password' => Hash::make('password123'),
            'status' => 'active',
        ]);
        Staff::create([
            'school_id' => $school->id,
            'user_id' => $hrMgr->id,
            'employee_id' => 'EMP-HR-01',
            'name' => 'Anita HR Officer',
            'department' => 'Human Resources',
            'designation' => 'HR Manager',
            'phone' => $hrMgr->phone,
            'email' => $hrMgr->email,
            'joining_date' => '2020-08-01',
            'basic_salary' => 50000,
            'status' => 'active',
        ]);

        // 5. Teachers & Staff (10 Teachers with real photos)
        $teacherData = [
            [
                'name' => 'Vikram Malhotra',
                'email' => 'vikram.m@juniorgurukulschool.in',
                'sub' => 'Mathematics',
                'qual' => 'M.Sc. Mathematics, B.Ed.',
                'desig' => 'Senior Mathematics Faculty',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Priya Sen',
                'email' => 'priya.s@juniorgurukulschool.in',
                'sub' => 'English Literature',
                'qual' => 'M.A. English, B.Ed.',
                'desig' => 'Head of English Dept.',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Anil Verma',
                'email' => 'anil.v@juniorgurukulschool.in',
                'sub' => 'Physics',
                'qual' => 'M.Sc. Physics, M.Phil.',
                'desig' => 'Senior Physics Faculty',
                'photo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Sunita Rao',
                'email' => 'sunita.r@juniorgurukulschool.in',
                'sub' => 'Chemistry',
                'qual' => 'M.Sc. Chemistry, B.Ed.',
                'desig' => 'Chemistry Department Head',
                'photo' => 'https://images.unsplash.com/photo-1580894732413-8472f8832a82?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Meenakshi Iyer',
                'email' => 'meenakshi.i@juniorgurukulschool.in',
                'sub' => 'Biology',
                'qual' => 'Ph.D. Botany, B.Ed.',
                'desig' => 'Life Sciences Lead',
                'photo' => 'https://images.unsplash.com/photo-1567532939604-b6b5b0db2604?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Rajesh Chouhan',
                'email' => 'rajesh.c@juniorgurukulschool.in',
                'sub' => 'Computer Science',
                'qual' => 'M.Tech Computer Science',
                'desig' => 'STEM & Coding Director',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Kavita Joshi',
                'email' => 'kavita.j@juniorgurukulschool.in',
                'sub' => 'Social Science',
                'qual' => 'M.A. History & Civics, B.Ed.',
                'desig' => 'Social Science Mentor',
                'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Devendra Solanki',
                'email' => 'devendra.s@juniorgurukulschool.in',
                'sub' => 'Physical Education',
                'qual' => 'M.P.Ed., Sports Specialist',
                'desig' => 'Head Sports Coach',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Anjali Deshmukh',
                'email' => 'anjali.d@juniorgurukulschool.in',
                'sub' => 'Primary Education',
                'qual' => 'M.A. Child Psychology, B.Ed.',
                'desig' => 'Primary Wing Headmistress',
                'photo' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'Rameshwar Shastri',
                'email' => 'rameshwar.s@juniorgurukulschool.in',
                'sub' => 'Sanskrit & Values',
                'qual' => 'Acharya in Sanskrit, M.A.',
                'desig' => 'Sanskar & Cultural Mentor',
                'photo' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=500&q=80'
            ],
            [
                'name' => 'New Faculty (Unassigned)',
                'email' => 'new.teacher@juniorgurukulschool.in',
                'sub' => 'Unassigned',
                'qual' => 'B.Ed.',
                'desig' => 'Junior Faculty Member',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=500&q=80'
            ]
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
                'photo' => $t['photo'],
                'qualification' => $t['qual'],
                'joining_date' => '2020-06-01',
                'designation' => $t['desig'],
                'status' => 'active',
            ]);

            $teacherUsers[] = $u;
        }

        // 6. Classes & Sections (Pre-Primary to Grade 10)
        $classes = [];
        $sections = [];
        $classList = [
            ['name' => 'Nursery', 'num' => 0],
            ['name' => 'LKG', 'num' => 0],
            ['name' => 'UKG', 'num' => 0],
            ['name' => 'Grade 1', 'num' => 1],
            ['name' => 'Grade 2', 'num' => 2],
            ['name' => 'Grade 3', 'num' => 3],
            ['name' => 'Grade 4', 'num' => 4],
            ['name' => 'Grade 5', 'num' => 5],
            ['name' => 'Grade 6', 'num' => 6],
            ['name' => 'Grade 7', 'num' => 7],
            ['name' => 'Grade 8', 'num' => 8],
            ['name' => 'Grade 9', 'num' => 9],
            ['name' => 'Grade 10', 'num' => 10],
        ];

        foreach ($classList as $order => $cData) {
            $cls = SchoolClass::create([
                'school_id' => $school->id,
                'name' => $cData['name'],
                'numeric_value' => $cData['num'],
                'display_order' => $order + 1,
                'status' => 'active',
            ]);
            $classes[] = $cls;

            foreach (['A', 'B'] as $secIdx => $secName) {
                $teacher = $teacherUsers[($order + $secIdx) % count($teacherUsers)];
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
            ['name' => 'Physics & Science', 'code' => 'PHY101', 'type' => 'theory'],
            ['name' => 'Chemistry & Experiments', 'code' => 'CHEM101', 'type' => 'practical'],
            ['name' => 'Computer Science & Coding', 'code' => 'CS101', 'type' => 'practical'],
            ['name' => 'Social Studies & Civics', 'code' => 'SST101', 'type' => 'theory'],
            ['name' => 'Hindi & Literature', 'code' => 'HIN101', 'type' => 'theory'],
            ['name' => 'Sanskrit & Vedic Values', 'code' => 'SAN101', 'type' => 'theory'],
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
            'email' => 'parent@juniorgurukulschool.in',
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
            'occupation' => 'Senior Businessman',
            'address' => 'Kedwa Road, Bhikangaon, MP',
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
            $stEmail = strtolower($st['first']) . '.' . strtolower($st['last']) . '@juniorgurukulschool.in';
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
                'admission_number' => 'JGS-2026-' . sprintf('%04d', $idx + 101),
                'first_name' => $st['first'],
                'last_name' => $st['last'],
                'gender' => $st['gender'],
                'dob' => '2012-08-20',
                'blood_group' => 'O+',
                'address' => 'Bhikangaon, Madhya Pradesh',
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

        // 12. CMS Content (8 News Articles with unique images)
        $newsItems = [
            [
                'title' => 'Junior Gurukul STEM Team Wins Regional Robotics Championship',
                'slug' => 'robotics-championship-win',
                'summary' => 'Our STEM & Coding team bagged 1st prize at the State EdTech Innovation Summit.',
                'image' => 'https://images.unsplash.com/photo-1485827404703-89b55fcc595e?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Annual Inter-House Athletics & Sports Meet Concludes',
                'slug' => 'annual-sports-meet-2026',
                'summary' => 'Over 400 students participated in sprint relays, long jump, and athletic games at Kedwa Road complex.',
                'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Sanskar & Vedic Cultural Heritage Festival Celebrated',
                'slug' => 'cultural-heritage-festival',
                'summary' => 'Students showcased classical music, shlok recitations, and folk dances celebrating Indian culture.',
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'State-of-the-Art Interactive Digital Smart Classrooms Inaugurated',
                'slug' => 'digital-smart-classrooms',
                'summary' => 'Interactive flat panels and 3D visual learning modules deployed across all primary & middle grades.',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'District Level Science Fair: 80+ Student Projects Featured',
                'slug' => 'district-science-fair',
                'summary' => 'Junior Gurukul young scientists demonstrated renewable energy and AI robotics prototypes.',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Tree Plantation & Environmental Awareness Drive at Bhikangaon',
                'slug' => 'tree-plantation-drive',
                'summary' => 'Over 300 saplings planted along Kedwa Road campus as part of Green Eco-Club initiative.',
                'image' => 'https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'CBSE Board Examination Orientation & Stress Management Workshop',
                'slug' => 'cbse-board-orientation',
                'summary' => 'Senior academic counsellors guided Grade 9 & 10 students on exam strategy and time management.',
                'image' => 'https://images.unsplash.com/photo-1434030216411-0b793f4b4173?auto=format&fit=crop&w=800&q=80',
            ],
            [
                'title' => 'Art, Craft & Clay Modeling Exhibition Highlights Creativity',
                'slug' => 'art-craft-exhibition',
                'summary' => 'Pre-Primary and Primary wing children created stunning handicrafts and watercolor paintings.',
                'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=800&q=80',
            ]
        ];

        foreach ($newsItems as $n) {
            CmsNews::create([
                'school_id' => $school->id,
                'title' => $n['title'],
                'slug' => $n['slug'],
                'summary' => $n['summary'],
                'content' => $n['summary'] . ' Full details and highlights of the event will be shared with parents via circulars.',
                'image' => $n['image'],
                'published_at' => '2026-09-15',
                'status' => 'published',
            ]);
        }

        // 13. Testimonials (8 Parents & Alumni with distinct photos)
        $testimonialItems = [
            [
                'name' => 'Mrs. Sunita Gupta',
                'role' => 'Parent of Grade 8 Scholar',
                'photo' => 'https://images.unsplash.com/photo-1544005313-94ddf0286df2?auto=format&fit=crop&w=300&q=80',
                'content' => 'Junior Gurukul School has provided an amazing learning environment for my children. The teachers are deeply dedicated, individual attention is given to every child, and traditional values are taught every day.'
            ],
            [
                'name' => 'Mr. Rajesh Patel',
                'role' => 'Parent of Grade 5 & 10 Students',
                'photo' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=300&q=80',
                'content' => 'The combination of smart classrooms, CBSE curriculum, and extracurricular activities at Junior Gurukul School Bhikangaon has brought tremendous confidence in both my children.'
            ],
            [
                'name' => 'Dr. Meera Sharma',
                'role' => 'Alumni Parent & Medical Doctor',
                'photo' => 'https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?auto=format&fit=crop&w=300&q=80',
                'content' => 'As a healthcare professional, I appreciate the holistic approach to health, yoga, and academics. My daughter received solid guidance from her mentors here.'
            ],
            [
                'name' => 'Mr. Manoj Mahajan',
                'role' => 'Parent from Bhikangaon Town',
                'photo' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=300&q=80',
                'content' => 'Safe campus transport, disciplined environment, and approachable principal make Junior Gurukul the absolute best school choice in our region.'
            ],
            [
                'name' => 'Mrs. Rekha Joshi',
                'role' => 'Parent of Primary Wing Student',
                'photo' => 'https://images.unsplash.com/photo-1580894732413-8472f8832a82?auto=format&fit=crop&w=300&q=80',
                'content' => 'The teachers at Junior Gurukul are warm, patient, and truly care about every child. My son looks forward to going to school every single morning!'
            ],
            [
                'name' => 'Mr. Anand Verma',
                'role' => 'Parent of Grade 9 Student',
                'photo' => 'https://images.unsplash.com/photo-1539571696357-5a69c17a67c6?auto=format&fit=crop&w=300&q=80',
                'content' => 'The STEM labs and computer education here match top city schools while preserving Indian Sanskar and respect for elders.'
            ],
            [
                'name' => 'Pooja Solanki',
                'role' => 'Alumni - Class of 2024 (B.Tech Scholar)',
                'photo' => 'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?auto=format&fit=crop&w=300&q=80',
                'content' => 'The strong foundation in mathematics and science I received at Junior Gurukul enabled me to clear competitive entrance exams with top scores.'
            ],
            [
                'name' => 'Mr. Nitin Chouhan',
                'role' => 'Parent & Local Entrepreneur',
                'photo' => 'https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&w=300&q=80',
                'content' => 'Outstanding infrastructure, regular Parent-Teacher meetings, and transparent communication. We are very proud to be part of the Junior Gurukul family.'
            ]
        ];

        foreach ($testimonialItems as $t) {
            CmsTestimonial::create([
                'school_id' => $school->id,
                'name' => $t['name'],
                'role' => $t['role'],
                'photo' => $t['photo'],
                'content' => $t['content'],
                'is_featured' => true,
                'status' => 'active',
            ]);
        }

        // 14. Photo Gallery (10 items across categories)
        $galleryItems = [
            [
                'title' => 'Interactive Digital Smart Classrooms',
                'category' => 'Campus',
                'image' => 'https://images.unsplash.com/photo-1509062522246-3755977927d7?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Smart boards and digital interactive learning.'
            ],
            [
                'title' => 'Advanced STEM & Science Laboratories',
                'category' => 'Science Lab',
                'image' => 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Hands-on physics, chemistry, and biology experiments.'
            ],
            [
                'title' => 'Annual Cultural & Music Festival',
                'category' => 'Events',
                'image' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Students performing traditional dances and music.'
            ],
            [
                'title' => 'Annual Inter-House Athletics Meet',
                'category' => 'Sports',
                'image' => 'https://images.unsplash.com/photo-1461896836934-ffe607ba8211?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Track events and sports competitions at Kedwa Road.'
            ],
            [
                'title' => 'Gurukul Morning Sanskar & Vedic Assembly',
                'category' => 'Campus',
                'image' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Daily prayers, shlok recitations, and value education.'
            ],
            [
                'title' => 'Library & Knowledge Reading Centre',
                'category' => 'Academics',
                'image' => 'https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Rich collection of textbooks, reference books, and storybooks.'
            ],
            [
                'title' => 'Computer & Coding Innovation Lab',
                'category' => 'Technology',
                'image' => 'https://images.unsplash.com/photo-1531482615713-2afd69097998?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'High-speed computer systems for digital literacy.'
            ],
            [
                'title' => 'Yoga & Wellness Morning Activity',
                'category' => 'Wellness',
                'image' => 'https://images.unsplash.com/photo-1544367567-0f2fcb009e0b?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Physical fitness, pranayam, and mental focus.'
            ],
            [
                'title' => 'Art, Craft & Creative Exhibition',
                'category' => 'Creative Arts',
                'image' => 'https://images.unsplash.com/photo-1513364776144-60967b0f800f?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Paintings and handicrafts crafted by students.'
            ],
            [
                'title' => 'Junior Kindergarten Activity Playground',
                'category' => 'Primary',
                'image' => 'https://images.unsplash.com/photo-1587654780291-39c9404d746b?auto=format&fit=crop&w=1200&q=80',
                'desc' => 'Safe play arena for kindergarten learners.'
            ]
        ];

        foreach ($galleryItems as $g) {
            CmsGallery::create([
                'school_id' => $school->id,
                'title' => $g['title'],
                'image_path' => $g['image'],
                'category' => $g['category'],
                'description' => $g['desc'],
            ]);
        }
    }
}
