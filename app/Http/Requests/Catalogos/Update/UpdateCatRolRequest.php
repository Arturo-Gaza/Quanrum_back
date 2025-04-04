<?php

namespace App\Http\Requests\Catalogos\Update;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class UpdateCatRolRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nombre_rol'=>['required', 'max:60'],
            'habilitado'=>['required']
        ];
    }

    //Mensajes que se mostrar si no se cumple con la regla
    public function messages(): array
    {
        return [
            'nombre_rol.required' => 'El nombre de rol es obligatorio',
            'nombre_rol.max' => 'El número maximo es de 60 caracteres',
            'habilitado.required' => 'El campo habilitado es obligatorio',
        ];
    }

    public function failedValidation(Validator $validator) {

        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'message'=> 'Error al guardar los datos',
                'data' => $validator->errors()->all()
            ],500
        ));
    }
}
