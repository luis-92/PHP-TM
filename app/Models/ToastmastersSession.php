<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToastmastersSession extends Model
{
    use CrudTrait, HasFactory;

    protected $fillable = ['club_id', 'session_date', 'agenda', 'notes', 'status', 'duration'];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }

    public function roles()
    {
        return $this->hasMany(SessionRole::class);
    }

    public function votes()
    {
        return $this->hasMany(Vote::class);
    }
}
