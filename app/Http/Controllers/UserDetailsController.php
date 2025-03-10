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
        // paginated with variable page size from parameter or default 10
        // user table id is the foreign key in user_details table as user_id
        $userDetails = UserDetails::with('user')->paginate(request('per_page', 10));

        // json decode bird_species_collection and partners_details
        foreach ($userDetails as $userDetail) {
            $userDetail->bird_species_collection = json_decode($userDetail->bird_species_collection);
            $userDetail->partners_details = json_decode($userDetail->partners_details);
        }

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

        // json decode bird_species_collection and partners_details
        $userDetails->bird_species_collection = json_decode($userDetails->bird_species_collection);
        $userDetails->partners_details = json_decode($userDetails->partners_details);

        return response()->json([
            'message' => 'User details retrieved successfully',
            'userDetails' => $userDetails
        ]);
    }

    // create user details with user_id as foreign key
    public function createUserDetails(Request $request)
    {
        try {
            $createUserDetails = $request->all();

            // if $request->user_id is not found in user table then return error
            if (!$request->user_id) {
                return response()->json([
                    'message' => 'User not found. Please provide a valid user_id.'
                ], 404);
            }

            // json encode bird_species_collection and partners_details
            $createUserDetails['bird_species_collection'] = json_encode($request->bird_species_collection);
            $createUserDetails['partners_details'] = json_encode($request->partners_details);

            // create user details
            $userDetails = UserDetails::create($createUserDetails);

            return response()->json([
                'message' => 'User details created successfully',
                'userDetails' => $userDetails
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'User details not created. Please provide all required fields.',
                'error' => $e->getMessage()
            ], 400);
        }
    }

    // update user details by user_id
    public function updateUserDetails(Request $request, $user_id)
    {
        $updateUserDetails = $request->all();
        // get user details by user_id
        $userDetails = UserDetails::where('user_id', $user_id)->first();

        if (!$userDetails) {
            return response()->json([
                'message' => 'User details not found'
            ], 404);
        }

        // update user details
        $userDetails->update($updateUserDetails);

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
