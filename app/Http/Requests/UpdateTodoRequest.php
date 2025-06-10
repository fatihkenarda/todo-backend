<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        if ($this->has('categories')) {
            $this->merge([
                'category_ids' => $this->input('categories'),
            ]);
        }
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|min:3|max:100',
            'description' => 'nullable|string|max:500',
            'status' => 'sometimes|in:pending,in_progress,completed,cancelled',
            'priority' => 'sometimes|in:low,medium,high',
            'due_date' => 'nullable|date|after:today',
            'category_ids' => 'nullable|array',
            'category_ids.*' => 'exists:categories,id',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Başlık zorunludur.',
            'title.min' => 'Başlık en az 3 karakter olmalıdır.',
            'title.max' => 'Başlık en fazla 100 karakter olabilir.',
            'description.max' => 'Açıklama en fazla 500 karakter olabilir.',
            'status.in' => 'Durum değeri geçersiz.',
            'priority.in' => 'Öncelik değeri geçersiz.',
            'due_date.date' => 'Bitiş tarihi geçerli bir tarih olmalıdır.',
            'due_date.after' => 'Bitiş tarihi bugünden sonra olmalıdır.',
            'category_ids.array' => 'Kategori IDs dizisi olmalıdır.',
            'category_ids.*.exists' => 'Geçersiz kategori IDsi.',
        ];
    }
    
}