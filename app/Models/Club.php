<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use CrudTrait;
    protected $guarded = [];

    public function members(){ return $this->hasMany(Member::class); }
    public function clubSessions(){ return $this->hasMany(ClubSession::class, 'club_id'); }
    public function executiveCommittees(){ return $this->hasMany(ExecutiveCommittee::class); }
    public function dcpGoalProgress(){ return $this->hasMany(DcpGoalProgress::class); }
}
