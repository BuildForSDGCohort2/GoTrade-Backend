<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
    * return products by TraderId
    *
    * @return \Illuminate\Http\Response
    */
    public function getProductsByTraderId()
    {
        $user = Auth::user();
        $traderId = Auth::user()->id;
        if ($user->role == \UserType::TRADER) {
            $products = self::getTraderProducts($traderId);
        }

        return response([ 
            'success' => true,
            'data' => new ProductResource($products), 
            'message' => 'Retrieved successfully'
        ], 202);
    }

    /**
    * return Product by Id
    *
    * @param $id
    *
    * @return \Illuminate\Http\Response
    */
    public function getProductById($id)
    {
        $product = Product::get($id);
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product with id ' . $id . ' not found'
            ], 404);
        }
        return response([ 
            'success' => true,
            'data' => new ProductResource($products->toArray()), 
            'message' => 'Retrieved successfully'
        ], 202);
    }

    /**
     * return all product
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllProducts()
    {
        $products = Product::getAllProducts();
        return response([
            'products' => new ProductResource($products->toArray()), 
            'message' => 'Retrieved successfully'
        ], 200);
    }

    /**
     * Add a product.
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public static function add(Request $request)
    {
        $product = new Product();
        $validator = Validator::make($request->all(), $product->rules());

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error:' .$validator->errors()
            ], 500);
        }

        $user = Auth::user();
        if ($user->role == \UserType::TRADER) {
            $product->edit();
            return response([ 
                'success' => true,
                'data' => new ProductResource($product->toArray()), 
                'message' => 'Created successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorize user. Product could not be added'
            ], 500);
        }
        
    }

    /**
     * Edit a product
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function editProduct(Request $request)
    {
        $id = $request->input('id');
        /** @var Product $category */
        $product = Product::FindOrFail($id);
        $rules = $product->rules();
        $rules['name'] .= ',name,' . $product->id;
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error:' .$validator->errors()
            ], 500);
        }
        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product with id ' . $id . ' not found'
            ], 400);
        }

        $user = Auth::user();
        if ($user->role == \UserType::TRADER) {
            $product->edit();
            return response([ 
                'success' => true,
                'data' => new ProductResource($product->toArray()), 
                'message' => 'Update successfully'
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorize user. Product could not be updated'
            ], 500);
        }
    
    }

    /**
     * Delete product.
     *
     * @param Request $request
     * @param $id
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteProduct(Request $request, $id)
    {
        /** @var Product $product */
        $product = Product::get($id);
        $user = Auth::user();
        if ($user->role == \UserType::TRADER) {

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product with id ' . $id . ' not found'
                ], 404);
            }
            if ($product->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Deleted'
                ], 200);
             } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Product could not be deleted'
                ], 500);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorize user. Unable to delete product'
            ], 500);
        }

    }

    /**
     * Returns trader product by Id.
     *
     * @param $traderId
     * @return mixed
     */
    public static function getTraderProducts($traderId)
    {
        return Product::getTraderProducts($traderId);
    }
    /**
     * Search Product.
     *
     * @return \Illuminate\Http\Response
     */
    public static function search()
    {
        $productSearch = Product::search();
        return response([ 'category' => new ProductCategoryResource($productSearch), 
                            'message' => 'Search successfully'
                        ], 200);
    }
    
}
