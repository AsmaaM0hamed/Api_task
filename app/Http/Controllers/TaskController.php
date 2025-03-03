<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use App\Http\Requests\CreateTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\UpdateStatusRequest;
use App\Http\Traits\HandelResponseApiTrait;
use App\Http\Requests\UpdateAssignedToRequest;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    use HandelResponseApiTrait;

    public function listTasks(Request $request)
    {

        $this->authorize('viewTasks', Task::class);

        $tasks = Task::with('subTasks')
                    ->filterTasks($request)
                    ->get();

        return $this->responseSuccess($tasks, 'Tasks fetched successfully');
    }

    public function showOneTask(string $id)
    {
        $task = Task::find($id);
        if (!$task) {
            return $this->responseFailed('Task not found', 404);
        }
        $task->subtasks;
        return $this->responseSuccess($task, 'Task fetched successfully');
    }

    public function showMyTasks(Request $request)
    {
        $tasks = Task::with('subTasks')
                    ->where('assigned_to', auth()->id())
                    ->filterTasks($request)
                    ->get();

        return $this->responseSuccess($tasks, 'Tasks fetched successfully');
    }

    public function create(CreateTaskRequest $request)
    {
        try {

            $this->authorize('createOrUpdate', Task::class);

            $data = $request->all();
            $data['created_by'] = $request->user()->id;

            $task = Task::create($data);
            return $this->responseSuccess($task, 'Task created successfully');

        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage(), 500);
        }
    }

    public function update(UpdateTaskRequest $request, string $id)
    {
        try {

            $this->authorize('createOrUpdate', Task::class);

            $task = Task::find($id);

            if (!$task) {
                return $this->responseFailed('Task not found', 404);
            }
            $data = $request->all();
            if(empty($data))
            {
                return $this->responseFailed('No data to update', 400);
            }
            $task->update([
                'title' => $request->title ?? $task->title,
                'description' => $request->description ?? $task->description,
                'due_date' => $request->due_date ?? $task->due_date,
                'status' => $request->status ?? $task->status,
                'assigned_to' => $request->assigned_to ?? $task->assigned_to,
            ]);
                return $this->responseSuccess($task, 'Task updated successfully');

        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage(), 500);
        }
    }

    public function updateStatus(UpdateStatusRequest $request, string $id)
    {
        try {

                $task = Task::find($id);

                if (!$task) {
                    return $this->responseFailed('Task not found', 404);
                }

                $this->authorize('updateStatus', $task);

                if ($task->status === 'completed' && $request->status === 'canceled') {
                    return $this->responseFailed('Task is completed and cannot be canceled', 400);
                }
                if ($request->status === 'completed') {
                    $subtask=$task->subtasks->where('status','pending');
                        if ($subtask->count() > 0) {
                            return $this->responseFailed('subtasks are not completed please complete them first', 400);
                        }
                }

                $task->update(['status' => $request->status]);
                return $this->responseSuccess($task, 'Task status updated successfully');

        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage(), 500);
        }

    }

    public function updateAssignedTo(UpdateAssignedToRequest $request, string $taskId)
    {
        try {
                $task = Task::find($taskId);
                if (!$task) {
                    return $this->responseFailed('Task not found', 404);
                }

                $this->authorize('createOrUpdate', $task);

                $task->update(['assigned_to' => $request->assigned_to]);
                 return $this->responseSuccess($task, 'Task assigned to new user successfully');

        } catch (\Exception $e) {
            return $this->responseFailed($e->getMessage(), 500);
        }
    }

    public function delete(string $id)
    {

        $task = Task::find($id);

        if (!$task) {
            return $this->responseFailed('Task not found', 404);
        }
        $this->authorize('delete', $task);

        $task->delete();
        return $this->responseSuccess(null, 'Task deleted successfully');
    }
}
