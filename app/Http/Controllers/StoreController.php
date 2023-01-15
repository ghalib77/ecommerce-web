<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Storage;

use App\Http\Resources\StoreResource;
use App\Models\Store;

class StoreController extends Controller
{
    public function index()
    {
        try{
            $store=StoreResource::collection(Store::all());
            
            return response()->json(['data'=>$store],200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),500);
        }
    }

    public function show($id)
    {
        try{
            $store=new StoreResource(Store::findOrFail($id));
            return response()->json(['data'=>$store], 200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage(),500);
        }
    }

    public function like(Request $request, $search)
    {
        try{
            $store=StoreResource::collection(Store::where('name', $search)
            ->orWhere('name', 'like', '%' . $search . '%')
            ->get()
            );

            return response()->json(['data'=>$store],200);
        }catch(\Throwable $th){
            return response()->json($th->getMessage, 500);
        }
    }

    public function store(Request $request)
    {
       $validator=Validator::make($request->all(),[
          "name"=>['required', 'string', 'unique:store'],
          "location"=>['required', 'string'],
          "user_id"=>['required']
       ]);

       try{
            $store_image=null;
            
            if($validator->fails()){
                return response()->json($validator->messages(), 402);
            }

            if($request->hasFile('store_image')){
                $store_image=$request->file('store_image')->store('image', 'public');
            }

            Store::create([
                'name'=>$request->name,
                'store_image'=>$store_image,
                'location'=>$request->location,
                'user_id'=>$request->user_id
            ]);

            return response()->json(['message'=>'create store success'],200);
       }catch(\Throwable $th){
            return response()->json($th->getMessage(), 500);
       }
    }

    public function update(Request $request, $id){
        try{
            $store=Store::findOrFail($id);
            $validator=Validator::make($request->all(),[
                "name"=>['required', 'string', Rule::unique('store')->ignore($store->id)],
                "location"=>['required', 'string']
            ]);
            $store_image=null;
            
            if($validator->fails()){
                return response()->json($validator->messages(), 402);
            }

            if($request->hasFile('store_image') && $request->file('store_image') !== null){
                $store_image=$request->file('store_image')->store('image', 'public');
                if($store->store_image !== null && \File::exists(public_path('storage/'.$store->store_image))){
                    \File::delete(public_path('storage/'.$store->store_image));
                }
            }

            $store->update([
                'name'=>$request->name,
                'store_image'=>$store_image ? $store_image : $store->store_image,
                'location'=>$request->location
            ]);

            return response()->json(['message'=>'update store success'], 200);

        }catch(\Throwable $th){
            return response()->json($th->getMessage(), 500);
        }
    }
    
    public function destroy($id){
      try{
        $store=Store::findOrFail($id);

        if($store->store_image !== null && \File::exists(public_path('storage/'.$store->store_image))){
            \File::delete(public_path('storage/'.$store->store_image));
        }

        $store->delete();
        return response()->json(['message'=>'delete store success'],200);
      }catch(\Throwable $th){
        return response()->json($th->getMessage(),500);
      }
    }    
}
