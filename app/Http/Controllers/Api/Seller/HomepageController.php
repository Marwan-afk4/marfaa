<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Models\Area;
use App\Models\City;
use Illuminate\Http\Request;

class HomepageController extends Controller
{


    public function getAreas(){
        $areas = Area::all();
        $data =[
            'areas' => $areas
        ];
        return response()->json($data);
    }

    public function getCities(){
        $cities = City::all();
        $data =[
            'cities' => $cities
        ];
        return response()->json($data);
    }

    public function Homepage(Request $request){
        $seller = $request->user();
        $sellerstatus = $seller->status;
        if($sellerstatus =='pending'){
            return response()->json(['message'=>'Your account is pending , wait the acception of the admin']);
        }
        elseif($sellerstatus == 'rejected'){
            return response()->json(['message'=>'Your account is rejected ']);
        }
        elseif($sellerstatus == 'accepted'){
            return response()->json([
                'message'=>'Your account is accepted',
                'seller_product' =>$seller->products
            ]);
        }
    }
}
