<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClubHistoricalProgress extends Model
{
    //
    protected $fillable = [
        'active_members',
        'new_members'
    ];
}
