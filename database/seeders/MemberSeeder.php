<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Member;
use App\Models\Club;
use App\Models\User;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $user = User::first(); // Asegurar que haya un usuario
        $club = Club::first(); // Asegurar que haya un club

        if ($user && $club) {
            Member::create([
                'user_id' => $user->id, // Relación con Users
                'club_id' => $club->id,
                'join_date' => now(),
            ]);
        }
    }
}
