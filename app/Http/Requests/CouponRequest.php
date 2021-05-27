<?php

namespace App\Http\Requests;

use App\Http\Requests\CoreRequest;

class CouponRequest extends CoreRequest
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
            'title'           => 'required',
            'coupon_code'     => 'required|min:4|max:8',
            'description'     => 'required',
            'discount_value'  => 'required|numeric|between:0,99.99',
            'start_date'      => 'required|date',
            'end_date'        => 'required|date|after_or_equal:start_date'        
        ];
    }
}
