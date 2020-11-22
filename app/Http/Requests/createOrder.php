<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createOrder extends FormRequest
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
            'address' => 'required',
            'state' => 'required',
            'city' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'cart' => 'required',
            'delivery_fee' => 'required|integer',
            'delivery_type' => 'required',
            'total_price' => 'required|integer',
            'delivery_time_max' => 'required',
            'delivery_time_min' => 'required',
            'payment_type' => 'required',
            'payment_status' => 'required',
            'order_code' => 'required'
        ];
    }
}
