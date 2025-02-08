<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubCategory;
use App\trait\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    use Image;
    protected $updateSubCategory = ['name','image','category_id'];

    public function getSubCategories(){
        $subCategories = SubCategory::all();
        foreach ($subCategories as $subCategory){
            if($subCategory->image){
                $subCategory->image = url('storage/'.$subCategory->image);
            }
        }
        $data =[
            'subCategories' => $subCategories
        ];
        return response()->json($data);
    }

    public function addSubCategory(Request $request){
        $validation = Validator::make($request->all(), [
            'category_id' => 'required|exists:categories,id',
            'name' => 'required',
            'image' => 'nullable',
        ]);
        if($validation->fails()){
            return response()->json([
                'message' => 'Validation errors',
                'data' => $validation->errors()
            ],400);
        }
        if($request->has('image')) {
            $imagepath = $this->storeBase64Image($request->image, 'admin/subCategory');
            $request->merge(['image' => $imagepath]);
        }
        $subCategory = SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'image' => $request->image,
        ]);
        $data =[
            'message' => 'SubCategory created successfully',
            'subCategory' => $subCategory
        ];
        return response()->json($data);
    }

    public function updateSubCategory(Request $request,$id){
        $subCategory =SubCategory::find($id);
        $subCategory->update($request->only($this->updateSubCategory));
        $data =[
            'message' => 'SubCategory updated successfully',
            'subCategory' => $subCategory
        ];
        return response()->json($data);
    }

    public function deleteSubCategory($id){
        $subCategory = SubCategory::find($id);
        $subCategory->delete();
        return response()->json([
            'message' => 'SubCategory deleted successfully'
        ]);
    }

}
