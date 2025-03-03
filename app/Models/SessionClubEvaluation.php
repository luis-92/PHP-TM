<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class SessionClubEvaluation extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'session_id',
        'evaluator_id',
        'comments',
        'rating',
    ];

    // Relación con la sesión (Cada evaluación pertenece a una sesión)
    public function session()
    {
        return $this->belongsTo(ToastmastersSession::class, 'session_id');
    }

    // Relación con el miembro que evalúa
    public function evaluator()
    {
        return $this->belongsTo(Member::class, 'evaluator_id');
    }
}
