<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class DcpGoalsSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();
        $goals = [];
        $goals[] = ['code' => 'ED1', 'name' => 'Four Level 1 awards', 'description' => 'Education: 4 members complete Level 1', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'ED2', 'name' => 'Two Level 2 awards', 'description' => 'Education: 2 members complete Level 2', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'ED3', 'name' => 'Two more Level 2 awards', 'description' => 'Education: 2 additional Level 2 awards', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'ED4', 'name' => 'One Level 3 award', 'description' => 'Education: 1 member completes Level 3', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'ED5', 'name' => 'One Level 4, 5 or DTM award', 'description' => 'Education: Advanced awards', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'MEM1', 'name' => 'Add 4 new members', 'description' => 'Membership building', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'MEM2', 'name' => 'Add 8 new members (total)', 'description' => 'Membership building', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'TRN1', 'name' => 'Officers trained (June–Aug)', 'description' => 'Club officer training round 1', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'TRN2', 'name' => 'Officers trained (Dec–Feb)', 'description' => 'Club officer training round 2', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'ADM1', 'name' => 'On-time dues (Oct–Mar)', 'description' => 'Administration: renewals on time', 'created_at' => $now, 'updated_at' => $now];
        $goals[] = ['code' => 'ADM2', 'name' => 'On-time officer list', 'description' => 'Administration: officer list on time', 'created_at' => $now, 'updated_at' => $now];
        DB::table('dcp_goals')->insert($goals);
    }
}
