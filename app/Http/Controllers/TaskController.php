<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateTaskRequest;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Traits\HandelResponseApiTrait;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class TaskController extends Controller
{
    use AuthorizesRequests;

    use HandelResponseApiTrait;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Task::query();

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        if ($request->has('due_date')) {
            $query->whereBetween('due_date', explode(',', $request->due_date));
        }
        if ($request->has('assigned_to')) {
            $query->where('assigned_to', $request->assigned_to);
        }
        $tasks = $query->get();

        return $this->responseSuccess($tasks, 'Tasks fetched successfully');
    }


    public function create(CreateTaskRequest $request)
    {
        $this->authorize('create', Task::class);
        $data = $request->all();
        $data['status'] = 'pending';
        $data['created_by'] = $request->user()->id;
        
        $task = Task::create($data);
        return $this->responseSuccess($task, 'Task created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
