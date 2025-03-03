<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SessionRoleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'session_id' => 'required|exists:toastmasters_sessions,id',
            'role' => 'required|in:grammarian,timer,ah-counter,general_evaluator,speech_evaluator',
            'member_id' => 'nullable|exists:members,id',
            'substitute_member_id' => 'nullable|exists:members,id',
            'replacement_member_id' => 'nullable|exists:members,id',
        ];
    }
}
