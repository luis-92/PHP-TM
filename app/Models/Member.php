<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use CrudTrait;
    protected $guarded = [];

    public function club(){ return $this->belongsTo(Club::class); }
    #public function club(){ return $this->belongsTo(\App\Models\Club::class);}

    public function speeches(){ return $this->hasMany(Speech::class); }
    public function tableTopics(){ return $this->hasMany(TableTopic::class); }

    public function speechEvaluationsGiven(){ return $this->hasMany(SpeechEvaluation::class, 'evaluator_id'); }
    public function speechEvaluationsReceived(){ return $this->hasMany(SpeechEvaluation::class, 'evaluatee_member_id'); }

    public function tableTopicEvaluationsGiven(){ return $this->hasMany(TableTopicEvaluation::class, 'evaluator_id'); }
    public function tableTopicEvaluationsReceived(){ return $this->hasMany(TableTopicEvaluation::class, 'evaluatee_member_id'); }

    public function roleAssignments(){ return $this->hasMany(SessionFunctionaryRoleAssignment::class); }

    public function attendance(){ return $this->hasMany(Attendance::class); }

    public function sessionParticipants(){ return $this->hasMany(SessionParticipant::class); }
}
