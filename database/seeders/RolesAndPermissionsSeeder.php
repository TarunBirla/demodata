<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            // General & Dashboard
            ['name' => 'View Dashboard', 'slug' => 'dashboard.view', 'group' => 'dashboard'],
            ['name' => 'View Reports', 'slug' => 'reports.view', 'group' => 'reports'],
            ['name' => 'Export Reports', 'slug' => 'reports.export', 'group' => 'reports'],

            // Students
            ['name' => 'View Students', 'slug' => 'students.view', 'group' => 'students'],
            ['name' => 'Create Student', 'slug' => 'students.create', 'group' => 'students'],
            ['name' => 'Edit Student', 'slug' => 'students.edit', 'group' => 'students'],
            ['name' => 'Delete Student', 'slug' => 'students.delete', 'group' => 'students'],
            ['name' => 'Export Students', 'slug' => 'students.export', 'group' => 'students'],
            ['name' => 'Promote Student', 'slug' => 'students.promote', 'group' => 'students'],

            // Teachers & Staff
            ['name' => 'View Teachers', 'slug' => 'teachers.view', 'group' => 'teachers'],
            ['name' => 'Manage Teachers', 'slug' => 'teachers.manage', 'group' => 'teachers'],
            ['name' => 'View Staff', 'slug' => 'staff.view', 'group' => 'staff'],
            ['name' => 'Manage Staff', 'slug' => 'staff.manage', 'group' => 'staff'],

            // Academics & Timetable
            ['name' => 'Manage Academics', 'slug' => 'academics.manage', 'group' => 'academics'],
            ['name' => 'Manage Timetable', 'slug' => 'timetable.manage', 'group' => 'timetable'],

            // Attendance
            ['name' => 'View Attendance', 'slug' => 'attendance.view', 'group' => 'attendance'],
            ['name' => 'Manage Attendance', 'slug' => 'attendance.manage', 'group' => 'attendance'],

            // Fees
            ['name' => 'View Fees', 'slug' => 'fees.view', 'group' => 'fees'],
            ['name' => 'Collect Fees', 'slug' => 'fees.collect', 'group' => 'fees'],
            ['name' => 'Manage Fee Structure', 'slug' => 'fees.structure', 'group' => 'fees'],

            // Exams & Marks
            ['name' => 'Manage Exams', 'slug' => 'exams.manage', 'group' => 'exams'],
            ['name' => 'Enter Marks', 'slug' => 'marks.entry', 'group' => 'exams'],
            ['name' => 'Publish Results', 'slug' => 'results.publish', 'group' => 'exams'],

            // Homework
            ['name' => 'View Homework', 'slug' => 'homework.view', 'group' => 'homework'],
            ['name' => 'Manage Homework', 'slug' => 'homework.manage', 'group' => 'homework'],

            // Notices & Communication
            ['name' => 'Manage Notices', 'slug' => 'notices.manage', 'group' => 'communication'],
            ['name' => 'Manage Events', 'slug' => 'events.manage', 'group' => 'communication'],

            // Website CMS & Online Admission
            ['name' => 'Manage Website', 'slug' => 'website.manage', 'group' => 'website'],
            ['name' => 'Manage Admissions', 'slug' => 'admissions.manage', 'group' => 'admissions'],

            // Certificates, Library, Transport, HR
            ['name' => 'Manage Certificates', 'slug' => 'certificates.manage', 'group' => 'certificates'],
            ['name' => 'Manage Library', 'slug' => 'library.manage', 'group' => 'library'],
            ['name' => 'Manage Transport', 'slug' => 'transport.manage', 'group' => 'transport'],
            ['name' => 'Manage Payroll', 'slug' => 'payroll.manage', 'group' => 'hr'],

            // Settings & Security
            ['name' => 'Manage Settings', 'slug' => 'settings.manage', 'group' => 'settings'],
            ['name' => 'View Audit Logs', 'slug' => 'audit.view', 'group' => 'security'],
        ];

        foreach ($permissions as $p) {
            Permission::firstOrCreate(['slug' => $p['slug']], $p);
        }

        // Roles
        $roles = [
            ['name' => 'Super Admin', 'slug' => 'super_admin', 'description' => 'Global SaaS System Administrator'],
            ['name' => 'School Admin', 'slug' => 'school_admin', 'description' => 'Full administrative access to school operations'],
            ['name' => 'Teacher', 'slug' => 'teacher', 'description' => 'Academic instruction, attendance marking, homework & marks entry'],
            ['name' => 'Parent', 'slug' => 'parent', 'description' => 'Access to student progress, fees, attendance & notices'],
            ['name' => 'Student', 'slug' => 'student', 'description' => 'Access to student timetable, homework, exam results & notices'],
            ['name' => 'Accountant', 'slug' => 'accountant', 'description' => 'Fee collection, receipts, and financial reporting'],
            ['name' => 'Librarian', 'slug' => 'librarian', 'description' => 'Library catalog and book issuing'],
            ['name' => 'Transport Manager', 'slug' => 'transport_manager', 'description' => 'Vehicles, routes and transport fee assignments'],
            ['name' => 'HR Manager', 'slug' => 'hr_manager', 'description' => 'Staff registry, attendance and payroll slips'],
        ];

        foreach ($roles as $r) {
            Role::firstOrCreate(['slug' => $r['slug']], $r);
        }
    }
}
