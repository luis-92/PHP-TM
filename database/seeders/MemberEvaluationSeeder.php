<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MemberEvaluation;
use App\Models\ToastmastersSession;
use App\Models\Member;

class MemberEvaluationSeeder extends Seeder
{
    public function run()
    {
        $session = ToastmastersSession::first();
        $member = Member::first();
        $evaluator = Member::skip(1)->first();

        if ($session && $member && $evaluator) {
            MemberEvaluation::create([
                'session_id' => $session->id,
                'member_id' => $member->id,
                'evaluator_id' => $evaluator->id,
                'evaluation_type' => 'prepared_speech',
                'clarity' => 4,
                'vocal_variety' => 3,
                'eye_contact' => 5,
                'gestures' => 4,
                'audience_awareness' => 5,
                'comfort_level' => 4,
                'interest' => 4,
                'feedback' => 'Gran uso del lenguaje corporal.',
            ]);
        }
    }
}
