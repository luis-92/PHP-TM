<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class MemberEvaluation extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'session_id',
        'member_id',
        'evaluator_id',
        'evaluation_type',
        'clarity',
        'vocal_variety',
        'eye_contact',
        'gestures',
        'audience_awareness',
        'comfort_level',
        'interest',
        'applied_feedback',
        'well_researched',
        'spontaneity',
        'structure',
        'feedback',
    ];

    // Relación con la sesión (Cada evaluación pertenece a una sesión)
    public function session()
    {
        return $this->belongsTo(ToastmastersSession::class, 'session_id');
    }

    // Relación con el miembro evaluado
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }

    // Relación con el evaluador
    public function evaluator()
    {
        return $this->belongsTo(Member::class, 'evaluator_id');
    }
}
