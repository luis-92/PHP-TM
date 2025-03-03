<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SessionRole;
use App\Models\ToastmastersSession;
use App\Models\Member;

class SessionRoleSeeder extends Seeder
{
    public function run()
    {
        $session = ToastmastersSession::first();
        $member = Member::first();

        if ($session && $member) {
            SessionRole::create([
                'session_id' => $session->id,
                'role' => 'grammarian',
                'member_id' => $member->id,
            ]);
        }
    }
}
