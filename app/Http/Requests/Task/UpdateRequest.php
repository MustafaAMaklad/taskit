<?php

namespace App\Http\Requests\Task;

use App\Enums\Role;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class UpdateRequest extends FormRequest
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
            'title' => ['sometimes', 'required', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string', 'max:1000'],
            'due_date' => ['sometimes', 'required', 'date', 'after_or_equal:today'],
            'assignee_id' => ['sometimes', 'required', Rule::exists('users', 'id')->where('role', Role::ASSIGNEE)],
            'main_task_id' => ['sometimes', 'nullable', Rule::exists('tasks', 'id')->whereNot('id', $this->route('task')->id)],
        ];
    }

    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($this->circularDependency()) {
                    $validator->errors()->add(
                        'main_task_id',
                        'This task is depending on the given task.'
                    );
                }
            }
        ];
    }

    private function circularDependency(): bool
    {
        if ($this->has('main_task_id')) {
            return $this->route('task')
                ->whereRelation('subTasks', 'id', $this->input('main_task_id'))
                ->exists();
        }

        return false;
    }
}
