<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomepageController extends Controller
{


    public function HomePage(){
        $completedOrder = 0; //lsa el order bardo
        $inprogressOrder = 0; //lsa el order
        $pendingSeller = User::where('status','pending')
        ->where('role','seller')
        ->count();

        $pendingSellers = User::where('status','pending')
        ->where('role','seller')
        ->get();

        $activeProducts = Product::where('state','active')->get();

        $data =[
            'completedOrderCount' => $completedOrder,
            'inprogressOrderCount' => $inprogressOrder,
            'pendingSellerCount' => $pendingSeller,
            'pendingSellers' => $pendingSellers,
            'activeProducts' => $activeProducts
        ];
        return response()->json($data);
    }
}
