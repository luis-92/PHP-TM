<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ToastmastersSessionRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'club_id' => 'required|exists:clubs,id',
            'session_date' => 'required|date',
            'agenda' => 'required|string',
            'notes' => 'nullable|string',
            'status' => 'required|in:planned,in_progress,completed',
            'duration' => 'nullable|integer|min:1',
        ];
    }
}
