<?php

return [
    'roles' => [
        'super_admin' => [
            'title' => 'Super Administrator',
            'permissions' => ['*'],
        ],
        'school_admin' => [
            'title' => 'School Administrator',
            'permissions' => [
                'dashboard.view', 'reports.view', 'reports.export',
                'students.view', 'students.create', 'students.edit', 'students.delete', 'students.export', 'students.promote',
                'teachers.view', 'teachers.manage', 'staff.view', 'staff.manage',
                'academics.manage', 'timetable.manage', 'attendance.view', 'attendance.manage',
                'fees.view', 'fees.collect', 'fees.structure',
                'exams.manage', 'marks.entry', 'results.publish',
                'homework.view', 'homework.manage',
                'notices.manage', 'events.manage',
                'website.manage', 'admissions.manage',
                'certificates.manage', 'library.manage', 'transport.manage', 'payroll.manage',
            ],
        ],
        'teacher' => [
            'title' => 'Teacher',
            'permissions' => [
                'dashboard.view',
                'students.view_assigned',
                'classes.view_assigned',
                'subjects.view_assigned', 'subjects.manage_assigned',
                'timetable.view_assigned',
                'attendance.view', 'attendance.manage',
                'exams.view', 'marks.entry',
                'homework.view', 'homework.manage',
                'notices.view',
            ],
        ],
        'student' => [
            'title' => 'Student',
            'permissions' => [
                'dashboard.view',
                'profile.view_own',
                'timetable.view_own',
                'attendance.view_own',
                'marks.view_own',
                'homework.view_own',
                'fees.view_own',
                'notices.view',
            ],
        ],
        'parent' => [
            'title' => 'Parent',
            'permissions' => [
                'dashboard.view',
                'children.view_own',
                'timetable.view_own',
                'attendance.view_own',
                'marks.view_own',
                'homework.view_own',
                'fees.view_own',
                'notices.view',
            ],
        ],
        'accountant' => [
            'title' => 'Accountant',
            'permissions' => [
                'dashboard.view',
                'students.view',
                'fees.view', 'fees.collect', 'fees.structure',
                'reports.view', 'reports.export',
                'notices.view',
            ],
        ],
        'librarian' => [
            'title' => 'Librarian',
            'permissions' => [
                'dashboard.view',
                'students.view',
                'library.manage',
                'notices.view', 'notices.manage',
            ],
        ],
        'transport_manager' => [
            'title' => 'Transport Manager',
            'permissions' => [
                'dashboard.view',
                'students.view',
                'transport.manage',
                'notices.view', 'notices.manage',
            ],
        ],
        'hr_manager' => [
            'title' => 'HR Manager',
            'permissions' => [
                'dashboard.view',
                'teachers.view', 'teachers.manage',
                'staff.view', 'staff.manage',
                'payroll.manage',
                'notices.view', 'notices.manage',
            ],
        ],
    ],
];
