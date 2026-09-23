<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;

class RoleBasedDashboardTest extends TestCase
{
    public function test_school_admin_can_access_dashboard_and_settings(): void
    {
        $admin = User::where('role_name', 'school_admin')->first();
        $this->assertNotNull($admin);

        $response = $this->actingAs($admin)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Executive Dashboard');

        $settingsResponse = $this->actingAs($admin)->get('/admin/settings');
        $settingsResponse->assertStatus(200);
        $settingsResponse->assertSee('System Settings');
    }

    public function test_teacher_can_access_dashboard_and_attendance_but_restricted_from_settings(): void
    {
        $teacher = User::where('role_name', 'teacher')->first();
        $this->assertNotNull($teacher);

        $response = $this->actingAs($teacher)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Teacher Portal Dashboard');

        $attendanceResponse = $this->actingAs($teacher)->get('/admin/attendance');
        $attendanceResponse->assertStatus(200);

        $settingsResponse = $this->actingAs($teacher)->get('/admin/settings');
        $settingsResponse->assertRedirect(route('admin.dashboard'));
    }

    public function test_parent_can_access_dashboard_and_children_details_but_restricted_from_cms(): void
    {
        $parent = User::where('role_name', 'parent')->first();
        $this->assertNotNull($parent);

        $response = $this->actingAs($parent)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Parent Portal Dashboard');

        $cmsResponse = $this->actingAs($parent)->get('/admin/cms');
        $cmsResponse->assertRedirect(route('admin.dashboard'));
    }

    public function test_student_can_access_dashboard_and_homework_but_restricted_from_admissions(): void
    {
        $student = User::where('role_name', 'student')->first();
        $this->assertNotNull($student);

        $response = $this->actingAs($student)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Student Portal Dashboard');

        $homeworkResponse = $this->actingAs($student)->get('/admin/homework');
        $homeworkResponse->assertStatus(200);

        $admissionsResponse = $this->actingAs($student)->get('/admin/admissions');
        $admissionsResponse->assertRedirect(route('admin.dashboard'));
    }
}
