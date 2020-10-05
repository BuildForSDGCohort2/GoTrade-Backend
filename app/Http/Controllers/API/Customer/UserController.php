<?php
namespace App\Http\Controllers\API\Customer;

use App\Http\Controllers\Controller;
use App\Http\Controllers\CustomerController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function getAuthenticatedUserProfile()
    {
        $user = Auth::user();
        if ($user) {
            $userDetails = $user->toArray();
        }
            return response()->json([
                'status' => 1,
                'message' => 'OK',
                'errors' => null,
                'user' => $userDetails,
                'data' => [
                    'message' => 'Retrieved successfully'
                ]
            ]);    
    }

    /**
     * Edit user details
     *
     * @param Request $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function editUserDetails(Request $request)
    {
        if (!Auth::user()) {
            return response([
                'message' => 'Unauthenticated user'
            ], 500);
        } else {
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
                    'numeric',
                    Rule::unique('user')->ignore(Auth::user()->id),
                ],
                'photo_file' => 'bail|mimes:jpeg,png,bmp,jpg|max:20480',
            ];

            $validator = Validator::make($request->input(), $validationRules);
            if ($validator->fails()) {
                return response(['message' => 'Validation Error']);
            }

            if ($request->hasFile('photo_file')) {
                /** @var User $user */
                $user = Auth::user();
                $result = CustomerController::doUpload($request->file('photo_file'), "account/photograph", md5($user->id));
                if (!$result) {
                    return redirect()->route('profile')->with('error', 'Photo upload not successful');
                }
            } else {
                return response(['message' => 'Invalid Image'], 200);
            }

            $cityId = $request->input('city_id');
            $stateId = $request->input('state_id');
            if ($cityId && $stateId) {
                $stateCity = DB::table('cities')
                            ->where(['state_id' => $stateId, 'id' => $cityId])->pluck('id')->toArray();

                $doesCityExistInState = in_array($cityId, $stateCity);
                if (!$doesCityExistInState) {
                    $city = DB::table('cities')->select('name')->where(['id' => $cityId])->first();
                    $state = DB::table('state')->select('name')->where(['id' => $stateId])->first();
                    if ($city && $state) {
                        return response()->Json(['message' => $city .'does not belong to' .$state], 200);
                    } else {
                        return response()->Json(['message' => $city .'not found in Country.'], 200);
                    }
                }
            } else {
                $user = self::edit();
                if ($user) {
                    return response(['message' => 'Request successful'], 200);
                }
                return response(['message' => 'Request failed'], 200);
            }
        }
    }

    /**
     * Add/update user.
     *
     * @throws \Exception
     */
    public static function edit()
    {
        $postData = request();
        $userInstance = new User();

        $userInstance->forceFill($postData);
        $userInstance->save();

        return true;
    }
}
