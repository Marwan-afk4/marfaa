<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\trait\Image;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use Image;

    public function getCtegories(){
        $categories = Category::all();
        $data =[
            'categories' => $categories
        ];
        return response()->json($data);
    }

    public function getSubCategory(){
        $subcategory = SubCategory::all();
        $data =[
            'subcategory' => $subcategory
        ];
        return response()->json($data);
    }

    public function addProduct(Request $request,ProductRequest $productRequest){
        $seller = $request->user();
        $validationProduct = $productRequest->validated();
        $product = Product::create([
            'user_id'=>$seller->id,
            'category_id'=>$validationProduct['category_id'],
            'sub_category_id'=>$validationProduct['subCategory_id'],
            'name'=>$validationProduct['name'],
            'description'=>$validationProduct['description'],
            'price'=>$validationProduct['price'],
            'location'=>$validationProduct['location'],
            'quantity'=>$validationProduct['quantity'],
            'product_quality'=>$validationProduct['product_quality']??'مستعمل',
            'type'=>$validationProduct['type'],
            'size'=>$validationProduct['size']??null,
            'color'=>$validationProduct['color']??null,
            'state'=>'active'
        ]);
        if($request->has('images')) {
            foreach ($request->images as $image) {
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $this->storeBase64Image($image, 'admin/products'),
                ]);
            }
        }
        $data =[
            'message' => 'Product added successfully',
            'product' => $product
        ];
        return response()->json($data);
    }

    public function getSellerProducts(Request $request){
        $seller = $request->user();
        $sellerProducts = Product::where('user_id',$seller->id)
        ->with(['category','subCategory','productImages'])
        ->get();
        foreach ($sellerProducts as $product){
            foreach ($product->productImages as $productImage){
                $productImage->image = url('storage/'.$productImage->image);
            }
        }
        $data = $sellerProducts->map(function ($product) {
            return [
                'seller_id' => $product->user_id,
                'seller_name'=>$product->user->first_name.' '.$product->user->last_name,
                'product_id' => $product->id,
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
                'productImages'=>[
                    'images'=>$product->productImages
                ]
            ];
        });
        return response()->json(['sellerProducts'=>$data]);
    }
}
