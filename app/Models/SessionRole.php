<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionRole extends Model
{
    use CrudTrait, HasFactory;

    protected $fillable = ['session_id', 'member_id', 'role'];

    public function session()
    {
        return $this->belongsTo(ToastmastersSession::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
