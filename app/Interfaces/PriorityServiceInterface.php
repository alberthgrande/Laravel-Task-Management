<?php

namespace App\Interfaces;

use App\Models\Priority;
use App\DTOs\PriorityDTO;

interface PriorityServiceInterface
{
    public function create(PriorityDTO $dto);
    public function update(Priority $priority, PriorityDTO $dto);
    public function delete(Priority $priority);
    public function getAllPriorities();
    public function findById($id);
}
