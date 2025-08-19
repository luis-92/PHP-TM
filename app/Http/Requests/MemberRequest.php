<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Valida la creación/edición de Miembros desde Backpack.
 * OJO: el campo relationship se llama "club", así que validamos "club",
 * no "club_id". Backpack se encarga de mapear a club_id al guardar.
 */
class MemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return backpack_auth()->check();
    }

    public function rules(): array
    {
        return [
            // 👇 Clave: valida "club" (el nombre del campo relationship)
            'club'            => ['required','exists:clubs,id'],

            'name'            => ['required','string','max:100'],
            'first_lastname'  => ['nullable','string','max:100'],
            'second_lastname' => ['nullable','string','max:100'],
            'join_date'       => ['nullable','date'],
            'member_status'   => ['boolean'],
            'member_level'    => ['nullable','string','max:50'],
            'phone_number'    => ['nullable','string','max:30'],
            'gender'          => ['nullable','in:Male,Female,Other'],
            'email'           => ['nullable','email','max:150'],
            'address'         => ['nullable','string','max:255'],
            'city'            => ['nullable','string','max:150'],
            'state'           => ['nullable','string','max:150'],
            'country'         => ['nullable','string','max:150'],
            'emergency_contact_name'  => ['nullable','string','max:150'],
            'emergency_contact_phone' => ['nullable','string','max:50'],
            'professional_goals'      => ['nullable','string','max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            // 👇 Mensajes para "club"
            'club.required' => 'Selecciona un club de la lista.',
            'club.exists'   => 'El club seleccionado no es válido.',
        ];
    }

    public function attributes(): array
    {
        return [
            // 👇 Para que el mensaje diga "club"
            'club' => 'club',
        ];
    }
}
