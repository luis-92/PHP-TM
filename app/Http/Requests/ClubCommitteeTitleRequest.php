<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubCommitteeTitleRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'member_id' => 'required|exists:members,id',
            'club_id' => 'required|exists:clubs,id',
            'committee_title' => 'required|in:president,assembly_officer,secretary,vp_education,vp_membership,treasurer,member',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ];
    }
}
