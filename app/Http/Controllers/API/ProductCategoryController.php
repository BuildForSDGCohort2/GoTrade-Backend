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
     * @return string|null
     */
    public static function getCategoryNameById($category)
    {
        $categoryName = ProductCategory::getCategoryNameById($category);
        return response([ 'category' => new ProductCategoryResource($categoryName), 
                            'message' => 'Retrieved successfully'
                        ], 200);
    }

    /**
     * Add category.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function addCategory(Request $request)
    {
        $category = new ProductCategory();
        $validators = Validator::make($request->all(), $category->rules());

        if ($validators->fails()) {
            return redirect()->back()->withErrors($validators)->withInput();
        }

        $category->edit();

        return response([ 'category' => new ProductCategoryResource($category), 
                            'message' => 'Product category created successfully'
                        ], 200);
    }

    /**
     * Update product category.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function updateProductCategory(Request $request)
    {
        $id = $request->input('id');
        /** @var ProductCategory $category */
        $category = ProductCategory::FindOrFail($id);
        $rules = $category->rules();
        $rules['name'] .= ',name,' . $category->id;
        $validators = Validator::make($request->all(), $rules);

        if ($validators->fails()) {
            return redirect()->back()->withErrors($validators)->withInput();
        }
        $category->edit();

        return response([ 'category' => new ProductCategoryResource($category), 
                            'message' => 'Product category updated successfully'
                        ], 200);
    }

    /**
     * Delete product category.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function deleteProductCategory($id, Request $request)
    {
        /** @var ProductCategory $category */
        $category = ProductCategory::get($id);
        if ($category) {

            if (!$category->checkIfAssigned()) {
                $category->delete();
                return response(['message' => 'Deleted']);
            }
            return response(['message' => 'Category is assigned, unable delete']);
        }
        return response(['message' => 'Category not found.']);
    }

    /**
     * Search Product category.
     *
     * @return ProductCategory[]|\Illuminate\Database\Eloquent\Collection
     */
    public static function search()
    {
        $categorySearch = ProductCategory::search();
        return response([ 'category' => new ProductCategoryResource($categorySearch), 
                            'message' => 'Search successfully'
                        ], 200);
    }
}