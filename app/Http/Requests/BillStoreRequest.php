<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BillStoreRequest extends FormRequest
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
            'client' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'products' => 'required|array'
        ];
    }

    public function messages()
    {
        return [
            'required' => 'El valor de :attribute es requerido',
            'email' => 'debe agregar un correo electronico valido'
            
        ];
    }
}
