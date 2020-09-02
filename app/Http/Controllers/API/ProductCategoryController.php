<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ProductCategory;
use App\Http\Resources\ProductCategoryResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Class ProductCategoryController
 * @package App\Http\Controllers\API
 */
class ProductCategoryController extends Controller
{
    /**
     * Get category name by ID.
     *
     * @param $category
     * 
     * @return \Illuminate\Http\Response
     */
    public static function getCategoryNameById($category)
    {
        $categoryName = ProductCategory::getCategoryNameById($category);
            return response([
                'category' => new ProductCategoryResource($categoryName), 
                'message' => 'Retrieved successfully'
            ], 201);
    }

    /**
     * Add category.
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function addCategory(Request $request)
    {
        $category = new ProductCategory();
        $validator = Validator::make($request->all(), $category->rules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error:' .$validator->errors()
            ], 500);
        }

        $category->edit();

        return response([ 'category' => new ProductCategoryResource($category), 
                            'message' => 'Product category created successfully'
                        ], 201);
    }

    /**
     * Update product category.
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function updateProductCategory(Request $request)
    {
        $id = $request->input('id');
        /** @var ProductCategory $category */
        $category = ProductCategory::FindOrFail($id);
        $rules = $category->rules();
        $rules['name'] .= ',name,' . $category->id;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error:' .$validator->errors()
            ], 500);
        }
        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Category with id ' . $id . ' not found'
            ], 404);
        }
        $user = Auth::user();
        if ($user->role == \UserType::TRADER) {
            $category->edit();
                return response([ 
                    'success' => true,
                    'data' => new ProductCategoryResource($category->toArray()), 
                    'message' => 'Product category updated successfully'
                ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorize user. Product category could not be updated'
            ], 500);
        }
    }

    /**
     * Delete product category.
     *
     * @param Request $request
     * @param $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteProductCategory($id, Request $request)
    {
        /** @var ProductCategory $category */
        $category = ProductCategory::get($id);
        $user = Auth::user();
        if ($user->role == \UserType::TRADER) {
            if ($category) {

                if (!$category->checkIfAssigned()) {
                    if ($category->delete()) {
                        return response()->json([
                            'success' => true,
                            'message' => 'Deleted'
                        ], 200);
                     } else {
                        return response()->json([
                            'success' => false,
                            'message' => 'Category could not be deleted'
                        ], 500);
                    }
                }
                return response()->json([
                    'success' => true,
                    'message' => 'Category is assigned, unable delete'
                ], 200);
            }
            return response()->json([
                'success' => false,
                'message' => 'Category not found.'
            ], 404);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorize user. Unable to delete category'
            ], 500);
        }
    }

    /**
     * Search Product category.
     *
     * @return \Illuminate\Http\Response
     */
    public static function search()
    {
        $categorySearch = ProductCategory::search();
        return response([ 'category' => new ProductCategoryResource($categorySearch), 
                            'message' => 'Search successfully'
                        ], 200);
    }
}