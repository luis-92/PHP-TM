<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationCriterion extends Model
{
    protected $guarded = [];

    public function type(){ return $this->belongsTo(EvaluationType::class, 'evaluation_type_id'); }

    public function speechDetails(){ return $this->hasMany(SpeechEvaluationDetail::class, 'criterion_id'); }
    public function tableTopicDetails(){ return $this->hasMany(TableTopicEvaluationDetail::class, 'criterion_id'); }
}
