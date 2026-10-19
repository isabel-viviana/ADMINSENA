<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CourseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_curso' => ['required', 'string', 'max:255'],
            'codigo_curso' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'duracion_horas' => ['nullable', 'integer', 'min:0'],
            'level' => ['nullable', 'in:Tecnico,Tecnologo,Complementario'],
            'area_id' => ['required', 'exists:areas,id'],
            'training_centers_id' => ['nullable', 'exists:training_centers,id'],
            'teachers' => ['nullable', 'array'],
            'teachers.*' => ['integer', 'exists:teachers,id'],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'message' => 'Los datos ingresados son incorrectos.',
            'errors' => $validator->errors(),
        ], 422));
    }
}