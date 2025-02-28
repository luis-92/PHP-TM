<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Speech extends Model
{
    use CrudTrait, HasFactory;

    protected $fillable = ['session_id', 'member_id', 'title', 'content', 'duration', 'speech_type'];

    public function session()
    {
        return $this->belongsTo(ToastmastersSession::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}