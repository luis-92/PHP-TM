<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class SessionRole extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'session_id',
        'role',
        'member_id',
        'substitute_member_id',
        'replacement_member_id'
    ];

    // Relación con la sesión (Cada rol pertenece a una sesión)
    public function session()
    {
        return $this->belongsTo(ToastmastersSession::class, 'session_id');
    }

    // Relación con el miembro principal que tiene el rol
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    // Relación con el miembro sustituto predefinido
    public function substituteMember()
    {
        return $this->belongsTo(Member::class, 'substitute_member_id');
    }

    // Relación con el miembro que realmente tomó el rol
    public function replacementMember()
    {
        return $this->belongsTo(Member::class, 'replacement_member_id');
    }
}
