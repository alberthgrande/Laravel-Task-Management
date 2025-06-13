<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\Priority;
use App\Models\Status;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    public function index()
    {
        return Inertia::render('Tasks/Index'); 
    }

    public function create()
    {
        $categories = Category::select('id', 'name')->get();
        $priorities = Priority::select('id', 'name')->get();
        $statuses = Status::select('id', 'name')->get();

        return Inertia::render('Tasks/Create', [
            'categories' => $categories,
            'priorities' => $priorities,
            'statuses' => $statuses,
        ]);
    }

    public function show($id)
    {
        $task = Task::with(['category', 'priority', 'status'])->findOrFail($id);

        return Inertia::render('Tasks/View', [
            'task' => $task,
        ]);
    }

    public function edit($id)
    {
        $task = Task::with(['category', 'priority', 'status'])->findOrFail($id);
        
        $categories = Category::select('id', 'name')->get();
        $priorities = Priority::select('id', 'name')->get();
        $statuses = Status::select('id', 'name')->get();

        return Inertia::render('Tasks/Edit', [
            'task' => $task,
            'categories' => $categories,
            'priorities' => $priorities,
            'statuses' => $statuses,
        ]);
    }

}
