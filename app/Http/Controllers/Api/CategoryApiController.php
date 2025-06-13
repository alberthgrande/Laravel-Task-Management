<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
// use App\Services\CategoryService;
use App\Interfaces\CategoryServiceInterface;
use App\DTOs\CategoryDTO;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{

    public function __construct(private CategoryServiceInterface $categoryService) {}

    public function index()
    {
        return CategoryResource::collection($this->categoryService->getAllCategories());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $dto = new CategoryDTO($validated);
        $store = $this->categoryService->create($dto);
        
        if($store) {
            return response()->json([
                "success" => true,
                "message" => "Category created successfully."
            ], 201);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Failed to create category."
            ], 500);
        }
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
        ]);

        $dto = new CategoryDTO($validated);
        $update = $this->categoryService->update($category, $dto);

        if($update) {
            return response()->json([
                "success" => true,
                "message" => "Category updated successfully."
            ], 200);
        }
        else {
            return response()->json([
                "success" => false,
                "message" => "Failed to update category."
            ], 500);
        }

    }

    public function destroy(Category $category)
    {
        $deleted = $this->categoryService->delete($category);

        if ($deleted) {
            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.'
            ], 200);
        } 
        else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete category.'
            ], 500);
        }
    }

}
