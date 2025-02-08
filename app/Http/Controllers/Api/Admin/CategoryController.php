<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\trait\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    use Image;
    protected $updateCategory = ['name','image'];

    public function getCategories(){
        $categories = Category::all();
        foreach ($categories as $category){
            if($category->image){
                $category->image = url('storage/'.$category->image);
            }
        }
        $data =[
            'categories' => $categories
        ];
        return response()->json($data);
    }

    public function addCategory(Request $request){
        $validation = Validator::make($request->all(), [
            'name' => 'required|unique:categories,name',
            'image' => 'required',
        ]);
        if($validation->fails()){
            return response()->json([
                'message' => 'Validation errors',
                'data' => $validation->errors()
            ],400);
        }
        if($request->has('image')) {
            $imagepath = $this->storeBase64Image($request->image, 'admin/category');
            $request->merge(['image' => $imagepath]);
        }
        $category = Category::create([
            'name' => $request->name,
            'image' => $request->image,
        ]);
        $data =[
            'message' => 'Category created successfully',
            'category' => $category
        ];
        return response()->json($data);
    }

    public function updateCategory(Request $request,$id){
        $category =Category::find($id);
        $category->update($request->only($this->updateCategory));
        $data =[
            'message' => 'Category updated successfully',
            'category' => $category
        ];
        return response()->json($data);
    }

    public function deleteCategory($id){
        $category = Category::find($id);
        $category->delete();
        return response()->json([
            'message' => 'Category deleted successfully'
        ]);
    }
}
