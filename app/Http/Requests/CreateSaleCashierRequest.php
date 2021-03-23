<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSaleCashierRequest extends FormRequest
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
            'buyer_name' => 'nullable',
            'buyer_name' => 'nullable',
            'tax' => 'nullable|numeric',
            'discount' => 'nullable|numeric',
            'medic_id' => 'nullable',
            'payment_method' => 'required'
        ];
    }
}
