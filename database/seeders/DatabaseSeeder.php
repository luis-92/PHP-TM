<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            ClubSeeder::class,
            MemberSeeder::class,
            ToastmastersSessionSeeder::class,
            SessionRoleSeeder::class,
            SessionVoteSeeder::class,
            SessionClubEvaluationSeeder::class,
            MemberEvaluationSeeder::class,
            ExperiencedMemberSeeder::class,
            ClubCommitteeTitleSeeder::class,
        ]);
    }
}
