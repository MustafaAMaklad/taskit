<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Task $task): Response
    {
        return ($user->isAssignor() || $task->assignee_id === $user->id)
            ? Response::allow()
            : Response::denyAsNotFound(__('error.task.not_found'));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->isAssignor();
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Task $task): bool
    {
        return $user->isAssignor();
    }

    /**
     * Determine whether the user can update the status of the model.
     */
    public function updateStatus(User $user, Task $task): Response
    {
        return ($user->isAssignee() && $task->assignee_id === $user->id)
            ? Response::allow()
            : Response::denyAsNotFound(__('error.task.not_found'));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Task $task): bool
    {
        return $user->isAssignor();
    }
}
