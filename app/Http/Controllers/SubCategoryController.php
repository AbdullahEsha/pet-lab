<?php

namespace App\Http\Controllers;

use App\Models\SubCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    // get all subcategories
    public function getAllSubCategories()
    {
        $subcategories = SubCategory::all();
        $subcategoriesCount = $subcategories->count();

        // if perams count=true then return only count of subcategories
        if (request()->count) {
            return response()->json([
                'message' => 'SubCategories count retrieved successfully',
                'count' => $subcategoriesCount
            ]);
        }
        
        return response()->json([
            'message' => 'SubCategories retrieved successfully',
            'count' => $subcategoriesCount,
            'subcategories' => $subcategories
        ]);
    }

    // get subcategory by id
    public function getSubCategoryById($id)
    {
        $subcategory = SubCategory::find($id);

        if (!$subcategory) {
            return response()->json([
                'message' => 'SubCategory not found'
            ], 404);
        }

        return response()->json([
            'message' => 'SubCategory retrieved successfully',
            'subcategory' => $subcategory
        ]);
    }

    // create subcategory
    public function createSubCategory(Request $request)
    {
        $subcategory = SubCategory::create($request->all());

        return response()->json([
            'message' => 'SubCategory created successfully',
            'subcategory' => $subcategory
        ]);
    }

    // update subcategory by id
    public function updateSubCategory(Request $request, $id)
    {
        $subcategory = SubCategory::find($id);

        if (!$subcategory) {
            return response()->json([
                'message' => 'SubCategory not found'
            ], 404);
        }

        $subcategory->update($request->all());

        return response()->json([
            'message' => 'SubCategory updated successfully',
            'subcategory' => $subcategory
        ]);
    }

    // delete subcategory by id
    public function deleteSubCategory($id)
    {
        $subcategory = SubCategory::find($id);

        if (!$subcategory) {
            return response()->json([
                'message' => 'SubCategory not found'
            ], 404);
        }

        $subcategory->delete();

        return response()->json([
            'message' => 'SubCategory deleted successfully'
        ]);
    }
}
