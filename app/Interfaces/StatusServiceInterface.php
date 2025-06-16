<?php

namespace App\Interfaces;

use App\Models\Status;
use App\DTOs\StatusDTO;

interface StatusServiceInterface
{
    public function create(StatusDTO $dto);
    public function update(Status $status, StatusDTO $dto);
    public function delete(Status $status);
    public function getAllStatuses();
    public function findById($id);
}
