<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    protected $guarded = [];

    public function clubSession(){ return $this->belongsTo(ClubSession::class, 'club_session_id'); }
    public function participant(){ return $this->belongsTo(SessionParticipant::class, 'participant_id'); }
}
