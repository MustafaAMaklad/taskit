<?php

namespace App\Http\Requests\Task;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class StoreRequest extends FormRequest
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
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'due_date' => ['required', 'date', 'after_or_equal:today'],
            'assignee_id' => ['required', Rule::exists('users', 'id')->where('role', 'assignee')],
            'main_task_id' => ['nullable', 'exists:tasks,id'],
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'due_date' => Carbon::parse($this->due_date)->endOfDay()->toDateTimeString(),
        ]);
    }
}
