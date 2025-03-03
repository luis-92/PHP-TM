<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SessionVote;
use App\Models\ToastmastersSession;
use App\Models\Member;

class SessionVoteSeeder extends Seeder
{
    public function run()
    {
        $session = ToastmastersSession::first();
        $voter = Member::first();
        $candidate = Member::skip(1)->first(); // Para evitar que vote por sí mismo

        if ($session && $voter && $candidate) {
            SessionVote::create([
                'session_id' => $session->id,
                'voter_id' => $voter->id,
                'candidate_id' => $candidate->id,
                'category' => 'Mejor discurso',
            ]);
        }
    }
}
