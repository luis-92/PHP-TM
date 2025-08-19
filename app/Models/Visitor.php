<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use CrudTrait;
    protected $guarded = [];

    public function clubSession(){ return $this->belongsTo(ClubSession::class, 'club_session_id'); }
    public function sessionParticipants(){ return $this->hasMany(SessionParticipant::class); }
}
