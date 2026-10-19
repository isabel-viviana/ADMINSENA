<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeacherRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'persona_id' => ['nullable', 'exists:personas,id'],
            'name' => ['required', 'string', 'max:255'],
            'codigo_instructor' => ['nullable', 'string', 'max:50'],
            'especialidad' => ['nullable', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'area_id' => ['required', 'exists:areas,id'],
            'training_centers_id' => ['required', 'exists:training_centers,id'],
            'courses' => ['nullable', 'array'],
            'courses.*' => ['integer', 'exists:courses,id'],
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