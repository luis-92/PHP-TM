<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|unique:clubs,name|max:255',
            'description' => 'nullable|string',
            'location' => 'nullable|string|max:255',
            'meeting_schedule' => 'nullable|string|max:255',
        ];
    }
}
