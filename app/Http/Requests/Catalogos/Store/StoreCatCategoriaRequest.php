<?php

namespace App\Http\Requests\Catalogos\Store;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class StoreCatCategoriaRequest extends FormRequest
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
            'nombre_categoria' => ['required', 'max:50'],
            'habilitado' => ['required', 'boolean']

        ];
    }

    public function messages(): array
    {
        return [
            'nombre_categoria.required' => 'El nombre de catedoria es obligatorio',
            'nombre_categoria.max' => 'El nombre no puede tener más de 50 caracteres',
            'habilitado.required' => 'El campo habilitado es obligatorio',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(
            [
                'success' => false,
                'message' => 'Error al guardar los datos',
                'data' => $validator->errors()->all()
            ], 422 // Cambié el código a 422 (Unprocessable Entity) ya que es un error de validación
        ));
    }
}
