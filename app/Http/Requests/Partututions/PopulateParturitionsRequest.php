<?php

namespace App\Http\Requests\Partututions;

use Illuminate\Foundation\Http\FormRequest;

use App\Traits\PopulateRequestOptions;

class PopulateParturitionsRequest extends FormRequest
{
    use PopulateRequestOptions;

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
            //
        ];
    }

    public function options()
    {
        /*$this->addWhere([
            'column' => 'discount',
            'operator' => '>=',
            'value' => 10000,
        ]);

        $this->addWith('patient');*/

        // Parturition::with(['patient'])->where('discount', '>=', 10000)->get();

        return $this->collectOptions();
    }
}
