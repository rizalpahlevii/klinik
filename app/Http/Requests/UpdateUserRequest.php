<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name_form' => 'required|min:3',
            'address_form' => 'required|min:3',
            'role_form' => 'required',
            'phone_form' => 'required|numeric',
            'gender_form' => 'required',
            'start_working_date' => 'required',
            'username_form' => 'required|unique:users,username,' . request()->route('id'),
            'password' => 'nullable|same:password_confirmation|min:6'
        ];
    }
}
