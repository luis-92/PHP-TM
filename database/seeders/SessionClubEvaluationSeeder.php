<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SessionClubEvaluation;
use App\Models\ToastmastersSession;
use App\Models\Member;

class SessionClubEvaluationSeeder extends Seeder
{
    public function run()
    {
        $session = ToastmastersSession::first();
        $evaluator = Member::first();

        if ($session && $evaluator) {
            SessionClubEvaluation::create([
                'session_id' => $session->id,
                'evaluator_id' => $evaluator->id,
                'comments' => 'Muy buena sesión, gran participación.',
                'rating' => 5,
            ]);
        }
    }
}
