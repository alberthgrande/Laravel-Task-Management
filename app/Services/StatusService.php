<?php

namespace App\Services;

use App\Models\Status;
use App\DTOs\StatusDTO;
use App\Interfaces\StatusServiceInterface;

class StatusService implements StatusServiceInterface
{
    public function create(StatusDTO $dto)
    {
        return Status::create($dto->toArray());
    }

    public function update(Status $status, StatusDTO $dto)
    {
        return $status->update($dto->toArray());
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
