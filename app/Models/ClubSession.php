<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ClubSession extends Model
{
    use CrudTrait;

    protected $table = 'club_sessions';
    protected $guarded = [];

    // Casts de fechas/horas
    protected $casts = [
        'session_date' => 'date',
        'planned_time' => 'datetime:H:i',
        'start_time'   => 'datetime:H:i',
        'end_time'     => 'datetime:H:i',

        'welcome_at'             => 'datetime:H:i',
        'opening_at'             => 'datetime:H:i',
        'toastmaster_intro_at'   => 'datetime:H:i',
        'roles_intro_at'         => 'datetime:H:i',
        'table_topics_at'        => 'datetime:H:i',
        'break_at'               => 'datetime:H:i',
        'prepared_speeches_at'   => 'datetime:H:i',
        'general_evaluation_at'  => 'datetime:H:i',
        'toastmaster_closing_at' => 'datetime:H:i',
        'presidency_time_at'     => 'datetime:H:i',
        'timer_report_at'        => 'datetime:H:i',
        'photo_at'               => 'datetime:H:i',
    ];

    // Relaciones
    public function club()               { return $this->belongsTo(Club::class); }
    public function speeches()           { return $this->hasMany(Speech::class, 'club_session_id'); }
    public function tableTopics()        { return $this->hasMany(TableTopic::class, 'club_session_id'); }
    public function visitors()           { return $this->hasMany(Visitor::class, 'club_session_id'); }
    public function roleAssignments()    { return $this->hasMany(SessionFunctionaryRoleAssignment::class, 'club_session_id'); }
    public function attendees()          { return $this->hasMany(Attendance::class, 'club_session_id'); }
    public function participants()       { return $this->hasMany(SessionParticipant::class, 'club_session_id'); }
    public function votes()              { return $this->hasMany(Vote::class, 'club_session_id'); }

    // Scopes útiles
    public function scopeByClub($q, int $clubId)      { return $q->where('club_id', $clubId); }
    public function scopeOnDate($q, $date)            { return $q->whereDate('session_date', $date); }
    public function scopeBetweenDates($q, $from, $to) { return $q->whereBetween('session_date', [$from, $to]); }
    public function scopeUpcoming($q)                 { return $q->whereDate('session_date','>=',now()->toDateString())->orderBy('session_date'); }
    public function scopePast($q)                     { return $q->whereDate('session_date','<', now()->toDateString())->orderByDesc('session_date'); }

    // Accessors
    public function getPresentCountAttribute(): int   { return $this->attendees()->where('status','present')->count(); }
    public function getVisitorsCountAttribute(): int  { return $this->visitors()->count(); }
    public function getDurationMinutesAttribute(): ?int
    {
        if (!$this->start_time || !$this->end_time) return null;
        return $this->end_time->diffInMinutes($this->start_time, false);
    }
}
