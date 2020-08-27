<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;

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
      'data' => ['message'=>'Welcome to GoTrade API 0.0.2']
    ]);
  }
}
