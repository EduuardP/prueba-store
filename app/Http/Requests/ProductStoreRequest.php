<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'name' => 'required',
            'SKU' => 'required|unique:products,SKU',
            'price' => 'required',
            'iva' => 'required|in:0,10,19',
            'photo' => 'required',
            'description' => 'nullable'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El valor de :attribute es requerido',
            
        ];
    }
}
