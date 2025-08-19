<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpeechEvaluationDetail extends Model
{
    protected $guarded = [];

    public function evaluation(){ return $this->belongsTo(SpeechEvaluation::class, 'speech_evaluation_id'); }
    public function criterion(){ return $this->belongsTo(EvaluationCriterion::class, 'criterion_id'); }
}
