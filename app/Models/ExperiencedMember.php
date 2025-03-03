<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class ExperiencedMember extends Model
{
    use HasFactory, CrudTrait;

    protected $fillable = [
        'member_id',
        'years_of_experience',
        'speeches_given',
        'awards_won',
        'certifications',
    ];

    // Relación 1 a 1 con Member (Cada miembro experimentado está asociado a un solo miembro)
    public function member()
    {
        return $this->belongsTo(Member::class, 'member_id');
    }
}
