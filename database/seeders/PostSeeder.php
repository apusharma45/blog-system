<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();
        $categories = Category::all();

        if ($users->isEmpty() || $categories->isEmpty()) {
            $this->command->warn('Please run UserSeeder and CategorySeeder first!');
            return;
        }

        $samplePosts = [
            [
                'title' => 'Getting Started with Laravel 11',
                'content' => '<p>Laravel 11 brings exciting new features and improvements to the PHP framework. In this post, we\'ll explore the key updates and how they can enhance your development workflow.</p><p>From improved performance to new developer tools, Laravel continues to be the framework of choice for modern web applications.</p>',
            ],
            [
                'title' => 'The Future of Web Development',
                'content' => '<p>Web development is evolving rapidly with new technologies and frameworks emerging every day. Let\'s discuss what the future holds for developers and how we can prepare for upcoming changes.</p><p>From AI integration to advanced frontend frameworks, the landscape is changing faster than ever.</p>',
            ],
            [
                'title' => '10 Tips for Better Code Quality',
                'content' => '<p>Writing clean, maintainable code is crucial for long-term project success. Here are 10 practical tips to improve your code quality and make your applications more robust.</p><p>These best practices will help you become a better developer and create more sustainable software.</p>',
            ],
            [
                'title' => 'Understanding Database Design Patterns',
                'content' => '<p>Database design is a fundamental skill for backend developers. In this comprehensive guide, we\'ll explore common design patterns and when to use them.</p><p>Learn about normalization, indexing, and performance optimization techniques.</p>',
            ],
            [
                'title' => 'Building RESTful APIs with Laravel',
                'content' => '<p>RESTful APIs are the backbone of modern web applications. This tutorial will walk you through creating a robust API using Laravel\'s powerful features.</p><p>We\'ll cover authentication, rate limiting, and best practices for API design.</p>',
            ],
        ];

        foreach ($samplePosts as $postData) {
            $user = $users->random();
            
            $post = Post::create([
                'user_id' => $user->id,
                'title' => $postData['title'],
                'slug' => Str::slug($postData['title']),
                'content' => $postData['content'],
                'excerpt' => Str::limit(strip_tags($postData['content']), 150),
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
                'view_count' => rand(10, 500),
            ]);

            // Attach random categories
            $post->categories()->attach($categories->random(rand(1, 2))->pluck('id'));
        }

        // Create additional random posts
        Post::factory(15)->create();
    }
}
