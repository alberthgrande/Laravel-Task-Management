<?php

namespace App\DTOs;

class CategoryDTO
{
    private string $name;

    public function __construct(array $data)
    {
        $this->name = $data['name'];
    }

    public function getName() : string 
    {
        return $this->name;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
        ];
    }
}

