<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DcpGoal extends Model
{
    protected $guarded = [];

    public function progresses(){ return $this->hasMany(DcpGoalProgress::class, 'dcp_goal_id'); }
}
