<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class ApprenticeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'persona_id' => ['nullable', 'exists:personas,id'],
            'convocatoria_id' => ['nullable', 'exists:convocatorias,id'],
            'inscripcion_id' => ['nullable', 'exists:inscripciones,id'],
            'codigo_matricula' => ['nullable', 'string', 'max:50'],
            'estado_academico' => ['nullable', 'string', 'max:50'],
            'fecha_matricula' => ['nullable', 'date'],
            'fase_formativa' => ['nullable', 'string', 'max:50'],
            'name_apren' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'cell' => ['required', 'string', 'max:255'],
            'program_id' => ['nullable', 'exists:programs,id'],
            'course_id' => ['nullable', 'exists:courses,id'],
            'computer_id' => ['nullable', 'exists:computers,id'],
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