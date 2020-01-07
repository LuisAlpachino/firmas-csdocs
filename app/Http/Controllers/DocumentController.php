<?php


namespace App\Http\Controllers;

use App\Documents;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function insert(Request $request){
        $document = Documents::create($request->all());
        return response()->json($document,201);
    }

    public function getDocuments(){
        return response()->json(Documents::all());
    }

    public function getDocumentsById($id){
        return response()->json(Documents::find($id));
    }

    public function updateById($id, Request $request){
        $document = Documents::findOrFail($id);
        $document->update($request->all());
        return response()->json($document,200);
    }

    public function deleteById($id){
        Documents::findOrFail($id)->delete();
        return response('Delete Successfully',200);
    }
}
