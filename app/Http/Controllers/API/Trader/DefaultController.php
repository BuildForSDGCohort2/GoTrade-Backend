<?php

namespace App\Http\Controllers\API\Trader;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;

class DefaultController extends Controller
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
}
