<?php

namespace App\Http\Requests\Task;

use App\Enums\TaskStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'filter.status' => ['sometimes', Rule::in(TaskStatus::cases())],
            'filter.from_date' => ['sometimes', 'date'],
            'filter.to_date' => ['sometimes', 'date', 'after_or_equal:filter.from_date'],
        ];
    }
}
