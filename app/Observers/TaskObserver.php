<?php

namespace App\Observers;

use App\Enums\TaskStatus;
use App\Models\Task;

class TaskObserver
{
    /**
     * Handle the Task "creating" event.
     */
    public function creating(Task $task): void
    {
        $task->status = TaskStatus::PENDING;
    }

    /**
     * Handle the Task "updated" event.
     */
    public function updated(Task $task): void
    {
        /** @var Task $mainTask */

        if (
            !$task->wasChanged('status') ||
            !$task->main_task_id ||
            !$mainTask = $task->mainTask
        ) {
            return;
        }

        // Set main-task to pending if sub-task was reverted from completed
        if ($task->status !== TaskStatus::COMPLETED) {
            if ($mainTask->status === TaskStatus::COMPLETED) {
                $mainTask->updateQuietly([
                    'status' => TaskStatus::PENDING,
                ]);
            }
        }
        // Set main-task to completed if all sub-tasks are completed
        else {
            if ($mainTask->subTasks()->incomplete()->doesntExist()) {
                $mainTask->updateQuietly([
                    'status' => TaskStatus::COMPLETED,
                ]);
            }
        }
    }
}
