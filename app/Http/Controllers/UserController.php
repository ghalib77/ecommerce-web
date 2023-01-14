<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use JWTAuth;

use App\Http\Resources\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $user=UserResource::collection(User::all());
            return response()->json([
                "data"=>$user
            ],200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(), 500);
        }
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($token)
    {
        try{
            $user=new UserResource(JWTAuth::toUser($token));
            return response()->json([
                'data'=>$user
            ],200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),500);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
       try{
        $user=User::findOrFail($id);
        $validator=Validator::make($request->all(),[
          'name'=>['required', 'string'],
          'username'=>['required', 'string', Rule::unique('users')->ignore($user->id)],
        ]);
        $photo_profile="";

        if($validator->fails()){
          return response()->json($validator->messages(),402);
        }
 
        if($request->hasFile("photo_profile")){
          $photo_profile=$request->file("photo_profile")->store("image", "public");
        }

        $user->update([
          "name"=>$request->name,
          "username"=>$request->username,
          "gender"=>$request->gender ?? null,
          "address"=>$request->address ?? null,
          "photo_profile"=>$photo_profile ?? null
        ]);

        return response()->json([
          "message"=>"user has been updated"
        ],200);
      }catch(\Throwable $th){
        return response()->json($th->getMessage(), 500);
      }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
           User::destroy($id);
           return response()->json([
            'message'=>"user has been deleted"
           ],200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(), 500);
        }
    }
}
