<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Get all categories
    public function getAllCategories()
    {
        $categories = Category::all();
        $categoriesCount = $categories->count();

        // if perams count=true then return only count of categories
        if (request()->count) {
            return response()->json([
                'message' => 'Categories count retrieved successfully',
                'categoriesCount' => $categoriesCount
            ]);
        }

        return response()->json([
            'message' => 'Categories retrieved successfully',
            'categoriesCount' => $categoriesCount,
            'categories' => $categories
        ]);
    }

    // Get category by id
    public function getCategoryById($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Category retrieved successfully',
            'category' => $category
        ]);
    }

    // Create category
    public function createCategory(Request $request)
    {
        $category = Category::create($request->all());

        return response()->json([
            'message' => 'Category created successfully',
            'category' => $category
        ]);
    }

    // Update category
    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $category->fill($request->all());
        $category->save();

        return response()->json([
            'message' => 'Category updated successfully',
            'category' => $category
        ]);
    }

    // Delete category
    public function deleteCategory($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
