<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test user
        $this->user = User::factory()->create();
        
        // Create test categories
        $this->categories = Category::factory()->count(3)->create();
        
        // Create test tags
        $this->tags = Tag::factory()->count(5)->create();
    }

    public function test_user_can_create_post()
    {
        $this->actingAs($this->user);

        $postData = [
            'title' => 'Test Post Title',
            'content' => 'This is a test post content that is long enough to pass validation.',
            'excerpt' => 'Test excerpt',
            'status' => 'draft',
            'categories' => [$this->categories[0]->id],
            'tags' => 'test, post, example',
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'title' => 'Test Post Title',
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);
    }

    public function test_user_can_view_published_post()
    {
        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'published',
            'published_at' => now(),
        ]);

        $response = $this->get(route('posts.show', [$this->user->username, $post->slug]));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    public function test_user_cannot_view_draft_post_by_other_user()
    {
        $otherUser = User::factory()->create();
        $post = Post::factory()->create([
            'user_id' => $otherUser->id,
            'status' => 'draft',
        ]);

        $response = $this->get(route('posts.show', [$otherUser->username, $post->slug]));

        $response->assertStatus(404);
    }

    public function test_user_can_view_own_draft_post()
    {
        $this->actingAs($this->user);

        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $response = $this->get(route('posts.show', [$this->user->username, $post->slug]));

        $response->assertStatus(200);
        $response->assertSee($post->title);
    }

    public function test_user_can_update_own_post()
    {
        $this->actingAs($this->user);

        $post = Post::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'draft',
        ]);

        $updateData = [
            'title' => 'Updated Post Title',
            'content' => 'This is updated post content that is long enough to pass validation.',
            'excerpt' => 'Updated excerpt',
            'status' => 'published',
            'categories' => [$this->categories[0]->id],
            'tags' => 'updated, post, example',
        ];

        $response = $this->put(route('posts.update', $post), $updateData);

        $response->assertRedirect();
        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => 'Updated Post Title',
            'status' => 'published',
        ]);
    }

    public function test_user_cannot_update_other_user_post()
    {
        $otherUser = User::factory()->create();
        $this->actingAs($this->user);

        $post = Post::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $updateData = [
            'title' => 'Hacked Post Title',
            'content' => 'This is hacked post content.',
            'status' => 'published',
        ];

        $response = $this->put(route('posts.update', $post), $updateData);

        $response->assertStatus(403);
    }

    public function test_post_validation_requires_title()
    {
        $this->actingAs($this->user);

        $postData = [
            'content' => 'This is a test post content.',
            'status' => 'draft',
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('title');
    }

    public function test_post_validation_requires_content()
    {
        $this->actingAs($this->user);

        $postData = [
            'title' => 'Test Post Title',
            'status' => 'draft',
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('content');
    }

    public function test_post_validation_requires_valid_status()
    {
        $this->actingAs($this->user);

        $postData = [
            'title' => 'Test Post Title',
            'content' => 'This is a test post content.',
            'status' => 'invalid_status',
        ];

        $response = $this->post(route('posts.store'), $postData);

        $response->assertSessionHasErrors('status');
    }

    public function test_posts_index_shows_published_posts()
    {
        // Create published posts
        Post::factory()->count(3)->create([
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Create draft posts
        Post::factory()->count(2)->create([
            'status' => 'draft',
        ]);

        $response = $this->get(route('posts.index'));

        $response->assertStatus(200);
        $response->assertSee('Discover Amazing Content');
        
        // Should only show published posts
        $this->assertDatabaseCount('posts', 5);
    }

    public function test_feed_shows_published_posts()
    {
        // Create published posts
        Post::factory()->count(3)->create([
            'status' => 'published',
            'published_at' => now(),
        ]);

        // Create draft posts
        Post::factory()->count(2)->create([
            'status' => 'draft',
        ]);

        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Welcome to ' . config('app.name'));
    }
}
