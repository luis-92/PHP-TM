<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MemberEvaluationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'session_id' => 'required|exists:toastmasters_sessions,id',
            'member_id' => 'required|exists:members,id',
            'evaluator_id' => 'required|exists:members,id',
            'evaluation_type' => 'required|in:prepared_speech,table_topic_speech',
            'clarity' => 'required|integer|min:1|max:5',
            'vocal_variety' => 'required|integer|min:1|max:5',
            'eye_contact' => 'required|integer|min:1|max:5',
            'gestures' => 'required|integer|min:1|max:5',
            'audience_awareness' => 'required|integer|min:1|max:5',
            'comfort_level' => 'required|integer|min:1|max:5',
            'interest' => 'required|integer|min:1|max:5',
            'applied_feedback' => 'nullable|integer|min:1|max:5',
            'well_researched' => 'nullable|integer|min:1|max:5',
            'spontaneity' => 'nullable|integer|min:1|max:5',
            'structure' => 'nullable|integer|min:1|max:5',
            'feedback' => 'nullable|string',
        ];
    }
}
