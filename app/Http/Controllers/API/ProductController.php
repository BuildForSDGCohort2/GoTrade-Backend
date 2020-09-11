<?php

namespace App\Http\Controllers\API;

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
            'data' => Product::paginate(48)->toJson()
        ]);
    }

    public function byCategory($slug)
    {
        $category = ProductCategory::where('slug', $slug)->first();

        if(!$category) {
          return response()->json([
              'status' => 1,
              'message' => 'OK',
              'errors' => null,
              'data' => null
          ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => Product::where('category_id',$category->id)->paginate(48)->toJson()
        ]);
    }
}
