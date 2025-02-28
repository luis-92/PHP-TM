<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    use CrudTrait, HasFactory;

    protected $fillable = ['session_id', 'voter_id', 'candidate_id', 'category'];

    public function session()
    {
        return $this->belongsTo(ToastmastersSession::class);
    }

    public function voter()
    {
        return $this->belongsTo(Member::class, 'voter_id');
    }

    public function candidate()
    {
        return $this->belongsTo(Member::class, 'candidate_id');
    }
}
