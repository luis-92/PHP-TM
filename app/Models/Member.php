<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Member extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'user_id',
        'club_id',
        'join_date',
    ];

    // Relación con User (Cada miembro pertenece a un usuario)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con Club (Cada miembro pertenece a un club)
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}
