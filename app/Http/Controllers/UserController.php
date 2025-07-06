<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
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

        // if params count=true then return only count of users
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

        if ($request->hasFile('nid_or_passport_image')) {
            $file = $request->file('nid_or_passport_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/nid_or_passport'), $fileName);
            $createUser['nid_or_passport_image'] = 'images/nid_or_passport/' . $fileName;
        }

        if ($request->hasFile('nid_or_passport_image_back')) {
            $file = $request->file('nid_or_passport_image_back');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/nid_or_passport'), $fileName);
            $createUser['nid_or_passport_image_back'] = 'images/nid_or_passport/' . $fileName;
        }

        // hash password
        if (isset($createUser['password'])) {
            $createUser['password'] = Hash::make($createUser['password']);
        }

        // create user
        $user = User::create($createUser);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function updateUser(Request $request, $id)
    {
        $updateData = $request->all();
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'message' => 'User not found'
            ], 404);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/users'), $imageName);
            $updateData['image'] = 'images/users/' . $imageName;
        }

        if ($request->hasFile('nid_or_passport_image')) {
            $file = $request->file('nid_or_passport_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/nid_or_passport'), $fileName);
            $updateData['nid_or_passport_image'] = 'images/nid_or_passport/' . $fileName;
        }

        if ($request->hasFile('nid_or_passport_image_back')) {
            $file = $request->file('nid_or_passport_image_back');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/nid_or_passport'), $fileName);
            $updateData['nid_or_passport_image_back'] = 'images/nid_or_passport/' . $fileName;
        }

        // hash password
        if (isset($updateData['password'])) {
            $updateData['password'] = Hash::make($updateData['password']);
        }

        // Update user data
        $user->fill($updateData);
        $user->save();

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
