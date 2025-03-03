<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class ClubCommitteeTitle extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'member_id',
        'club_id',
        'committee_title',
        'start_date',
        'end_date',
    ];

    // Relación con Member (Un título pertenece a un miembro)
    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    // Relación con Club (Un título pertenece a un club)
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
