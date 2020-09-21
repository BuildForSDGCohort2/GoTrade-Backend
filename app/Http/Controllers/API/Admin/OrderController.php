<?php
namespace App\Http\Controllers\API\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * @return Order[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getAll()
    {
        $order = Order::all();
        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'users' => $order,
            'data' => [
                'message' => 'Retrieved successfully'
            ]
        ]);
    }

}
