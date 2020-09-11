<?php

namespace App\Http\Controllers\API\Trader;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
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

    public function delete(Request $request)
    {
        $order = Order::find($request->input('id'));

        $product->delete();

        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => [
                'message' => 'Order deleted successfully'
            ]
        ]);
    }
}
