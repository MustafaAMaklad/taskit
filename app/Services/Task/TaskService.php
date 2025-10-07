<?php

namespace App\Services\Task;

use App\Models\Task;

interface TaskService
{
    public function create(array $data): Task;
    public function update(Task $task, array $data): Task;
    public function updateStatus(Task $task, array $data): Task;
    public function delete(Task $task): bool;
    public function cantBeCompleted(Task $task): bool;
}
