<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function create(array $data)
    {
        return Category::create($data);
    }

    public function update(Category $category, array $data)
    {
        $category->update($data);
        return $category;
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
