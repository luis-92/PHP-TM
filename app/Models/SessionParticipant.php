<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionParticipant extends Model
{
    protected $guarded = [];

    public function clubSession(){ return $this->belongsTo(ClubSession::class, 'club_session_id'); }
    public function member(){ return $this->belongsTo(Member::class); }
    public function visitor(){ return $this->belongsTo(Visitor::class); }

    public function votes(){ return $this->hasMany(Vote::class, 'participant_id'); }
}
