<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * Returns array of orders by user ID.
     *
     * @param $own_by
     * @return \Illuminate\Http\Response
     */
    public function getOrderByUserId($own_by)
    {
        $order = Order::where('own_by', $own_by)
                                ->orderBy('created_at', 'DESC')
                                ->get();
        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'users' => $order->toArray(),
            'data' => [
                'message' => 'Retrieved successfully'
            ]
        ]);
    }

    /**
     * Add order.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function addOrder(Request $request)
    {
        $validate = [
            'adress' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
        ];
        $validator = Validator::make($request->all(), $validate);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error:' .$validator->errors()
            ], 500);
        }

        $order = $request->user()->order()->create([
            'adress' => $request->input('adress'),
            'order_no' => (string) Str::uuid(),
            'state_id' => $request->input('state_id'),
            'city_id' => $request->input('city_id'),
            'country_id' => Auth::user()->country_id,
            'ip_address' => $request->ip(),
            'status' => 1,
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'order' => $order->toArray(),
            'data' => [
                'message' => 'Order created successfully'
            ]
        ]);
    }

    /**
     * Delete Order.
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteOrder(Request $request)
    {
        $user = Auth::user();
        if ($user) {
            $order = Order::find($request->input('id'));

            $order->delete();

            return response()->json([
                'status' => 1,
                'message' => 'OK',
                'errors' => null,
                'data' => [
                    'message' => 'Order deleted successfully'
                ]
            ]);
        } else {
            return response([
                'message' => 'Unauthenticated user.'
            ], 500);
        }
        
    }
}
