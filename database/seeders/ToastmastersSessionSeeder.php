<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ToastmastersSession;
use App\Models\Club;

class ToastmastersSessionSeeder extends Seeder
{
    public function run()
    {
        $club = Club::first();

        if ($club) {
            ToastmastersSession::create([
                'club_id' => $club->id,
                'session_date' => now(),
                'agenda' => 'Agenda de ejemplo',
                'status' => 'planned',
                'duration' => 90,
            ]);
        }
    }
}
