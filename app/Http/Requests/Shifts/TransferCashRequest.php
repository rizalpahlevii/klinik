<?php

namespace App\Http\Requests\Shifts;

use Illuminate\Foundation\Http\FormRequest;

class TransferCashRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasAnyRole(['kasir', 'owner']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => ['required', 'integer'],
            'transfer_proof' => ['nullable', 'mimes:pdf,jpg,jpeg,png,svg', 'max:5000'],
        ];
    }

    public function collectInput()
    {
        return [
            'amount' => $this->input('amount'),
            'transfer_proof' => $this->file('transfer_proof'),
        ];
    }
}
