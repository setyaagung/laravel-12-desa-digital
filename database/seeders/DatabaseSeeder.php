<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\HeadOfFamily;
use App\Models\SocialAssistance;
use App\Models\SocialAssistanceRecipient;
use App\Models\User;
use Database\Factories\EventFactory;
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


        //social assistance
        SocialAssistanceFactory::new()->count(50)->create();

        //social assistance recipient
        $socialAssistances = SocialAssistance::all();
        $headOfFamilies = HeadOfFamily::all();

        foreach ($socialAssistances as $socialAssistance) {
            foreach ($headOfFamilies as $headOfFamily) {
                SocialAssistanceRecipient::factory()->create([
                    'social_assistance_id' => $socialAssistance->id,
                    'head_of_family_id' => $headOfFamily->id
                ]);
            }
        }

        //event
        EventFactory::new()->count(50)->create();
        //event participant
        $events = Event::all();

        foreach ($events as $event) {
            foreach ($headOfFamilies as $headOfFamily) {
                EventParticipant::factory()->create([
                    'head_of_family_id' => $headOfFamily->id,
                    'event_id' => $event->id
                ]);
            }
        }
        //User::factory()->create([
        //    'name' => 'Test User',
        //    'email' => 'test@example.com',
        //]);
    }
}
