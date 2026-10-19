<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CourseFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_curso' => ['required', 'string', 'max:255'],
            'day' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'level' => ['required', 'in:Tecnico,Tecnologo,Complementario'],
            'duration' => ['required', 'integer', 'min:1', 'max:65535'],
            'area_id' => ['required', 'exists:areas,id'],
            'training_centers_id' => ['required', 'exists:training_centers,id'],
            'teachers' => ['nullable', 'array'],
            'teachers.*' => ['integer', 'exists:teachers,id'],
        ];
    }
}