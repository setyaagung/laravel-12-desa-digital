<?php

namespace Database\Seeders;

use App\Models\FamilyMember;
use App\Models\User;
use Database\Factories\FamilyMemberFactory;
use Database\Factories\HeadOfFamilyFactory;
use Database\Factories\SocialAssistanceFactory;
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

            FamilyMemberFactory::new()->count(3)->create([
                'head_of_family_id' => $user->headOfFamily->id,
                'user_id' => UserFactory::new()->create()->id
            ]);
        });

        SocialAssistanceFactory::new()->count(50)->create();

        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
    }
}
