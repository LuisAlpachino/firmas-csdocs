<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Users;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function createUser(Request $request){
        if($request->isJson()){
            $data = $request->json()->all();
            $user = Users::create([
                'user_name' => $data['user_name'],
                'last_name' => $data['last_name'],
                'second_last_name' => $data['second_last_name'],
                'rfc' => $data['rfc'],
                'curp' => $data['curp'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'genders' => $data['genders'],
                'user_type' => $data['user_type'],
                'api_token' => Str::random(60),
                'telephone' => $data['telephone'],
                'fk_localities' => $data['fk_localities'],
                'fk_user_status' => $data['fk_user_status']
            ]);
            return response()->json($user,201);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function getUsers(Request $request){
        if($request->isJson()){
            $user= Users::where('fk_user_status', 2)->get();
            return response()->json($user,200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function getUserById(Request $request, $id){
        if ($request->isJson()){
            return response()->json(Users::find($id));
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function updateById(Request $request, $id){
        if($request->isJson()){
            $user = Users::findOrFail($id);
            $user->update($request->all());
            return response()->json($user,200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function deleteById(Request $request, $id){
        if($request->isJson()){
            $user = Users::findOrFail($id);
            $user->update(['fk_user_status' => 1]);
            return response('Delete Successfully', 200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function getToken(Request $request){
        if ($request->isJson()) {
            try {
               $data = $request->json()->all();

               $user = Users::where('email', $data['email'])->first();

               if ($user && Hash::check($data['password'], $user->password)){
                   return response()->json($user,200);
               }
               else{
                   response()->json(['error'=> 'No content'],406);
               }
            }catch (ModelNotFoundException $e){
                response()->json(['error'=> 'No content'],406);
            }
        }

        return response()->json(['error' => 'Unauthorized'],'401');

    }

}
