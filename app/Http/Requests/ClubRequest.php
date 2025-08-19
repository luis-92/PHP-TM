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
        $id = $this->route('club'); // para el unique en update (Backpack usa {club})
        return [
            'name' => 'required|string|max:255|unique:clubs,name,' . ($id ?? 'NULL'),
            'club_number' => 'nullable|integer|unique:clubs,club_number,' . ($id ?? 'NULL'),
            'area' => 'nullable|string|max:50',
            'division' => 'nullable|string|max:50',
            'district' => 'nullable|integer',
            'founding_date' => 'nullable|date',
            'location' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:100',
            'meeting_days' => 'nullable|string|max:100',
            'schedule' => 'nullable|string|max:100',
            'modality_meeting' => 'nullable|string|max:100',
            'zoom_link' => 'nullable|url|max:255',
        ];
    }
}
