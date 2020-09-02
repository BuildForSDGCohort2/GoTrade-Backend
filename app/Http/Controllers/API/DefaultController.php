<?php

namespace App\Http\Controllers\API;

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

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => [
                    'The provided credentials are incorrect.'
                ]
            ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => [
                'message' => 'Login was successful',
                'token' => $user->createToken('go-trade-token')->plainTextToken
            ]
        ]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'display_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required',
            'password' => 'required'
        ]);

        User::create([
            'display_name' => $request->input('display_name'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_active' => true,
            'role' => 'customer'
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => [
                'message' => 'Registration was successful'
            ]
        ]);
    }

    public function registerAsTrader(Request $request)
    {
        $request->validate([
            'display_name' => 'required',
            'first_name' => 'required',
            'email' => 'required|email',
            'mobile_number' => 'required',
            'password' => 'required',
            'address' => 'required',
            'country_id' => 'required',
            'state_id' => 'required',
            'city_id' => 'required'
        ]);

        User::create([
            'display_name' => $request->input('display_name'),
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'mobile_number' => $request->input('mobile_number'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role' => 'trader',
            'address' => $request->input('address'),
            'country_id' => $request->input('country_id'),
            'state_id' => $request->input('state_id'),
            'city_id' => $request->input('city_id')
        ]);

        return response()->json([
            'status' => 1,
            'message' => 'OK',
            'errors' => null,
            'data' => [
                'message' => 'Registration was successful'
            ]
        ]);
    }
}
