<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductImage;
use App\trait\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use Image;

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

    public function addProduct(ProductRequest $request){
        $user = $request->user();
        $validationProduct = $request->validated();
        $product = Product::create([
            'user_id'=>$user->id,
            'category_id'=>$validationProduct['category_id'],
            'sub_category_id'=>$validationProduct['subCategory_id'],
            'name'=>$validationProduct['name'],
            'description'=>$validationProduct['description'],
            'price'=>$validationProduct['price'],
            'location'=>$validationProduct['location'],
            'quantity'=>$validationProduct['quantity'],
            'product_quality'=>$validationProduct['product_quality'],
            'type'=>$validationProduct['type'],
            'size'=>$validationProduct['size']??null,
            'color'=>$validationProduct['color']??null
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
            'message' => 'Product created successfully',
            'product' => $product
        ];
        return response()->json($data);
    }

    public function deleteProduct(Request $request,$id){
        $product = Product::find($id);
        $validaition = Validator::make($request->all(), [
            'delete_reason'=>'required'
        ]);
        if($validaition->fails()){
            return response()->json([
                'message' => 'Validation errors',
                'data' => $validaition->errors()
            ],400);
        }
        $product->update([
            'delete_reason'=>$request->delete_reason,
            'state'=>'unactive'
        ]);
        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }

    public function updateProduct(ProductRequest $request, $id){
        $validationProduct = $request->validated();
        $product = Product::find($id);
        $product->update([
            'user_id'=>$validationProduct['user_id']??$product->user_id,
            'category_id'=>$validationProduct['category_id']??$product->category_id,
            'sub_category_id'=>$validationProduct['subCategory_id']??$product->sub_category_id,
            'name'=>$validationProduct['name']??$product->name,
            'description'=>$validationProduct['description']??$product->description,
            'price'=>$validationProduct['price']??$product->price,
            'location'=>$validationProduct['location']??$product->location,
            'product_quality'=>$validationProduct['product_quality']??$product->product_quality,
            'quantity'=>$validationProduct['quantity']??$product->quantity,
            'type'=>$validationProduct['type']??$product->type,
            'size'=>$validationProduct['size']??$product->size,
            'color'=>$validationProduct['color']??$product->color
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
            'message' => 'Product updated successfully',
            'product' => $product
        ];
        return response()->json($data);
    }



}
