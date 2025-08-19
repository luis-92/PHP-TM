<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FunctionaryRole extends Model
{
    protected $guarded = [];

    public function assignments(){ return $this->hasMany(SessionFunctionaryRoleAssignment::class); }
}
