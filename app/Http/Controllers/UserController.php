<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function createUser(Request $request){
        if($request->isJson()){
            $data = $request->json()->all();
            $user = User::create([
                'user_name' => strtoupper($data['user_name']) ,
                'last_name' => strtoupper($data['last_name']),
                'second_last_name' => $data['second_last_name'],
                'rfc' => strtoupper($data['rfc']),
                'curp' => strtoupper($data['curp']),
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'genders' => $data['genders'],
                'user_type' => $data['user_type'],
                'api_token' => Str::random(60),
                'telephone' => $data['telephone'],
                'fk_localities' => $data['fk_localities'],
                'address' => strtoupper($data['address']),
                'fk_user_status' => $data['fk_user_status']
            ]);
            return response()->json(['user' => $user],201);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function getUsers(Request $request){
        if ($request->isJson()){

            return response()->json(['users' => User::where('fk_user_status', 2)->get()],200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function getUserById(Request $request, $id){
        if ($request->isJson()){
            return response()->json(User::find($id));
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function updateById(Request $request, $id){
        if($request->isJson()){
            $user = User::findOrFail($id);
            $user->update($request->all());
            return response()->json($user,200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function deleteById(Request $request, $id){
        if($request->isJson()){
            $user = User::findOrFail($id);
            $user->update(['fk_user_status' => 1]);
            return response('Delete Successfully', 200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function getToken(Request $request){
        if ($request->isJson()) {
            try {
                $data = $request->json()->all();

                $user = User::where('email', $data['email'])->first();

                if ($user && Hash::check($data['password'], $user->password)){
                    return response()->json(['user' => $user],200);
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
