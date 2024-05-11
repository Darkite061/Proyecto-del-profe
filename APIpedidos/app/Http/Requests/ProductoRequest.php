<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class ProductoRequest extends FormRequest
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
            'nombre' => ['required','min:2','max:100'],
            'supplier_id'=>['required','numeric','exists:suppliers,id'],
           // 'picture'=>['required','image','mimes:jpg,bmp,png','size:1024'],
        ];
    }

    public function messages()
    {
        return [
            'nombre.required' => 'Error, el nombre no puede estar vacio',
            'nombre.min'=> 'Error, el nombre debe tener como mínimo 2 letras',
            'nombre.max'=>'Error, el nombre debe tener como máximo 100 letras',
            'supplier_id.required'=>'Error, el id del proveedpor no puede estar vacio',
            'supplier_id.numeric'=>'Error, el id del proveedor debe de ser un numero',
            'supplier_id.exists'=>'Error, el id del proveedor debe de existir en la tabla',
        ];

    }

    protected function failedValidation(Validator $validator){
        
        $response = response()->json([
            'success' => false,
            'message' => 'Ocurrio algún error',
            'errors' => $validator->errors()
        ]);
        throw (new ValidationException($validator, $response));
          
    }
}
