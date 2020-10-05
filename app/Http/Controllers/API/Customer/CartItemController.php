<?php
namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CartItemController extends Controller
{
    /**
     * Returns User Cart Item Count.
     *
     * @param $id
     * 
     * @return \Illuminate\Http\Response
     */
    public static function cartCountByUserID()
    {
        if (!Auth::user()) {
            return response([
                'message' => 'Unauthenticated user'
            ], 500);
        }else {
            $id = Auth::user()->id;
            $count= CartItem::where('own_by', $id)->count();            
            return response()->json([
                'status' => 1,
                'message' => 'Ok',
                'data' => $count
            ], 200);
        }
    }
    
    /**
     * Add to Cart Item.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function addToCart(Request $request)
    {
        $validate = [
            'amount' => 'required',
            'quantity' => 'required',
        ];
        $validator = Validator::make($request->all(), $validate);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error:' .$validator->errors()
            ], 500);
        }

        if (!Auth::user()) {
            return response([
                'message' => 'Unauthenticated user'
            ], 500);
        }else {
            $cart = $request->user()->cart()->create([
            'amount' => $request->input('amount'),
            'quantity' => $request->input('quantity'),
            'product_id' => $request->input('product_id'),
            'own_by' => Auth::user()->id,
        ]);
            return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'cartItem' => $cart->toArray(),
            'data' => [
                'message' => 'Added to cart created successfully'
                ]
            ]);
        }
    }

    /**
     *Update Cart Item.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function updateCartItem(Request $request)
    {
        $validate = ['quantity' => 'required'];
        $validator = Validator::make($request->all(), $validate);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error:' .$validator->errors()
            ], 500);
        }

        if (!Auth::user()) {
            return response([
                'message' => 'Unauthenticated user'
            ], 500);
        } else {
            $userId = Auth::user()->id;
            $quantity = $request->input('quantity');
            $productId = $request->input('product_id');
            $cart = CartItem::where('own_by', $userId)
                            ->where('product_id', $productId)
                            ->update(['quantity' => $quantity]);


            return response()->json([
                'status' => 1,
                'message' => 'OK',
                'errors' => null,
                'cartItem' => $cart->toArray(),
                'data' => [
                    'message' => 'Cart updated successfully'
                ]
            ]);
        }
    }

    /**
     *Remove Cart Item.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public static function removeCartItem(Request $request)
    {

        if (!Auth::user()) {
            return response([
                'message' => 'Unauthenticated user'
            ], 500);
        } else {
            if (Auth::user()->id == Auth::user()->cart()->own_by) {
                $cart = CartItem::find($request->input('id'));
                $cart->delete();
    
                return response()->json([
                    'status' => 1,
                    'message' => 'OK',
                    'errors' => null,
                    'data' => [
                        'message' => 'Product removed from cart successfully'
                    ]
                ]);
            }
        }
    }
}
