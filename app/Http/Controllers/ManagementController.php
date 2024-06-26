<?php

namespace App\Http\Controllers;

use App\Models\Management;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ManagementController extends Controller
{
    // get all managements
    public function getAllManagements()
    {
        $managements = Management::all();
        $managementsCount = $managements->count();

        // if perams count=true then return only count of managements
        if (request()->count) {
            return response()->json([
                'message' => 'Managements count retrieved successfully',
                'count' => $managementsCount
            ]);
        }
        
        return response()->json([
            'message' => 'Managements retrieved successfully',
            'count' => $managementsCount,
            'managements' => $managements
        ]);
    }

    // get management by id
    public function getManagementById($id)
    {
        $management = Management::find($id);

        if (!$management) {
            return response()->json([
                'message' => 'Management not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Management retrieved successfully',
            'management' => $management
        ]);
    }

    // create management
    public function createManagement(Request $request)
    {
        $createManagement = $request->all();
        // if image has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/management'), $imageName);
            $createManagement['image'] = 'images/management/' . $imageName;
        }

        $management = Management::create($createManagement);

        return response()->json([
            'message' => 'Management created successfully',
            'management' => $management
        ]);
    }

    // update management by id
    public function updateManagement(Request $request, $id)
    {
        $updateManagement = $request->all();
        $management = Management::find($id);

        // if image has file then upload it
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/management'), $imageName);
            $updateManagement['image'] = 'images/management/' . $imageName;
        }

        // also delete the old image
        if (file_exists(public_path($management->image))) {
            unlink(public_path($management->image));
        }

        if (!$management) {
            return response()->json([
                'message' => 'Management not found'
            ], 404);
        }

        $management->update($updateManagement);

        return response()->json([
            'message' => 'Management updated successfully',
            'management' => $management
        ]);
    }

    // delete management by id
    public function deleteManagement($id)
    {
        $management = Management::find($id);

        if (!$management) {
            return response()->json([
                'message' => 'Management not found'
            ], 404);
        }

        $management->delete();

        return response()->json([
            'message' => 'Management deleted successfully'
        ]);
    }
}
