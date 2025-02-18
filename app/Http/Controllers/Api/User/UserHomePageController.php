<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class UserHomePageController extends Controller
{


    public function Homepage(Request $request){
        $user = $request->user();
        $categories = Category::all();
        $products = Product::where('state','active')
        ->with('productImages')->get()->map(function ($product) {
            return [
                'product_id' => $product->id,
                'category_id' => $product->category_id,
                'category_name' => $product->category->name,
                'sub_category_id' => $product->sub_category_id,
                'sub_category_name' => $product->subCategory->name,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'location' => $product->location,
                'size' => $product->size,
                'color' => $product->color,
                'quantity' => $product->quantity,
                'product_quality' => $product->product_quality,
                'product_status' => $product->status,
                'type' => $product->type,
                'images' => $product->productImages->map(function ($image) {
                    return [
                        'image' =>asset('storage/' . $image->image),
                    ];
                }),
            ];
        });
        foreach($categories as $category){
            if($category->image){
                $category->image = asset('storage/'.$category->image);
            }
        }
        $data =[
            'user_name'=>$user->first_name.' '.$user->last_name,
            'categories' => $categories,
            'products' => $products
        ];
        return response()->json($data);
    }

    public function getCtegories(){
        $categories = Category::all();
        foreach($categories as $category){
            if($category->image){
                $category->image = asset('storage/'.$category->image);
            }
        }
        $data =[
            'categories' => $categories
        ];
        return response()->json($data);
    }

    public function getSubCategory(){
        $subcategory = SubCategory::all();
        foreach($subcategory as $subCategory){
            if($subCategory->image){
                $subCategory->image = asset('storage/'.$subCategory->image);
            }
        }
        $data =[
            'subcategory' => $subcategory
        ];
        return response()->json($data);
    }

    public function addFavourite($product_id){
        $product = Product::find($product_id);
        $product->favourite = 1;
        $product->save();
        $data =[
            'message' => 'Product added to favourite successfully'
        ];
        return response()->json($data);
    }

    public function getFavourite(){
        $products = Product::where('favourite',1)
        ->with(['category','subCategory','productImages'])
        ->get();
        $data =[
            'products' => $products
        ];
        return response()->json($data);
    }

    public function getProductrs(){
        $products = Product::with(['category:id,name','subCategory:id,name','productImages'])
        ->where('state','active')
        ->get();

        foreach ($products as $product){
            foreach ($product->productImages as $productImage){
                $productImage->image = asset('storage/'.$productImage->image);
            }
        }
        $data =[
            'products' => $products
        ];
        return response()->json($data);
    }
}

