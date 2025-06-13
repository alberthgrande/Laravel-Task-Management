<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryApiController extends Controller
{

    protected $categoryService;

    public function __construct(CategoryService $categoryService) 
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        return CategoryResource::collection($this->categoryService->getAllCategories());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        $store = $this->categoryService->create($validated);
        
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

        $update = $this->categoryService->update($category, $validated);

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
