<?php

namespace App\Services;

use App\Models\Priority;

class PriorityService
{
    public function create(array $data)
    {
        return Priority::create($data);
    }

    public function update(Priority $priority, array $data)
    {
        $priority->update($data);
        return $priority;
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
