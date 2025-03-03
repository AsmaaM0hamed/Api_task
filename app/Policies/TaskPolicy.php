<?php

namespace App\Policies;

use App\Models\Task;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TaskPolicy
{

    public function viewTasks(User $user): bool
    {
        return $user->type === 'manager';
    }
    
    public function showOneTask(User $user, Task $task): bool
    {
        return $user->type === 'manager' || $user->id === $task->assigned_to;
    }


    public function createOrUpdate(User $user): bool
    {
        return $user->type === 'manager';
    }


    public function updateStatus(User $user, Task $task): bool
    {
        return $user->type === 'manager' || $user->id === $task->assigned_to;
    }

    public function delete(User $user, Task $task): bool
    {
        return $user->type === 'manager';
    }
}
