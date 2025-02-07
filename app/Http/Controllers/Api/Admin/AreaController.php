<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Area;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AreaController extends Controller
{
    protected $updateArea=['name','city_id'];

    public function getAreas(){
        $areas = Area::all();
        $data =[
            'areas' => $areas
        ];
        return response()->json($data);
    }

    public function addArea(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
            'city_id' => 'required',
        ]);
        if($validation->fails()){
            return response()->json([
                'message' => 'Validation errors',
                'data' => $validation->errors()
            ],400);
        }
        $area = Area::create([
            'name' => $request->name,
            'city_id' => $request->city_id,
        ]);
        $data =[
            'area' => $area
        ];
        return response()->json($data);
    }

    public function updateArea(Request $request,$id){
        $area =Area::find($id);
        $area->update($request->only($this->updateArea));
        $data =[
            'message' => 'Area updated successfully',
            'area' => $area
        ];
        return response()->json($data);
    }

    public function deleteArea($id){
        $area = Area::find($id);
        $area->delete();
        return response()->json([
            'message' => 'Area deleted successfully'
        ]);
    }
}
