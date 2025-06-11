<?php

namespace App\Http\Controllers\Api;

use App\Models\Priority;
use App\Http\Controllers\Controller;
use App\Http\Resources\PriorityResource;
use Illuminate\Http\Request;

class PriorityApiController extends Controller
{
    public function index()
    {
        $priorities = Priority::latest()->get();
        return PriorityResource::collection($priorities);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        return Priority::create($validated);
    }

    public function update(Request $request, Priority $priority)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $priority->id,
        ]);

        $priority->update($validated);

        return response()->json($priority);
    }

    public function destroy(Priority $priority)
    {
        $priority->delete();
        
        return response()->json(['message' => 'Priority deleted successfully.']);
    }
}
