<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationType extends Model
{
    protected $guarded = [];

    public function criteria(){ return $this->hasMany(EvaluationCriterion::class, 'evaluation_type_id'); }

    public function speechEvaluations(){ return $this->hasMany(SpeechEvaluation::class, 'evaluation_type_id'); }
    public function tableTopicEvaluations(){ return $this->hasMany(TableTopicEvaluation::class, 'evaluation_type_id'); }
}
