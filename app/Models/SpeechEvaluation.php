<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpeechEvaluation extends Model
{
    protected $guarded = [];

    public function clubSession(){ return $this->belongsTo(ClubSession::class, 'club_session_id'); }
    public function speech(){ return $this->belongsTo(Speech::class); }

    public function evaluator(){ return $this->belongsTo(Member::class, 'evaluator_id'); }
    public function evaluatee(){ return $this->belongsTo(Member::class, 'evaluatee_member_id'); }

    public function type(){ return $this->belongsTo(EvaluationType::class, 'evaluation_type_id'); }

    public function details(){ return $this->hasMany(SpeechEvaluationDetail::class); }
}
