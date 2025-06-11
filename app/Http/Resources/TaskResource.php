<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return parent::toArray($request);
        // return [
        //     'id' => $this->id,
        //     'title' => $this->title,
        //     'description' => $this->description,
        //     'category' => new CategoryResource($this->whenLoaded('category')),
        //     'priority' => new PriorityResource($this->whenLoaded('priority')),
        //     'status' => new StatusResource($this->whenLoaded('status')),
        //     'created_at' => $this->created_at,
        //     'updated_at' => $this->updated_at,
        // ];
    }
}
