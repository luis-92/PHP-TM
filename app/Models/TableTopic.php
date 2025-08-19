<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class TableTopic extends Model
{
    use CrudTrait;
    protected $guarded = [];

    public function clubSession(){ return $this->belongsTo(ClubSession::class, 'club_session_id'); }
    public function member(){ return $this->belongsTo(Member::class); }

    public function evaluations(){ return $this->hasMany(TableTopicEvaluation::class); }
}
