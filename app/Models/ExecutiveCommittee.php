<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExecutiveCommittee extends Model
{
    protected $guarded = [];

    public function club(){ return $this->belongsTo(Club::class); }
    public function member(){ return $this->belongsTo(Member::class); }
}
