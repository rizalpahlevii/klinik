<?php

namespace App\Http\Requests;

use App\Models\Services\Parturition;
use Illuminate\Foundation\Http\FormRequest;

use App\Traits\InputRequest;

class CreateParturitionServiceRequest extends FormRequest
{
    use InputRequest;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'phone' => $this->phone_form,
            'service_fee' => $this->fee,
            'discount' => $this->discount,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->setRules(Parturition::$rules);
        return $this->returnRules();
    }

    public function partusData()
    {
        // Collect all data
        $partusData = $this->onlyInRules();
        $partusData = array_merge($partusData, [
            'phone' => $this->input('phone_form'),
            'service_fee' => convertCurrency($this->input('fee')),
            'discount' => convertCurrency($this->input('discount')),
            'total_fee' => convertCurrency($this->input('fee')) - convertCurrency($this->input('discount')),
        ]);

        // Unset unused data
        unset($partusData['fee']);
        unset($partusData['phone_form']);

        return $partusData;
    }
}
