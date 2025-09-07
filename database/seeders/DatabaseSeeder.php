<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\HeadOfFamilyFactory;
use Database\Factories\UserFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserFactory::new()->count(50)->create()->each(function ($user) {
            HeadOfFamilyFactory::new()->count(1)->create([
                'user_id' => $user->id
            ]);
        });

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
    }
}
