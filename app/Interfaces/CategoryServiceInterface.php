<?php

namespace App\Interfaces;

use App\Models\Category;
use App\DTOs\CategoryDTO;

interface CategoryServiceInterface
{
    public function create(CategoryDTO $dto);
    public function update(Category $category, CategoryDTO $dto);
    public function delete(Category $category);
    public function getAllCategories();
    public function findById($id);
}
