<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use CrudTrait, HasFactory;

    protected $fillable = ['session_id', 'evaluator_id', 'speech_id', 'feedback', 'rating'];

    public function session()
    {
        return $this->belongsTo(ToastmastersSession::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(Member::class, 'evaluator_id');
    }

    public function speech()
    {
        return $this->belongsTo(Speech::class);
    }
}
