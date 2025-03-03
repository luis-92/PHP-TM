<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class ToastmastersSession extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'club_id',
        'session_date',
        'agenda',
        'notes',
        'status',
        'duration',
    ];

    // Relación con Club (Cada sesión pertenece a un club)
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
