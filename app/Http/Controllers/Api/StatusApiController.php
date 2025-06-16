<?php

namespace App\Http\Controllers\Api;

use App\Models\Status;
use App\Http\Controllers\Controller;
use App\Http\Resources\StatusResource;
use App\Interfaces\StatusServiceInterface;
use App\DTOs\StatusDTO;
use Illuminate\Http\Request;

class StatusApiController extends Controller
{

    public function __construct(private StatusServiceInterface $statusService) {}

    public function index()
    {
        return StatusResource::collection($this->statusService->getAllStatuses());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:statuses,name',
        ]);

        $dto = new StatusDTO($validated);
        $store = $this->statusService->create($dto);

        if($store) {
            return response()->json([
                "success" => true,
                "message" => "Status created successfully."
            ], 201);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Failed to create status."
            ], 500);
        }
    }

    public function update(Request $request, Status $status)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:statuses,name,' . $status->id,
        ]);

        $dto = new StatusDTO($validated);
        $update = $this->statusService->update($status, $dto);

        if($update) {
            return response()->json([
                "success" => true,
                "message" => "Status updated successfully."
            ], 200);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Failed to update status."
            ], 500);
        }

        return response()->json($status);
    }

    public function destroy(Status $status)
    {
        $delete = $this->statusService->delete($status);
        
        if($delete) {
            return response()->json([
                "success" => true,
                "message" => "Status deleted successfully."
            ], 200);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Failed to delete status."
            ], 200);
        }
    }
}
