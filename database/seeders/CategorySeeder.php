<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            // Technology & Programming
            [
                'name' => 'Web Development',
                'slug' => 'web-development',
                'description' => 'Frontend, backend, and full-stack development topics including HTML, CSS, JavaScript, PHP, Python, and more.'
            ],
            [
                'name' => 'Mobile Development',
                'slug' => 'mobile-development',
                'description' => 'iOS, Android, and cross-platform mobile app development using various frameworks and technologies.'
            ],
            [
                'name' => 'DevOps',
                'slug' => 'devops',
                'description' => 'Deployment, CI/CD, infrastructure management, and automation tools for modern software development.'
            ],
            [
                'name' => 'Data Science',
                'slug' => 'data-science',
                'description' => 'Machine learning, artificial intelligence, data analysis, and statistical modeling techniques.'
            ],
            [
                'name' => 'Cybersecurity',
                'slug' => 'cybersecurity',
                'description' => 'Security best practices, threat prevention, and protecting digital assets and information.'
            ],

            // Lifestyle & Personal
            [
                'name' => 'Personal Growth',
                'slug' => 'personal-growth',
                'description' => 'Self-improvement, life lessons, and strategies for personal development and success.'
            ],
            [
                'name' => 'Health & Wellness',
                'slug' => 'health-wellness',
                'description' => 'Fitness, nutrition, mental health, and overall well-being tips and advice.'
            ],
            [
                'name' => 'Travel',
                'slug' => 'travel',
                'description' => 'Travel experiences, destination guides, tips, and adventures from around the world.'
            ],
            [
                'name' => 'Food & Cooking',
                'slug' => 'food-cooking',
                'description' => 'Recipes, restaurant reviews, culinary adventures, and cooking techniques.'
            ],
            [
                'name' => 'Fashion & Style',
                'slug' => 'fashion-style',
                'description' => 'Fashion trends, styling tips, outfit ideas, and personal style inspiration.'
            ],

            // Business & Finance
            [
                'name' => 'Entrepreneurship',
                'slug' => 'entrepreneurship',
                'description' => 'Starting and running businesses, startup advice, and entrepreneurial insights.'
            ],
            [
                'name' => 'Finance',
                'slug' => 'finance',
                'description' => 'Personal finance, investing, money management, and financial planning strategies.'
            ],
            [
                'name' => 'Marketing',
                'slug' => 'marketing',
                'description' => 'Digital marketing, SEO, social media, brand building, and customer acquisition.'
            ],
            [
                'name' => 'Productivity',
                'slug' => 'productivity',
                'description' => 'Time management, efficiency tips, workflow optimization, and getting things done.'
            ],
            [
                'name' => 'Career',
                'slug' => 'career',
                'description' => 'Professional development, job search advice, career growth, and workplace insights.'
            ],

            // Creative & Arts
            [
                'name' => 'Photography',
                'slug' => 'photography',
                'description' => 'Photography techniques, equipment reviews, composition tips, and visual storytelling.'
            ],
            [
                'name' => 'Design',
                'slug' => 'design',
                'description' => 'Graphic design, UI/UX, web design, and creative processes and methodologies.'
            ],
            [
                'name' => 'Writing',
                'slug' => 'writing',
                'description' => 'Creative writing, blogging tips, storytelling, and content creation strategies.'
            ],
            [
                'name' => 'Music',
                'slug' => 'music',
                'description' => 'Music reviews, tutorials, industry insights, and musical inspiration.'
            ],
            [
                'name' => 'Art',
                'slug' => 'art',
                'description' => 'Visual arts, crafts, creative inspiration, and artistic techniques and processes.'
            ],

            // Education & Learning
            [
                'name' => 'Tutorials',
                'slug' => 'tutorials',
                'description' => 'Step-by-step guides, how-to articles, and educational content for learning new skills.'
            ],
            [
                'name' => 'Reviews',
                'slug' => 'reviews',
                'description' => 'Product reviews, service evaluations, and honest recommendations and opinions.'
            ],
            [
                'name' => 'News & Updates',
                'slug' => 'news-updates',
                'description' => 'Industry news, current events, and updates on relevant topics and trends.'
            ],
            [
                'name' => 'Opinions',
                'slug' => 'opinions',
                'description' => 'Editorial content, personal viewpoints, and thought-provoking commentary.'
            ],
            [
                'name' => 'Case Studies',
                'slug' => 'case-studies',
                'description' => 'Real-world examples, project analysis, and detailed studies of successful implementations.'
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
