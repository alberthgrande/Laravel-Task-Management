<?php

namespace App\Http\Controllers\Api;

use App\Models\Task;
use App\Http\Controllers\Controller;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskApiController extends Controller
{

    public function index()
    {
        $tasks = Task::with(['category', 'priority', 'status'])->latest()->get();
        return TaskResource::collection($tasks);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'status_id' => 'required|exists:statuses,id',
        ]);
    
        $task = Task::create($validated);
    
        return response()->json($task, 201);
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, Task $task)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255|unique:tasks,title,' . $task->id,
            'description' => 'required|string|max:255|unique:tasks,description,' . $task->id,
            'category_id' => 'required|exists:categories,id',
            'priority_id' => 'required|exists:priorities,id',
            'status_id' => 'required|exists:statuses,id',
            
        ]);

        $task->update($validated);

        return response()->json($task);
    }

    public function destroy(Task $task)
    {
        $task->delete();
        
        return response()->json(['message' => 'Task deleted successfully.']);
    }
}
