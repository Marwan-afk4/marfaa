<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\trait\Image;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use Image;
    protected $updateUser = ['city_id', 'area_id', 'first_name', 'last_name', 'phone', 'gender', 'age', 'full_address','identify_image'];

    public function getUsers()
{
    $acceptedUsers = User::where('status', 'accepted')
        ->where('role', 'seller')
        ->with('testproducts')
        ->get();

    $otherStatuses = ['pending', 'rejected', 'suspended'];
    $users = [];

    foreach ($otherStatuses as $status) {
        $users[$status] = User::where('status', $status)
            ->where('role', 'user')
            ->with('testproducts')
            ->get();
    }

    foreach ($acceptedUsers as $user) {
        foreach ($user->testproducts as $testproduct) {
            if ($testproduct->image) {
                $testproduct->image = url('storage/' . $testproduct->image);
            }
        }
    }

    foreach ($users as $status => $userList) {
        foreach ($userList as $user) {
            foreach ($user->testproducts as $testproduct) {
                if ($testproduct->image) {
                    $testproduct->image = url('storage/' . $testproduct->image);
                }
            }
        }
    }

    foreach ($acceptedUsers as $user) {
        if ($user->image) {
            $user->image = url('storage/' . $user->image);
        }
    }

    foreach ($users as $status => $userList) {
        foreach ($userList as $user) {
            if ($user->image) {
                $user->image = url('storage/' . $user->image);
            }
        }
    }

    return response()->json([
        'accepted' => $acceptedUsers,
        'pending' => $users['pending'],
        'rejected' => $users['rejected'],
        'suspended' => $users['suspended'],
    ]);
}

    public function updateUser(Request $request, $id){
        $user = User::find($id);
        $user->update($request->only($this->updateUser));
        $data =[
            'message' => 'User updated successfully',
            'user' => $user
        ];
        return response()->json($data);
    }

    public function acceptUser($id){
        $user = User::find($id);
        $user->status = 'accepted';
        $user->role = 'seller';
        $user->save();
        return response()->json([
            'message' => 'User accepted successfully'
        ]);
    }

    public function rejectUser($id){
        $user = User::find($id);
        $user->status = 'rejected';
        $user->role = 'user';
        $user->save();
        return response()->json([
            'message' => 'User rejected successfully'
        ]);
    }

    public function suspendUser($id){
        $user = User::find($id);
        $user->status = 'suspended';
        $user->role = 'user';
        $user->save();
        return response()->json([
            'message' => 'User suspended successfully'
        ]);
    }

}
