<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class UserHomePageController extends Controller
{


    public function Homepage(Request $request){
        $user = $request->user();
        $categories = Category::all();
        $products = Product::all();
        $data =[
            'user_name'=>$user->first_name.' '.$user->last_name,
            'categories' => $categories,
            'products' => $products
        ];
        return response()->json($data);
    }

    
}
