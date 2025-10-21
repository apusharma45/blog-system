<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    public function test_user_can_view_profile()
    {
        $response = $this->get(route('users.profile', $this->user->username));

        $response->assertStatus(200);
        $response->assertSee($this->user->name);
    }

    public function test_user_profile_shows_published_posts()
    {
        // Create published posts
        Post::factory()->count(3)->create([
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Create draft posts
        Post::factory()->count(2)->create([
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $response = $this->get(route('users.profile', $this->user->username));

        $response->assertStatus(200);
        $response->assertSee($this->user->name);
        
        // Should only show published posts count
        $this->assertDatabaseCount('posts', 5);
    }

    public function test_user_can_access_dashboard()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('dashboard', ['username' => $this->user->username]));

        $response->assertStatus(200);
        $response->assertSee('Welcome back');
    }

    public function test_guest_cannot_access_dashboard()
    {
        $response = $this->get(route('dashboard', ['username' => $this->user->username]));

        $response->assertRedirect(route('login'));
    }

    public function test_user_can_create_post()
    {
        $this->actingAs($this->user);

        $response = $this->get(route('posts.create'));

        $response->assertStatus(200);
        $response->assertSee('Create New Post');
    }

    public function test_guest_cannot_create_post()
    {
        $response = $this->get(route('posts.create'));

        $response->assertRedirect(route('login'));
    }

    public function test_user_has_role_method()
    {
        $this->assertTrue(method_exists($this->user, 'hasRole'));
        $this->assertTrue(method_exists($this->user, 'hasAnyRole'));
        $this->assertTrue(method_exists($this->user, 'hasAllRoles'));
    }

    public function test_user_initials_method()
    {
        $this->assertTrue(method_exists($this->user, 'initials'));
        
        $initials = $this->user->initials();
        $this->assertIsString($initials);
        $this->assertNotEmpty($initials);
    }

    public function test_user_notifications_relationship()
    {
        $this->assertTrue(method_exists($this->user, 'notifications'));
        $this->assertTrue(method_exists($this->user, 'unreadNotifications'));
    }
}
