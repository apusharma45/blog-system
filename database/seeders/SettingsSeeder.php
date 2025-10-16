<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = [
            ['key' => 'site.name', 'value' => ['value' => 'BlogSuite']],
            ['key' => 'site.tagline', 'value' => ['value' => 'Insights, stories, and code']],
            ['key' => 'site.logo', 'value' => null],
            ['key' => 'site.theme', 'value' => ['value' => 'dark']],
        ];

        foreach ($defaults as $item) {
            Setting::updateOrCreate(
                ['key' => $item['key']],
                ['value' => $item['value']]
            );
        }
    }
}
