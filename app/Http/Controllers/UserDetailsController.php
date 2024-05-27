<?php

namespace App\Http\Controllers;

use App\Models\UserDetails;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserDetailsController extends Controller
{
    // get all user with user details with count and pagination. user_id is the foreign key in user_details table
    public function getAllUserDetails()
    {
        // get all user and user details
        // paginated with variable page size from perameter or default 10
        // user table id is the foreign key in user_details table as user_id
        $userDetails = UserDetails::with('user')->paginate(request('per_page', 10));

        return response()->json([
            'message' => 'User details retrieved successfully',
            'userDetails' => $userDetails
        ]);
    }

    // get user details by user_id
    public function getUserDetailsByUserId($user_id)
    {
        // get all user and user details by user_id
        $userDetails = UserDetails::with('user')->where('user_id', $user_id)->first();

        if (!$userDetails) {
            return response()->json([
                'message' => 'User details not found'
            ], 404);
        }

        return response()->json([
            'message' => 'User details retrieved successfully',
            'userDetails' => $userDetails
        ]);
    }

    // create user details with user_id as foreign key
    public function createUserDetails(Request $request)
    {
        $createUserDetails = $request->all();
        // if it has image file name nid_or_passport_image then store it in storage
        if ($request->hasFile('nid_or_passport_image')) {
            $file = $request->file('nid_or_passport_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/nid_or_passport'), $fileName);
            $createUserDetails['nid_or_passport_image'] = 'images/nid_or_passport/' . $fileName;
        }

        if($request->hasFile('nid_or_passport_image_back')) {
            $file = $request->file('nid_or_passport_image_back');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('images/nid_or_passport'), $fileName);
            $createUserDetails['nid_or_passport_image_back'] = 'images/nid_or_passport/' . $fileName;
        }

        // validate request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'father_name' => 'required',
            'mother_name' => 'required',
            'date_of_birth' => 'required',
            'blood_type' => 'required',
            'gender' => 'required',
            'nid_or_passport_image' => 'required',
            'nid_or_passport_image_back' => 'required',
            'aviary_have_any_partner' => 'required',
            'isApproved' => 'required',
        ]);

        // if $request->user_id is not found in user table then return error
        if(!$request->user_id) {
            return response()->json([
                'message' => 'User not found. Please provide a valid user_id.'
            ], 404);
        }

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 400);
        }

        // create user details
        $userDetails = UserDetails::create($request->all());

        return response()->json([
            'message' => 'User details created successfully',
            'userDetails' => $userDetails
        ]);
    }

    // update user details by user_id
    public function updateUserDetails(Request $request, $user_id)
    {
        // get user details by user_id
        $userDetails = UserDetails::where('user_id', $user_id)->first();

        if (!$userDetails) {
            return response()->json([
                'message' => 'User details not found'
            ], 404);
        }

        // if it has image file name nid_or_passport_image then store it in storage
        if ($request->hasFile('nid_or_passport_image')) {
            $file = $request->file('nid_or_passport_image');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/images', $fileName);
            $request->nid_or_passport_image = 'images/nid_or_passport_image/' . $fileName;
        }

        // update user details
        $userDetails->update($request->all());

        return response()->json([
            'message' => 'User details updated successfully',
            'userDetails' => $userDetails
        ]);
    }

    // delete user details by user_id
    public function deleteUserDetails($user_id)
    {
        // get user details by user_id
        $userDetails = UserDetails::where('user_id', $user_id)->first();

        if (!$userDetails) {
            return response()->json([
                'message' => 'User details not found'
            ], 404);
        }

        // delete user details
        $userDetails->delete();

        return response()->json([
            'message' => 'User details deleted successfully'
        ]);
    }
}
