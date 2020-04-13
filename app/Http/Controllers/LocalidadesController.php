<?php


namespace App\Http\Controllers;


use App\Imports\LocalidadesImport;
use App\Imports\MunicipalitiesImport;
use App\Imports\StatesImport;
use App\Localities;
use App\Municipalities;
use App\States;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LocalidadesController extends Controller
{
    public function importLocalidades(Request $request){
        $municipios = Municipalities::all();
        if($municipios->isEmpty()){
            return response()->json(['error' => 'Primero Carge el calogo de Municipios'],400);
        }
        Excel::import(new LocalidadesImport(), $request->file('localidades'));
        return response()->json('Successfully',200);
    }

    public function importMunicipios(Request $request){
        $states = States::all();
        if($states->isEmpty()){
            return response()->json(['error' => 'Primero Carge el calogo de Estados'],400);
        }
        Excel::import(new MunicipalitiesImport(),  $request->file('municipios'));
        return response()->json(['Status' =>'Successfully'],200);


    }

    public function importEstados(Request $request){
            Excel::import(new StatesImport(),  $request->file('estados'));
            return response()->json(['Status' =>'Successfully'],200);
    }

    public function getStates(Request $request){
        if($request->isJson()) {
           return response()->json(['estados' => States::all()],200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function getMunicipalitiesById(Request $request, $id){
        if($request->isJson()) {
            return response()->json([
                'Municipios' => Municipalities::orderBy('name')
                    ->where('fk_states', $id)
                    ->get()
            ],200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }

    public function getLocalitiesByCP(Request $request, $id){
        if($request->isJson()) {
            return response()->json([
                'localities' => DB::table('localities')
                    ->join('municipalities','localities.fk_municipalities','=','municipalities.id')
                    ->join('states','municipalities.fk_states','=','states.id')
                    ->where('localities.zip_code', $id)
                    ->select( 'localities.id as id','localities.name as locality','localities.zip_code','municipalities.name as municipality', 'states.name as state')
                    ->orderBy('localities.name')
                    ->get()
            ],200);
        }
        return response()->json(['error' => 'Unauthorized'],'401');
    }
}
