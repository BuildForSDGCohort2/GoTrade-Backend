<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
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
            return response(['error' => $validator->errors(), 'Validation Error']);
        }
        $user = $this->create($data);
        $this->guard()->login($user);
        return response(['message' => 'Created successfully'], 200);
    }

    public function login(Request $request)
    {
        $credentials = array_merge($request->only('email', 'password'), ['is_active' => '1']);

        if (!Auth::attempt($credentials)) {
            return response(['message' => 'Invalid Credentials']);
        }
        return response()->json(['message' => 'Login successful',
                                    'user' => Auth::user()
                                ], 200);
    }

    /* The user has logged out of the application.
    *
    * @return mixed
    */
    public function logout()
    {
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email:rfc,dns,spoof', 'max:255', 'unique:users'],
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
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        
    }

    protected function guard()
    {
        return Auth::guard();
    }
}
