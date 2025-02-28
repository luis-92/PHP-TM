<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use CrudTrait, HasFactory;

    protected $fillable = ['name', 'description', 'location', 'meeting_schedule'];

    public function members()
    {
        return $this->hasMany(Member::class);
    }
}
