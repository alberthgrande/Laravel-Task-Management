<?php

namespace App\Services;

use App\Models\Category;
use App\DTOs\CategoryDTO;
use App\Interfaces\CategoryServiceInterface;

class CategoryService implements CategoryServiceInterface
{
    public function create(CategoryDTO $dto)
    {
        return Category::create($dto->toArray());
    }

    public function update(Category $category, CategoryDTO $dto)
    {
        return $category->update($dto->toArray());
    }

    public function delete(Category $category)
    {
        return $category->delete();
    }

    public function getAllCategories()
    {
        return Category::latest()->get();
    }

    public function findById($id)
    {
        return Category::findOrFail($id);
    }
}
