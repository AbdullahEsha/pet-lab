<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Models\User;
use App\Models\UserDetails;

class UserController extends Controller
{
    // get all users
    public function getAllUsers()
    {
        $users = User::all();
        $usersCount = $users->count();

        // if perams count=true then return only count of users
        if (request()->count) {
            return response()->json([
                'message' => 'Users count retrieved successfully',
                'usersCount' => $usersCount
            ]);
        }

        return response()->json([
            'message' => 'Users retrieved successfully',
            'usersCount' => $usersCount,
            'users' => $users
        ]);
    }

    // get user by id
    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User retrieved successfully',
            'user' => $user
        ]);
    }

    // create user
    public function createUser(Request $request)
    {
        $createUser = $request->all();
        // upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/users'), $imageName);
            $createUser['image'] = 'images/users/' . $imageName;
        }

        // hash password
        $request->password = Hash::make($request->password);

        // create user
        $user = User::create($createUser);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    // update user
    public function updateUser(Request $request, $id)
    {
        $updateUser = $request->all();
        $user = User::find($id);

        // if image is updated
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/users'), $imageName);
            $updateUser['image'] = 'images/users/' . $imageName;
        }

        // and delete the old image
        if (file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // can not update subExpDate
        if ($request->subExpDate && Auth::user()->id != $user->id){
            // authencate user 
                return response()->json([
                    'message' => 'You can not update subExpDate of other users'
                ], 400);
            
        }

        // password hash if password is updated
        // one user can not update password of other users even if he is admin
        if ($request->password) {
            if (Auth::user()->id != $user->id) {
                return response()->json([
                    'message' => 'You can not update password of other users'
                ], 400);
            }
            $updateUser['password'] = Hash::make($request->password);
        }
        
        $user->update($updateUser);

        return response()->json([
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    // delete user
    public function deleteUser($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // delete old image
        if (file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }

        $user->delete();

        // also delete user details if exists for this user
        $userDetails = UserDetails::where('user_id', $id)->first();
        if ($userDetails) {
            $userDetails->delete();
        }

        return response()->json([
            'message' => 'User deleted successfully'
        ]);
    }

    // update subExpDate by id
    public function updateSubExpDate(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        // add 1 year to subExpDate
        $user->subExpDate = date('Y-m-d', strtotime('+1 year', strtotime($user->subExpDate)));

        $user->save();

        return response()->json([
            'message' => 'User subExpDate updated successfully',
            'user' => $user
        ]);
    }
}
