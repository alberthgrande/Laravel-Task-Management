<?php

namespace App\Services;

use App\Models\Status;

class StatusService
{
    public function create(array $data)
    {
        return Status::create($data);
    }

    public function update(Status $status, array $data)
    {
        $status->update($data);
        return $status;
    }

    public function delete(Status $status)
    {
        return $status->delete();
    }

    public function getAllStatuses()
    {
        return Status::latest()->get();
    }

    public function findById($id)
    {
        return Status::findOrFail($id);
    }
}
