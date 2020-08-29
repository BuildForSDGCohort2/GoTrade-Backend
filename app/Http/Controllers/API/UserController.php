<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\City;
use App\Models\Country;
use App\Models\Product;
use App\Http\Resources\UserResource;


class UserController extends Controller
{
 /**
     * Edit user details
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function editUserDetails(Request $request)
    {
        $validationRules = [
            'display_name' => 'required',
            'city_id' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'date_of_bith' => 'required|date_format:Y-m-d',
            'email' => [
                'required',
                Rule::unique('user')->ignore(Auth::user()->id),
            ],
            'mobile_number' => [
                'required',
                Rule::unique('user')->ignore(Auth::user()->id),
            ],
            'photo_id' => 'bail|mimes:jpeg,png,bmp,jpg|max:10000',
        ];

        $validator = Validator::make($request->input(), $validationRules);
        if ($validator->fails()) {
            return response(['message' => 'Validation Error']);
        }

        if ($request->hasFile('photo_id')) {
            $cityId = $request->input('city_id');
            $stateId = $request->input('state_id');
            if ($cityId && $stateId) {
                if (!City::isCityExistInState($cityId, $stateId)) {
                    $city = DB::table('cities')->select('name')->where(['id' => $cityId])->first();
                    $state = DB::table('state')->select('name')->where(['id' => $stateId])->first();
                    if ($city && $state) {
                        return response()->Json(['message' => 'City does not belong to State.'], 200);
                    } else {
                        return response()->Json(['message' => 'City not found in Country.'], 200);
                    }
                } else {
                    /** @var User $user */
                    $user = Auth::user();
                    $user->edit();
                    return response()->Json(['message' => 'Update successfully'], 200);
                    return response([ 'user' => new UserResource($user), 
                            'message' => 'Request successfully'
                        ], 200);
                }
            } else {
                return response(['message' => 'City not found in Country.'], 200);
            }
        }
        return response(['message' => 'Invalid Image'], 200);
    }
    

    
    /**
     * Add product.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function addProduct(Request $request)
    {
        /** @var User $user */
        $user = Auth::user();

        //Add products to cart

       // return $product;
    }

}
