<?php

namespace App\Http\Controllers\Api;

use App\Models\Priority;
use App\Http\Controllers\Controller;
use App\Http\Resources\PriorityResource;
use App\Interfaces\PriorityServiceInterface;
use App\DTOs\PriorityDTO;
use Illuminate\Http\Request;

class PriorityApiController extends Controller
{


    public function __construct(private PriorityServiceInterface $priorityService) {}

    public function index()
    {
        return PriorityResource::collection($this->priorityService->getAllPriorities());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:priorities,name',
        ]);

        $dto = new PriorityDTO($validated);
        $store = $this->priorityService->create($dto);

        if($store) {
            return response()->json([
                "success" => true,
                "message" => "Priority created successfully",
            ], 201);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Failed to priority category.",
            ], 500);
        }
    }

    public function update(Request $request, Priority $priority)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $priority->id,
        ]);

        $dto = new PriorityDTO($validated);
        $update = $this->priorityService->update($priority, $dto);

        if($update) {
            return response()->json([
                "success" => true,
                "message" => "Priority updated successfully."
            ], 200);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Failed to update priority."
            ], 500);
        }
    }

    public function destroy(Priority $priority)
    {
        $delete = $this->priorityService->delete($priority);

        if($delete) {
            return response()->json([
                "success" => true,
                "message" => "Priority deleted successfully."
            ], 200);
        }
        else {
            return response()->json([
                "success" => true,
                "message" => "Failed to delete priority."
            ], 500);
        }
        
    }
}
