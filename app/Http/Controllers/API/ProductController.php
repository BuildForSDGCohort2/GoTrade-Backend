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
     * return all product
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllUsers()
    {
        $products = Product::getAllProducts();
        return response([ 'products' => ProductResource::collection($products), 
                            'message' => 'Retrieved successfully'
                        ], 200);
    }

    public static function add($id, $userId = false)
    {
        return Product::add($id, $userId);
    }
    
}
