<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create sample users
        User::create([
            'name' => 'John Doe',
            'username' => 'johndoe',
            'email' => 'john@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Software developer and tech enthusiast.',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Jane Smith',
            'username' => 'janesmith',
            'email' => 'jane@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Content writer and blogger.',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Bob Wilson',
            'username' => 'bobwilson',
            'email' => 'bob@example.com',
            'password' => Hash::make('password'),
            'bio' => 'Designer and creative thinker.',
            'email_verified_at' => now(),
        ]);

        // Create more users using factory
        User::factory(7)->create();
    }
}
