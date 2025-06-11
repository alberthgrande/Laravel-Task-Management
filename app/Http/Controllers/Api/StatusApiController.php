<?php

namespace App\Http\Controllers\Api;

use App\Models\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use Illuminate\Http\Request;

class StatusApiController extends Controller
{
    public function index()
    {
        $priorities = Status::latest()->get();
        return StatusResource::collection($priorities);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        return Status::create($validated);
    }

    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $status->id,
        ]);

        $status->update($validated);

        return response()->json($status);
    }

    public function destroy(Status $status)
    {
        $status->delete();
        
        return response()->json(['message' => 'Status deleted successfully.']);
    }
}
