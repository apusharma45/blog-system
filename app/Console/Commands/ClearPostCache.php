<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearPostCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:clear-posts';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all post-related cache';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing post-related cache...');
        
        try {
            // Clear specific cache keys
            Cache::forget('feed_posts');
            Cache::forget('feed_categories');
            Cache::forget('feed_tags');
            
            // Clear posts index cache (pattern matching) - only if Redis is available
            if (config('cache.default') === 'redis' && Cache::getStore() instanceof \Illuminate\Cache\RedisStore) {
                $keys = Cache::getRedis()->keys('posts_index_*');
                if ($keys) {
                    Cache::getRedis()->del($keys);
                }
            } else {
                // For file/database cache, clear all cache
                $this->info('Using file/database cache - clearing all cache...');
                Cache::flush();
            }
            
            $this->info('Post cache cleared successfully!');
            
        } catch (\Exception $e) {
            $this->error('Error clearing cache: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}
