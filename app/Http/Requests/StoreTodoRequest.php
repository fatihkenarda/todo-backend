<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTodoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

        protected function prepareForValidation()
    {
        $originalTitle = $this->title;
        $originalDescription = $this->description;

        $cleanedTitle = preg_replace('/\s+/', ' ', trim(strip_tags($originalTitle)));
        $cleanedDescription = preg_replace('/\s+/', ' ', trim(strip_tags($originalDescription)));

        $this->merge([
            'title' => $cleanedTitle,
            'description' => $cleanedDescription,
        ]);

        // Frontend'den gelen 'categories' verisini 'category_ids' olarak merge et
        if ($this->has('categories')) {
            $this->merge([
                'category_ids' => $this->input('categories'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|min:3|max:100',
            'description' => 'nullable|string|max:500',
            'status' => ['nullable', Rule::in(['pending', 'in_progress', 'completed', 'cancelled'])],
            'priority' => ['nullable', Rule::in(['low', 'medium', 'high'])],
            'due_date' => 'nullable|date|after:today',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }


    
}