<?php

namespace App\Services;

use App\Models\Priority;
use App\DTOs\PriorityDTO;
use App\Interfaces\PriorityServiceInterface;

class PriorityService implements PriorityServiceInterface
{
    public function create(PriorityDTO $dto)
    {
        return Priority::create($dto->toArray());
    }

    public function update(Priority $priority, PriorityDTO $dto)
    {
        return $priority->update($dto->toArray());
    }

    public function delete(Priority $priority)
    {
        return $priority->delete();
    }

    public function getAllPriorities()
    {
        return Priority::latest()->get();
    }

    public function findById($id)
    {
        return Priority::findOrFail($id);
    }
}
