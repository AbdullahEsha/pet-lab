<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ParticipantController extends Controller
{
    public function getAllParticipants(){
        $participants = Participant::all();
        $count = $participants->count();

        // If perams count=true then return only count of participants
        if (request()->count) {
            return response()->json([
                'message' => 'Participants count retrieved successfully',
                'count' => $count
            ]);
        }
        return response()->json([
            'message' => 'Participants retrieved successfully',
            'count' => $participants,
            'payments' => $count
        ]);
    }
}
