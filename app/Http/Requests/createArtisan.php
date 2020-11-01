<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createArtisan extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'job_id' => 'required',
            'gender' => 'required',
            'image' => 'required',
            'phone' => 'required',
            'phone_operator' => 'required',
            'city' => 'required',
            'address' => 'required',
            'about' => 'required',
            'email' => 'required|email|unique:artisans,email',
            'username' => 'required|unique:artisans,username',
        ];
    }
}
