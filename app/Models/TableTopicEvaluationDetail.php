<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TableTopicEvaluationDetail extends Model
{
    protected $guarded = [];

    public function evaluation(){ return $this->belongsTo(TableTopicEvaluation::class, 'table_topic_evaluation_id'); }
    public function criterion(){ return $this->belongsTo(EvaluationCriterion::class, 'criterion_id'); }
}
