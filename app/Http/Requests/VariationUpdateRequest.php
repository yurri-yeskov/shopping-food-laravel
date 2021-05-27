<?php

namespace App\Http\Requests;

use App\Http\Requests\CoreRequest;

class VariationUpdateRequest extends CoreRequest
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
            'unit_id'           => 'required',
            'weight'            => 'required',
            'price'             => 'required|numeric|min:0|not_in:0',
            'special_price'     => 'nullable|numeric|min:0|not_in:0|lt:price'
        ];
    
        return $rules;
    }
}
