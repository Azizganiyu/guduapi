<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class createProduct extends FormRequest
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
            'name' => 'required|unique:products,name',
            'description' => 'required',
            'category_id' => 'required|integer|exists:categories,id',
            'condition_id' => 'required|integer|exists:conditions,id',
            'part_id' => 'required|integer|exists:parts,id',
            'discount' => 'required|integer',
            'quantity' => 'required|integer',
            'price' => 'required|integer',
            'images' => 'required',
            'friendly_url' => 'required|unique:products,friendly_url',
        ];
    }
}
