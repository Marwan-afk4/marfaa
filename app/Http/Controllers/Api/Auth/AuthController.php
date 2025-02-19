<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\TestProduct;
use App\Models\User;
use App\Models\UserIdentity;
use App\trait\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    use Image;

    public function register(RegisterRequest $request){
        $validationsignup = $request->validated();

        if($validationsignup['role'] == 'seller'){
            $validationsignup['status'] = 'pending';
            $validationsignup['role'] = 'seller';
        }elseif($validationsignup['role'] == 'user'){
            $validationsignup['role'] = 'user';
            $validationsignup['status'] = 'accepted';
        }
        $user = User::create([
            'city_id' => $validationsignup['city_id']??null,
            'area_id' => $validationsignup['area_id']??null,
            'first_name' => $validationsignup['first_name'],
            'last_name' => $validationsignup['last_name'],
            'email' => $validationsignup['email'],
            'password' => $validationsignup['password'] = Hash::make($validationsignup['password']),
            'phone' => $validationsignup['phone']??null,
            'gender' => $validationsignup['gender']??null,
            'age' => $validationsignup['age']??null,
            'full_address' => $validationsignup['full_address']??null,
            'floor_number' => $validationsignup['floor_number']??null,
            'apartment_number' => $validationsignup['apartment_number']??null,
            'role' => $validationsignup['role'],
            'status' => $validationsignup['status'],
        ]);
        if($request->has('test_products')) {
            foreach ($request->test_products as $test_product) {
                TestProduct::create([
                    'user_id' => $user->id,
                    'name' => $test_product['name'],
                    'image' => $this->storeBase64Image($test_product['image'], 'admin/testProducts'),
                ]);
            }
        }

        if($request->has('identify_image')) {
            foreach ($request->identify_image as $identify_image) {
                UserIdentity::create([
                    'user_id' => $user->id,
                    'identify_image' => $this->storeBase64Image($identify_image['image'], 'admin/identifyImages'),
                ]);
            }
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'User created successfully',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function login(Request $request){
        $validation = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if($validation->fails()){
            return response()->json([
                'message' => 'Validation errors',
                'data' => $validation->errors()
            ],400);
        }
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid credentials , password incorrect'
            ],401);
        }
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
{
    $user = $request->user();

    if (!$user) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 401);
    }

    $user->currentAccessToken()->delete();

    return response()->json([
        'message' => 'Logout successful'
    ]);
}

    public function deleteAccount(Request $request){
        $user = $request->user();
        $user->delete();
        return response()->json([
            'message' => 'Account deleted successfully'
        ]);
    }

}
