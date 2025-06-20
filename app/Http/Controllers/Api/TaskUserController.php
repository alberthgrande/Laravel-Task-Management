<?php

namespace App\Http\Controllers\Api;

use App\Models\TaskUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TaskUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return TaskUser::latest()->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'task_id' => 'required|exists:tasks,id',
            'user_id' => 'required|exists:users,id',
        ]);

        $taskUser = TaskUser::create($validated);

        return response()->json($taskUser, 201);
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
