<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExperiencedMember;
use App\Models\Member;

class ExperiencedMemberSeeder extends Seeder
{
    public function run()
    {
        $member = Member::first();

        if ($member) {
            ExperiencedMember::create([
                'member_id' => $member->id,
                'years_of_experience' => 3,
                'speeches_given' => 15,
                'awards_won' => 2,
                'certifications' => 'Toastmasters Gold',
            ]);
        }
    }
}
