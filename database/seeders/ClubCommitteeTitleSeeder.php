<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ClubCommitteeTitle;
use App\Models\Member;
use App\Models\Club;

class ClubCommitteeTitleSeeder extends Seeder
{
    public function run()
    {
        $member = Member::first();
        $club = Club::first();

        if ($member && $club) {
            ClubCommitteeTitle::create([
                'member_id' => $member->id,
                'club_id' => $club->id,
                'committee_title' => 'president',
            ]);
        }
    }
}
