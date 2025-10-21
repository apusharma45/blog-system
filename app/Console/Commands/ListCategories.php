<?php

namespace App\Console\Commands;

use App\Models\Category;
use Illuminate\Console\Command;

class ListCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'categories:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List all categories in the database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $categories = Category::all(['name', 'slug', 'description']);
        
        $this->info("Total Categories: " . $categories->count());
        $this->newLine();
        
        foreach ($categories as $category) {
            $this->line("• {$category->name} ({$category->slug})");
            if ($category->description) {
                $this->line("  {$category->description}");
            }
            $this->newLine();
        }
    }
}