<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class BangladeshiPostsSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Delete all existing posts
        Post::query()->delete();
        
        // Delete existing test users if they exist
        User::whereIn('username', ['rafiq_dhaka', 'nasrin_bd', 'kamal_ctg', 'sultana_syl', 'jahangir_khulna'])->delete();
        
        // Get or create categories
        $categories = [
            'Technology',
            'Travel',
            'Food',
            'Lifestyle',
            'Business'
        ];
        
        $categoryModels = [];
        foreach ($categories as $categoryName) {
            $categoryModels[] = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );
        }
        
        // Bangladeshi user data
        $users = [
            [
                'name' => 'Rafiqul Islam',
                'username' => 'rafiq_dhaka',
                'email' => 'rafiq@example.com',
            ],
            [
                'name' => 'Nasrin Akter',
                'username' => 'nasrin_bd',
                'email' => 'nasrin@example.com',
            ],
            [
                'name' => 'Kamal Hossain',
                'username' => 'kamal_ctg',
                'email' => 'kamal@example.com',
            ],
            [
                'name' => 'Sultana Begum',
                'username' => 'sultana_syl',
                'email' => 'sultana@example.com',
            ],
            [
                'name' => 'Jahangir Alam',
                'username' => 'jahangir_khulna',
                'email' => 'jahangir@example.com',
            ],
        ];
        
        $password = 'password123';
        $createdUsers = [];
        
        // Create users
        foreach ($users as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'username' => $userData['username'],
                'email' => $userData['email'],
                'email_verified_at' => now(),
                'password' => Hash::make($password),
                'avatar' => 'avatars/profile1.jpg',
                'bio' => 'Content creator from Bangladesh 🇧🇩',
            ]);
            $createdUsers[] = $user;
        }
        
        // Post titles and content related to Bangladesh
        $postTitles = [
            'Exploring the Beauty of Cox\'s Bazar: World\'s Longest Sea Beach',
            'Traditional Bengali Cuisine: A Journey Through Flavors',
            'The Historic Lalbagh Fort: A Glimpse into Mughal Architecture',
            'Dhaka\'s Street Food Scene: Must-Try Delicacies',
            'Sundarbans: The Largest Mangrove Forest in the World',
            'Celebrating Pohela Boishakh: Bengali New Year Traditions',
            'The Art of Jamdani Weaving: Bangladesh\'s Pride',
            'Exploring the Tea Gardens of Sylhet',
            'Chittagong Hill Tracts: Adventure and Natural Beauty',
            'The Royal Bengal Tiger: Guardian of the Sundarbans',
            'Dhaka to Sylhet: A Scenic Train Journey',
            'Traditional Bengali Wedding Customs and Ceremonies',
            'The Historic Sixty Dome Mosque of Bagerhat',
            'Bengali Literature: From Rabindranath to Modern Writers',
            'Street Markets of Old Dhaka: A Shopping Paradise',
            'The Floating Markets of Barisal',
            'Celebrating Victory Day: Bangladesh\'s Independence',
            'The Rickshaw Art of Bangladesh: Colors on Wheels',
            'Exploring Saint Martin\'s Island: Bangladesh\'s Coral Paradise',
            'Bengali Music and Dance: Cultural Heritage',
        ];
        
        $postContents = [
            'Cox\'s Bazar boasts the world\'s longest natural sea beach, stretching over 120 kilometers. This breathtaking destination offers golden sands, stunning sunsets, and warm hospitality. Visitors can enjoy fresh seafood, water sports, and peaceful beach walks.',
            
            'Bengali cuisine is a delightful blend of subtle and fiery flavors. From hilsa fish curry to roshogolla sweets, the culinary tradition reflects centuries of cultural evolution. Rice, fish, and lentils form the foundation of most meals.',
            
            'Lalbagh Fort stands as a testament to Mughal architectural prowess in Bengal. Built in the 17th century, this incomplete fort complex features beautiful gardens, mosques, and the tomb of Pari Bibi, surrounded by fascinating historical tales.',
            
            'Dhaka\'s streets come alive with incredible food offerings. From puchka to chotpoti, jhalmuri to fuchka, the variety is endless. The Old Dhaka area is particularly famous for its traditional biriyani and kebabs.',
            
            'The Sundarbans mangrove forest spans across Bangladesh and India, home to the majestic Royal Bengal Tiger. This UNESCO World Heritage site features unique biodiversity, winding rivers, and an intricate ecosystem supporting thousands of species.',
            
            'Pohela Boishakh marks the Bengali New Year with colorful processions, traditional music, and delicious food. People wear traditional attire, exchange greetings, and celebrate their cultural heritage with joy and enthusiasm.',
            
            'Jamdani is a traditional hand-woven fabric from Bangladesh, recognized by UNESCO. The intricate geometric patterns and delicate craftsmanship make each piece unique. This art form has been passed down through generations.',
            
            'Sylhet\'s rolling tea gardens create a picturesque landscape of endless green. The region produces some of the world\'s finest tea. Visitors can tour plantations, learn about tea processing, and enjoy fresh brews.',
            
            'The Chittagong Hill Tracts offer stunning mountain views, indigenous cultures, and adventurous trekking opportunities. The region is home to several indigenous communities, each with unique traditions and lifestyles.',
            
            'The Royal Bengal Tiger is Bangladesh\'s national animal and a symbol of the country\'s natural heritage. These magnificent creatures roam the Sundarbans, though spotting them requires patience and luck.',
            
            'The train journey from Dhaka to Sylhet is one of Bangladesh\'s most scenic routes. Passengers witness lush green countryside, rivers, and traditional village life through the window.',
            
            'Bengali weddings are elaborate affairs filled with colorful rituals, music, and feasting. From gaye holud to bou bhaat, each ceremony holds special significance and brings families together in celebration.',
            
            'The Sixty Dome Mosque in Bagerhat is a masterpiece of medieval Islamic architecture. Built in the 15th century, this UNESCO World Heritage site showcases the architectural brilliance of the Sultanate period.',
            
            'Bengal has produced numerous literary giants, from Nobel laureate Rabindranath Tagore to contemporary writers. The rich literary tradition continues to inspire and influence writers worldwide.',
            
            'Old Dhaka\'s street markets are a sensory overload of colors, sounds, and smells. From Chawkbazar to New Market, these bustling bazaars offer everything from traditional crafts to modern goods.',
            
            'The floating markets of Barisal showcase a unique way of trade. Vendors sell fresh produce from boats, creating a vibrant and colorful scene on the rivers early in the morning.',
            
            'Victory Day on December 16th commemorates Bangladesh\'s independence in 1971. The day is marked with parades, cultural programs, and remembrance of the martyrs who fought for freedom.',
            
            'Rickshaw art transforms ordinary cycle rickshaws into moving canvases. Bold colors, movie stars, and natural scenery adorn these vehicles, making them a distinctive part of Bangladeshi street culture.',
            
            'Saint Martin\'s Island is Bangladesh\'s only coral island. Crystal clear waters, coconut trees, and pristine beaches make it a perfect getaway. The island is also known for its marine biodiversity.',
            
            'Bengali music and dance forms like Baul, Bhatiali, and classical traditions reflect the region\'s rich cultural heritage. These art forms tell stories of love, spirituality, and rural life.',
        ];
        
        // Create 20 posts
        for ($i = 0; $i < 20; $i++) {
            $user = $createdUsers[$i % 5]; // Distribute posts among 5 users
            
            $post = Post::create([
                'user_id' => $user->id,
                'title' => $postTitles[$i],
                'slug' => Str::slug($postTitles[$i]) . '-' . Str::random(5),
                'excerpt' => Str::limit($postContents[$i], 150),
                'content' => $postContents[$i] . "\n\n" . 
                            "Bangladesh is a land of rivers, vibrant culture, and warm-hearted people. Every corner of this beautiful country has a story to tell, from bustling cities to serene countryside.\n\n" .
                            "The rich heritage, delicious cuisine, and natural beauty make it a fascinating destination for travelers and a proud home for its people. Whether you're exploring historical sites, enjoying local delicacies, or simply soaking in the atmosphere, Bangladesh offers unforgettable experiences.",
                'featured_image' => 'posts/featured1.png',
                'status' => 'published',
                'published_at' => now()->subDays(rand(1, 30)),
                'view_count' => rand(50, 500),
            ]);
            
            // Attach random categories (1-3 categories per post)
            $randomCategories = collect($categoryModels)->random(rand(1, 3));
            $post->categories()->attach($randomCategories->pluck('id'));
        }
        
        // Save credentials to file
        $credentials = "Bangladeshi User Accounts\n";
        $credentials .= "========================\n\n";
        
        foreach ($users as $userData) {
            $credentials .= "Name: {$userData['name']}\n";
            $credentials .= "Username: {$userData['username']}\n";
            $credentials .= "Email: {$userData['email']}\n";
            $credentials .= "Password: {$password}\n";
            $credentials .= "Login URL: " . url('/login') . "\n";
            $credentials .= "------------------------\n\n";
        }
        
        file_put_contents(storage_path('app/bangladeshi_accounts.txt'), $credentials);
        
        $this->command->info('✅ Created 5 Bangladeshi users');
        $this->command->info('✅ Created 20 posts with Bangladeshi content');
        $this->command->info('✅ Credentials saved to: storage/app/bangladeshi_accounts.txt');
    }
}
