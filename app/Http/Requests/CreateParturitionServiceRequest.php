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




    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return Parturition::$rules;
    }
}
