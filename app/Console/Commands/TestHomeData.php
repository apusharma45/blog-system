<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class TestHomeData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:home-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test the data that would be passed to the home view';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing HomeController data...');
        
        // Test categories
        $categories = Category::orderBy('name')->get();
        $this->info("Categories count: " . $categories->count());
        
        if ($categories->count() > 0) {
            $this->info("First 3 categories:");
            foreach ($categories->take(3) as $cat) {
                $this->line("- {$cat->name} ({$cat->slug})");
            }
        }
        
        // Test tags
        $tags = Tag::orderBy('name')->take(20)->get();
        $this->info("Tags count: " . $tags->count());
        
        // Test posts
        $posts = Post::with(['user', 'categories', 'tags'])
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(10);
        $this->info("Posts count: " . $posts->count());
        
        // Test featured posts
        $featuredPosts = Post::featured()
            ->with(['user', 'categories', 'tags'])
            ->take(3)
            ->get();
        $this->info("Featured posts count: " . $featuredPosts->count());
        
        $this->info('All data looks good!');
    }
}