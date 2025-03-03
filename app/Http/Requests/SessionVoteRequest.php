<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionVoteRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'session_id' => 'required|exists:toastmasters_sessions,id',
            'voter_id' => 'required|exists:members,id',
            'candidate_id' => 'required|exists:members,id',
            'category' => 'required|string|max:255',
        ];
    }
}
