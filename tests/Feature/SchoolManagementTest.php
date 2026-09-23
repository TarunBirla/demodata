<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\School;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\Section;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SchoolManagementTest extends TestCase
{
    public function test_public_website_loads_successfully(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee('Junior Gurukul');
    }

    public function test_login_page_loads_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Sign In to Your Account');
    }

    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::where('role_name', 'school_admin')->first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/dashboard');
        $response->assertStatus(200);
        $response->assertSee('Executive Dashboard');
    }

    public function test_student_directory_page_loads(): void
    {
        $user = User::where('role_name', 'school_admin')->first() ?? User::factory()->create();

        $response = $this->actingAs($user)->get('/admin/students');
        $response->assertStatus(200);
        $response->assertSee('Student Management');
    }
}
