<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\PersonalitySeeder;
use Database\Seeders\ContentSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create a test user for quick login
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // Create additional users with related personalities and contents
        User::factory(10)
            ->create()
            ->each(function ($user) {
                // attach a personality
                \App\Models\Personality::factory()->for($user)->create();
                // attach some contents
                \App\Models\Content::factory()->count(3)->for($user)->create();
            });

        // Run dedicated seeders as well (optional duplicates avoided by above)
        $this->call([
            PersonalitySeeder::class,
            ContentSeeder::class,
        ]);
    }
}
