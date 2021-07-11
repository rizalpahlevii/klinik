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
        return $this->user()->hasAnyRole(['cashier', 'owner']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => ['required'],
            'transfer_proof' => ['nullable', 'mimes:pdf,jpg,jpeg,png,svg', 'max:5000'],
        ];
    }

    public function collectInput()
    {
        return [
            'amount' => convertCurrency($this->input('amount')),
            'transfer_proof' => $this->file('transfer_proof'),
        ];
    }
}
