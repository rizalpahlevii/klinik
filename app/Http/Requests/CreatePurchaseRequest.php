<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreatePurchaseRequest extends FormRequest
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
            'receipt_code' => 'required|min:3|unique:purchases,receipt_code',
            'supplier_id' => 'required',
            'salesman_id' => 'required',
            'date' => 'required',
            'dicount' => 'nullable',
            'tax' => 'nullable',
            'file' => 'nullable|mimes:jpg,png,jpeg|max:10000',
        ];
    }
}
