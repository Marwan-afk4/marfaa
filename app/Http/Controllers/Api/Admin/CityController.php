<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CityController extends Controller
{
    protected $updateCity = ['name'];

    public function getCities(){
        $cities = City::all();
        $data =[
            'cities' => $cities
        ];
        return response()->json($data);
    }

    public function addCity(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if($validation->fails()){
            return response()->json([
                'message' => 'Validation errors',
                'data' => $validation->errors()
            ],400);
        }
        $city = City::create([
            'name' => $request->name,
        ]);
        $data =[
            'city' => $city
        ];
        return response()->json($data);
    }

    public function deleteCity($id){
        $city = City::find($id);
        $city->delete();
        return response()->json([
            'message' => 'City deleted successfully'
        ]);
    }

    public function updateCity(Request $request,$id){
        $city =City::find($id);
        $city->update($request->only($this->updateCity));
        $data =[
            'message' => 'City updated successfully',
            'city' => $city
        ];
        return response()->json($data);
    }
}
