<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DcpGoalProgress extends Model
{
    protected $guarded = [];

    public function club(){ return $this->belongsTo(Club::class); }
    public function goal(){ return $this->belongsTo(DcpGoal::class, 'dcp_goal_id'); }
}
