<?php

namespace App\Http\Controllers\API\Trader;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ProductCategory;
use App\Models\Product;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProductController extends Controller
{

    /**
     * Show the API default response.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => [
                'message' => 'Welcome to GoTrade API 0.0.2'
            ]
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required',            
            'amount' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'category_id' => 'required',
        ]);

        $product = $request->user()->products()->create([
            'name' => $request->input('name'),
            'sku' => $request->input('sku'),
            'slug' => $request->input('name'),
            'amount' => $request->input('amount'),
            'discount' => $request->input('discount'),
            'quantity' => $request->input('quantity'),
            'short_description' => $request->input('short_description'),
            'long_description' => $request->input('long_description'),
            'category_id' => $request->input('category_id'),
        ]);
        
        if ($product != null) {
            $product->update([
                'slug' => Str::slug($request->input('name') . ' ' . $product->id, '-'),
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => [
                'message' => 'Product created successfully'
            ]
        ]);
    }
    
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'sku' => 'required',
            'amount' => 'required',
            'discount' => 'required',
            'quantity' => 'required',
            'short_description' => 'required',
            'long_description' => 'required',
            'category_id' => 'required',
        ]);
        
        $product = Product::find($request->input('id'));
        
        $product->update([
            'name' => $request->input('name'),
            'sku' => $request->input('sku'),
            'slug' => $request->input('name'),
            'amount' => $request->input('amount'),
            'discount' => $request->input('discount'),
            'quantity' => $request->input('quantity'),
            'short_description' => $request->input('short_description'),
            'long_description' => $request->input('long_description'),
            'category_id' => $request->input('category_id'),
        ]);
        
        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => [
                'message' => 'Product updated successfully'
            ]
        ]);
    }
    
    public function delete(Request $request)
    {
        $product = Product::find($request->input('id'));
        
        $product->delete();
        
        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => [
                'message' => 'Product deleted successfully'
            ]
        ]);
    }
}
