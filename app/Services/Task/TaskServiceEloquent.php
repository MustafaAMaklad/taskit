<?php

namespace App\Services\Task;

use App\Enums\TaskStatus;
use App\Models\Task;
use Illuminate\Validation\ValidationException;

class TaskServiceEloquent implements TaskService
{
    public function create(array $data): Task
    {
        return Task::create($data);
    }

    public function update(Task $task, array $data): Task
    {
        return tap($task, fn($task) => $this->performUpdate($task, $data));
    }

    public function updateStatus(Task $task, array $data): Task
    {
        return tap($task, fn($task) => $this->performUpdate($task, $data));
    }

    public function delete(Task $task): bool
    {
        return $task->delete();
    }

    public function cantBeCompleted(Task $task): bool
    {
        return $task->subTasks()->incomplete()->exists();
    }

    private function performUpdate(Task $task, array $data): Task
    {
        if (
            isset($data['status'])
            && $data['status'] === TaskStatus::COMPLETED->value
            && $this->cantBeCompleted($task)
        ) {
            throw ValidationException::withMessages([
                'status' => __('error.task.cant_be_completed'),
            ]);
        }

        $task->update($data);

        return $task;
    }
}
