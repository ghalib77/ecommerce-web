<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Auth\Events\Registered;
use Auth;
use Validator;
use Hash;
use JWTAuth;

use App\Models\User;
use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        try{
            $validator = Validator::make($request->all(),[
                'username'=> 'required',
                'password' => 'required',
            ]);
            $credentials=$request->only(['username', 'password']);
            
            if($validator->fails()){
                return response()->json($validator->messages(),402);
            }

            if (!Auth::attempt($credentials)) {
                return response()->json([
                    'username' => 'Username or password is incorrect'
                ], 422);
            }
            
            $user=User::where('username', $request->username)->first();
            if (!$user->email_verified_at) {
                auth()->logout();
                return response()->json([
                    'username' => 'Your email address is not verified'
                ], 403);
            }
            $token=JWTAuth::attempt($credentials);

            return response()->json([
                'user' => new UserResource($user),
                'token' => $token
            ], 200);

        }catch(\Throwable $th){
            return response()->json($th->getMessage(), 500);
        }
    }

    public function register(Request $request)
    {
        try{
            $validator=Validator::make($request->all(),[
                'name' => ['required', 'string', 'max:255'],
                'username'=>['required', 'string', 'unique:users'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ]);
            
            if($validator->fails()){
                return response()->json($validator->messages(),402);
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'username'=>$request->username,
                'password' => Hash::make($request->password),
            ]);
            event(new Registered($user));
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),500);
        }
    }
}
