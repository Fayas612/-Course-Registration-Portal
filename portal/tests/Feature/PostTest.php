<?php

namespace Tests\Feature;

use App\Models\Course;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        $user = User::factory()->create();
        $user->is_admin = true;
        $user->save();

        return $user;
    }

    private function makePost(User $author, array $overrides = []): Post
    {
        $post = new Post(array_merge([
            'title' => 'Our first announcement', 'slug' => 'first-announcement',
            'excerpt' => 'Learning starts here.', 'body' => "First paragraph.\n\nSecond paragraph.",
            'is_published' => false, 'published_at' => null,
        ], $overrides));
        $post->user_id = $author->id;
        $post->save();

        return $post;
    }

    private function data(array $overrides = []): array
    {
        return array_merge(['title' => 'A new course', 'excerpt' => 'Join our next course.', 'body' => 'A detailed announcement.', 'is_published' => '1'], $overrides);
    }

    public function test_only_published_posts_are_public(): void
    {
        $admin = $this->admin();
        $draft = $this->makePost($admin);
        $published = $this->makePost($admin, ['slug' => 'published', 'title' => 'Public announcement', 'is_published' => true, 'published_at' => now()->subMinute()]);
        $this->get('/news')->assertOk()->assertSee('Public announcement')->assertDontSee('Our first announcement');
        $this->get('/news/'.$draft->slug)->assertNotFound();
        $this->get('/news/'.$published->slug)->assertOk()->assertSee('Second paragraph.');
        $published->update(['published_at' => now()->addDay()]);
        $this->get('/news/'.$published->slug)->assertNotFound();
    }

    public function test_guest_and_non_admin_cannot_manage_posts_or_dashboard(): void
    {
        $post = $this->makePost($this->admin());
        $urls = ['/admin', '/admin/posts', '/admin/posts/create', "/admin/posts/{$post->id}", "/admin/posts/{$post->id}/edit", "/admin/posts/{$post->id}/delete"];
        foreach ($urls as $url) {
            $this->get($url)->assertRedirect('/login');
        }
        $this->post('/admin/posts', $this->data())->assertRedirect('/login');
        $this->put('/admin/posts/'.$post->id, $this->data())->assertRedirect('/login');
        $this->delete('/admin/posts/'.$post->id)->assertRedirect('/login');
        $this->actingAs(User::factory()->create());
        foreach ($urls as $url) {
            $this->get($url)->assertForbidden();
        }
        $this->post('/admin/posts', $this->data())->assertForbidden();
        $this->put('/admin/posts/'.$post->id, $this->data())->assertForbidden();
        $this->delete('/admin/posts/'.$post->id)->assertForbidden();
    }

    public function test_admin_can_manage_and_unpublish_posts(): void
    {
        $admin = $this->admin();
        $this->actingAs($admin)->get('/admin')->assertOk();
        $this->get('/admin/posts/create')->assertOk();
        $this->post('/admin/posts', $this->data(['user_id' => 999]))->assertRedirect('/admin/posts');
        $post = Post::firstOrFail();
        $this->assertSame($admin->id, $post->user_id);
        $this->assertTrue($post->is_published);
        $this->get('/admin/posts')->assertOk()->assertSee('A new course');
        $this->get('/admin/posts/'.$post->id)->assertOk();
        $this->get('/admin/posts/'.$post->id.'/edit')->assertOk();
        $this->put('/admin/posts/'.$post->id, $this->data(['is_published' => '0', 'title' => 'Draft again']))->assertRedirect('/admin/posts');
        $this->assertFalse($post->fresh()->is_published);
        $this->assertNull($post->fresh()->published_at);
        $this->get('/news/'.$post->slug)->assertNotFound();
        $this->get('/admin/posts/'.$post->id.'/delete')->assertOk()->assertSee('Draft again');
        $this->delete('/admin/posts/'.$post->id)->assertRedirect('/admin/posts');
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_post_forms_validate_on_server_and_escape_content(): void
    {
        $this->actingAs($this->admin())->post('/admin/posts', [])->assertSessionHasErrors(['title', 'excerpt', 'body', 'is_published']);
        $this->post('/admin/posts', $this->data(['title' => str_repeat('a', 181), 'is_published' => 'yes']))->assertSessionHasErrors(['title', 'is_published']);
        $this->assertDatabaseCount('posts', 0);
        $this->post('/admin/posts', $this->data(['body' => '<script>alert("test")</script>']))->assertRedirect();
        $post = Post::firstOrFail();
        $this->get('/news/'.$post->slug)->assertOk()->assertSee('<script>alert("test")</script>')->assertDontSee('<script>alert("test")</script>', false);
    }

    public function test_course_view_and_delete_confirmation_are_admin_only(): void
    {
        $course = Course::create(['title' => 'Course', 'description' => 'Description', 'duration' => '4 weeks', 'fee' => 1000, 'start_date' => '2027-01-01']);
        foreach (["/admin/courses/{$course->id}", "/admin/courses/{$course->id}/delete"] as $url) {
            $this->get($url)->assertRedirect('/login');
        }
        $this->actingAs(User::factory()->create());
        $this->get('/admin/courses/'.$course->id)->assertForbidden();
        $this->get('/admin/courses/'.$course->id.'/delete')->assertForbidden();
        $this->actingAs($this->admin());
        $this->get('/admin/courses/'.$course->id)->assertOk()->assertSee('COURSE DETAILS', false);
        $this->get('/admin/courses/'.$course->id.'/delete')->assertOk()->assertSee('This action cannot be undone.');
        $this->assertDatabaseCount('courses', 1);
    }

    public function test_admin_creation_command_hashes_password(): void
    {
        $this->artisan('portal:admin')
            ->expectsQuestion('Administrator name', 'Portal Administrator')
            ->expectsQuestion('Administrator email', 'ADMIN@example.com')
            ->expectsQuestion('Password (at least 12 characters)', 'TestPassword123!')
            ->assertExitCode(0);
        $user = User::where('email', 'admin@example.com')->firstOrFail();
        $this->assertTrue($user->is_admin);
        $this->assertTrue(Hash::check('TestPassword123!', $user->password));
    }
}
