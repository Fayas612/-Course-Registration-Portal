<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PortalTest extends TestCase
{
    use RefreshDatabase;

    private function course(array $overrides = []): Course
    {
        return Course::create(array_merge(['title' => 'Laravel Basics', 'description' => 'Build web applications', 'duration' => '6 weeks', 'fee' => 5000, 'start_date' => '2027-01-01'], $overrides));
    }

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->is_admin = true;
        $user->save();

        return $user;
    }

    private function payload(): array
    {
        return ['title' => 'PHP Course', 'description' => 'Learn PHP', 'duration' => '4 weeks', 'fee' => '2500.00', 'start_date' => '2027-02-01'];
    }

    public function test_public_catalog_and_api(): void
    {
        $this->course();
        $this->get('/')->assertOk()->assertSee('Laravel Basics');
        $this->getJson('/api/courses')->assertOk()->assertJsonCount(1)->assertJsonPath('0.title', 'Laravel Basics')->assertJsonMissingPath('0.registrations');
    }

    public function test_anonymous_admin_routes_are_protected(): void
    {
        $course = $this->course();
        foreach (['/admin/courses', '/admin/courses/create', "/admin/courses/{$course->id}/edit", '/admin/registrations'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
        $this->post('/admin/courses', $this->payload())->assertRedirect('/login');
        $this->put("/admin/courses/{$course->id}", $this->payload())->assertRedirect('/login');
        $this->delete("/admin/courses/{$course->id}")->assertRedirect('/login');
    }

    public function test_non_admin_is_forbidden(): void
    {
        $course = $this->course();
        $this->actingAs(User::factory()->create());
        $this->get('/admin/courses')->assertForbidden();
        $this->get('/admin/courses/create')->assertForbidden();
        $this->get("/admin/courses/{$course->id}/edit")->assertForbidden();
        $this->post('/admin/courses', $this->payload())->assertForbidden();
        $this->put("/admin/courses/{$course->id}", $this->payload())->assertForbidden();
        $this->delete("/admin/courses/{$course->id}")->assertForbidden();
        $this->get('/admin/registrations')->assertForbidden();
    }

    public function test_admin_can_create_update_view_and_delete(): void
    {
        $this->actingAs($this->admin());
        $this->get('/admin/courses/create')->assertOk();
        $this->post('/admin/courses', $this->payload())->assertRedirect('/admin/courses');
        $course = Course::firstOrFail();
        $this->get('/admin/courses')->assertOk()->assertSee('PHP Course');
        $this->get("/admin/courses/{$course->id}/edit")->assertOk();
        $this->put("/admin/courses/{$course->id}", array_merge($this->payload(), ['title' => 'Updated Course']))->assertRedirect('/admin/courses');
        $this->assertDatabaseHas('courses', ['id' => $course->id, 'title' => 'Updated Course']);
        $this->delete("/admin/courses/{$course->id}")->assertRedirect('/admin/courses');
        $this->assertDatabaseMissing('courses', ['id' => $course->id]);
    }

    public function test_course_server_validation(): void
    {
        $this->actingAs($this->admin())->post('/admin/courses', ['fee' => -1])->assertSessionHasErrors(['title', 'description', 'duration', 'fee', 'start_date']);
        $this->assertDatabaseCount('courses', 0);
    }

    public function test_registration_and_case_insensitive_duplicate_rejection(): void
    {
        $course = $this->course();
        $this->get("/courses/{$course->id}/register")->assertOk();
        $data = ['name' => 'Asha Silva', 'email' => 'ASHA@example.com', 'phone' => '+94 77 123 4567'];
        $this->post("/courses/{$course->id}/register", $data)->assertRedirect('/');
        $this->assertDatabaseHas('registrations', ['email' => 'asha@example.com', 'course_id' => $course->id]);
        $this->post("/courses/{$course->id}/register", array_merge($data, ['email' => 'asha@example.com']))->assertSessionHasErrors('email');
        $this->assertDatabaseCount('registrations', 1);
        $other = $this->course(['title' => 'Other Course']);
        $this->post("/courses/{$other->id}/register", $data)->assertRedirect('/');
        $this->assertDatabaseCount('registrations', 2);
    }

    public function test_invalid_registration_and_missing_course(): void
    {
        $course = $this->course();
        $this->post("/courses/{$course->id}/register", ['name' => '', 'email' => 'bad', 'phone' => 'abc'])->assertSessionHasErrors(['name', 'email', 'phone']);
        $this->assertDatabaseCount('registrations', 0);
        $this->get('/courses/99999/register')->assertNotFound();
    }

    public function test_admin_registrations_and_cascading_delete(): void
    {
        $course = $this->course();
        $course->registrations()->create(['name' => 'Asha', 'email' => 'asha@example.com', 'phone' => '0771234567']);
        $this->actingAs($this->admin())->get('/admin/registrations')->assertOk()->assertSee('asha@example.com');
        $this->delete("/admin/courses/{$course->id}")->assertRedirect();
        $this->assertDatabaseCount('registrations', 0);
    }

    public function test_login_logout_and_wrong_password(): void
    {
        $user = $this->admin();
        $user->password = Hash::make('StrongPassword123!');
        $user->save();
        $this->get('/login')->assertOk();
        $this->post('/login', ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->assertGuest();
        $this->post('/login', ['email' => $user->email, 'password' => 'StrongPassword123!'])->assertRedirect('/admin/courses');
        $this->assertAuthenticatedAs($user);
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_regular_user_cannot_login_as_admin(): void
    {
        $user = User::factory()->create(['password' => Hash::make('StrongPassword123!')]);
        $this->post('/login', ['email' => $user->email, 'password' => 'StrongPassword123!'])->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_duplicate_constraint_protects_database(): void
    {
        $course = $this->course();
        $data = ['name' => 'Asha', 'email' => 'asha@example.com', 'phone' => '0771234567'];
        $course->registrations()->create($data);
        $this->expectException(UniqueConstraintViolationException::class);
        $course->registrations()->create($data);
    }
}
