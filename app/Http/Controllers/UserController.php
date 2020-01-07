<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Users;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function insert(Request $request){
        $user = Users::create($request->all());
        return response()->json($user,201);
    }
    public function getUsers(){
        return response()->json(Users::all());
    }
    public function getUserById($id){
        return response()->json(Users::find($id));
    }
    public function updateById($id, Request $request){
        $user = Users::findOrFail($id);
        $user->update($request->all());
        return response()->json($user,200);
    }
    public function deleteById($id){
        Users::findOrFail($id)->delete();
        return response('Delete Successfully', 200);
    }
}
