<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClubSessionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules():array
    {
        return [
        'club'         => ['required','exists:clubs,id'],
        'session_date' => ['required','date'],
        'location'     => ['nullable','string','max:150'],

        'planned_time' => ['nullable','date_format:H:i'],
        'start_time'   => ['nullable','date_format:H:i'],
        'end_time'     => ['nullable','date_format:H:i','after:start_time'],

        'status'       => ['required','in:Scheduled,Held,Canceled'],

        'word_of_day'     => ['nullable','string','max:100'],
        'word_definition' => ['nullable','string','max:2000'],
        'word_example'    => ['nullable','string','max:2000'],

        // cada bloque: hora y minutos positivos
        'welcome_at' => ['nullable','date_format:H:i'], 'welcome_minutes' => ['nullable','integer','min:0','max:240'],
        'opening_at' => ['nullable','date_format:H:i'], 'opening_minutes' => ['nullable','integer','min:0','max:240'],
        'toastmaster_intro_at' => ['nullable','date_format:H:i'], 'toastmaster_intro_minutes' => ['nullable','integer','min:0','max:240'],
        'roles_intro_at' => ['nullable','date_format:H:i'], 'roles_intro_minutes' => ['nullable','integer','min:0','max:240'],
        'table_topics_at' => ['nullable','date_format:H:i'], 'table_topics_minutes' => ['nullable','integer','min:0','max:240'],
        'break_at' => ['nullable','date_format:H:i'], 'break_minutes' => ['nullable','integer','min:0','max:240'],
        'prepared_speeches_at' => ['nullable','date_format:H:i'], 'prepared_speeches_minutes' => ['nullable','integer','min:0','max:240'],
        'general_evaluation_at' => ['nullable','date_format:H:i'], 'general_evaluation_minutes' => ['nullable','integer','min:0','max:240'],
        'toastmaster_closing_at' => ['nullable','date_format:H:i'], 'toastmaster_closing_minutes' => ['nullable','integer','min:0','max:240'],
        'presidency_time_at' => ['nullable','date_format:H:i'], 'presidency_time_minutes' => ['nullable','integer','min:0','max:240'],
        'timer_report_at' => ['nullable','date_format:H:i'], 'timer_report_minutes' => ['nullable','integer','min:0','max:240'],
        'photo_at' => ['nullable','date_format:H:i'], 'photo_minutes' => ['nullable','integer','min:0','max:240'],

        'notes'        => ['nullable','string','max:2000'],
    ];
    }


    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            //
        ];
    }
}
