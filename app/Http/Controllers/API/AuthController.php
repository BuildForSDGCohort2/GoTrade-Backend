<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class AuthController extends Controller
{
    use HasApiTokens, Notifiable;
    
    /**
     * Create a new user instance after a valid registration.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {   
        $data = $request->all();
        $validator = $this->validator($data);
        if($validator->fails()){
            return response(['message' => $validator->errors()], 500);
        }
        $user = $this->create($data);
        $token = $user->createToken('go-trade-token')->plainTextToken;

        $this->guard()->login($user);
            return response([
                'token' => $token,
                'message' => 'Created successfully'
            ], 200);
    }

    public function login(Request $request)
    {
        $credentials = array_merge($request->only('email', 'password'), ['is_active' => '1']);

        if (!Auth::attempt($credentials)) {
            return response([
                'message' => 'The provided credentials are incorrect.'
            ], 500);
        }else {
            $user = Auth::user();
            $token = $user->createToken('go-trade-token'.$request->email)->plainTextToken;
                return response()->json([
                    'message' => 'Login successful',
                    'token' => $token
                ], 200);
        }
    }

    /* The user has logged out of the application.
    *
    * @return mixed
    */
    public function logout()
    {
        // Revoke token...
        $revokeToken = User::revokeUserToken();
        Auth::logout();
        return response()->json(['message' => 'Logged Out'], 200);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name' => ['required', 'string', 'max:32'],
            'last_name' => ['required', 'string', 'max:32'],
            'email' => ['required', 'email', 'string', 'max:255', 'unique:users'],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*#?&]/'
            ],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        return User::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
