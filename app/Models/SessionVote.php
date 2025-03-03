<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class SessionVote extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'session_id',
        'voter_id',
        'candidate_id',
        'category',
    ];

    // Relación con la sesión (Cada voto pertenece a una sesión)
    public function session()
    {
        return $this->belongsTo(ToastmastersSession::class, 'session_id');
    }

    // Relación con el miembro que vota
    public function voter()
    {
        return $this->belongsTo(Member::class, 'voter_id');
    }

    // Relación con el miembro que recibe el voto
    public function candidate()
    {
        return $this->belongsTo(Member::class, 'candidate_id');
    }
}
