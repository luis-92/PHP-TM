<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionClubEvaluationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'session_id' => 'required|exists:toastmasters_sessions,id',
            'evaluator_id' => 'required|exists:members,id',
            'comments' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
        ];
    }
}
