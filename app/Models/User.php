<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use CrudTrait, HasFactory, Notifiable;

    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'phone', 'profile_picture', 'role'];

    protected $hidden = ['password', 'remember_token'];

    public function member()
    {
        return $this->hasOne(Member::class);
    }
}
