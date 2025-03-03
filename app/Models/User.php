<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class User extends Authenticatable
{
    use HasFactory, Notifiable, CrudTrait;

    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'profile_picture',
        'role'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    // Relación con Members (Si aplica)
    public function member()
    {
        return $this->hasOne(Member::class);
    }

    // Función para obtener nombre completo
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
