<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function getProducts(){
        $products = Product::with(['category','subCategory','user','productImages'])->get();
        foreach ($products as $product){
            foreach ($product->productImages as $productImage){
                $productImage->image = url('storage/'.$productImage->image);
            }
        }
        $data = $products->map(function ($product) {
            return [
                'id' => $product->id,
                'product_name' => $product->name,
                'product_description' => $product->description,
                'product_price' => $product->price,
                'product_quantity' => $product->quantity,
                'product_location' => $product->location,
                'product_status' => $product->status,
                'product_size' => $product->size,
                'product_submission_date' => $product->created_at,
                'category'=>[
                    'id'=>$product->category->id,
                    'category_name'=>$product->category->name,
                ],
                'subCategory'=>[
                    'id'=>$product->subCategory->id,
                    'subCategory_name'=>$product->subCategory->name,
                ],
                'user'=>[
                    'id'=>$product->user->id,
                    'user_name'=>$product->user->first_name.' '.$product->user->last_name,
                ],
                'productImages'=>[
                    'images'=>$product->productImages
                ]

            ];
        });
        return response()->json(['prodcusts'=>$data]);
    }

    
}
