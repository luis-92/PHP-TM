<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class Club extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'name',
        'description',
        'location',
        'meeting_schedule',
    ];

    // Relación con Members (Un club tiene muchos miembros)
    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
