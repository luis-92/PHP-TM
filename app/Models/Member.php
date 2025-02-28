<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use CrudTrait, HasFactory;

    protected $fillable = ['user_id', 'club_id', 'role', 'join_date'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function speeches()
    {
        return $this->hasMany(Speech::class);
    }

    public function sessionRoles()
    {
        return $this->hasMany(SessionRole::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class, 'evaluator_id');
    }
}
