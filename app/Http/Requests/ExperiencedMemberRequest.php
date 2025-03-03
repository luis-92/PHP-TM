<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExperiencedMemberRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'member_id' => 'required|exists:members,id|unique:experienced_members,member_id',
            'years_of_experience' => 'required|integer|min:0',
            'speeches_given' => 'required|integer|min:0',
            'awards_won' => 'required|integer|min:0',
            'certifications' => 'nullable|string',
        ];
    }
}
