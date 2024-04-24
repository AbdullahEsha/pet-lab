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
        $management = Management::create($request->all());

        return response()->json([
            'message' => 'Management created successfully',
            'management' => $management
        ]);
    }

    // update management by id
    public function updateManagement(Request $request, $id)
    {
        $management = Management::find($id);

        if (!$management) {
            return response()->json([
                'message' => 'Management not found'
            ], 404);
        }

        $management->update($request->all());

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
