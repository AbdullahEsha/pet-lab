<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PositionController extends Controller
{
    // get all positions
    public function getAllPositions()
    {
        $positions = Position::all();
        $positionsCount = $positions->count();
        
        return response()->json([
            'message' => 'Positions retrieved successfully',
            'count' => $positionsCount,
            'positions' => $positions
        ]);
    }

    // get position by id   
    public function getPositionById($id)
    {
        $position = Position::find($id);

        if (!$position) {
            return response()->json([
                'message' => 'Position not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Position retrieved successfully',
            'position' => $position
        ]);
    }

    // create position
    public function createPosition(Request $request)
    {
        $position = Position::create($request->all());

        return response()->json([
            'message' => 'Position created successfully',
            'position' => $position
        ]);
    }

    // update position by id
    public function updatePosition(Request $request, $id)
    {
        $position = Position::find($id);

        if (!$position) {
            return response()->json([
                'message' => 'Position not found'
            ], 404);
        }

        $position->update($request->all());

        return response()->json([
            'message' => 'Position updated successfully',
            'position' => $position
        ]);
    }

    // delete position by id
    public function deletePosition($id)
    {
        $position = Position::find($id);

        if (!$position) {
            return response()->json([
                'message' => 'Position not found'
            ], 404);
        }

        $position->delete();

        return response()->json([
            'message' => 'Position deleted successfully'
        ]);
    }
}
