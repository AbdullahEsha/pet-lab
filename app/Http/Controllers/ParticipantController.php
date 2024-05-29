<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;

// - id: int
// - name: string
// - address: string
// - image: string
// - t shirt size: string
// - data: json
// - event id: string
// - isApproved: string

class ParticipantController extends Controller
{
    // get all participants
    public function getAllParticipants()
    {
        $participants = Participant::all();
        $participantscount = $participants->count();

        // decode data from json
        foreach ($participants as $participant) {
            $participant->data = json_decode($participant->data);
        }

        // If perams count=true then return only count of participants
        if (request()->count) {
            return response()->json([
                'message' => 'Participants count retrieved successfully',
                'count' => $participantscount
            ]);
        }

        return response()->json([
            'message' => 'Participants retrieved successfully',
            'count' => $participantscount,
            'participants' => $participants
        ]);
    }

    // get participant by id
    public function getParticipantById($id)
    {
        $participant = Participant::find($id);

        // decode data from json
        $participant->data = json_decode($participant->data);

        if (!$participant) {
            return response()->json([
                'message' => 'Participant not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Participant retrieved successfully',
            'participant' => $participant
        ]);
    }

    // create participant
    public function createParticipant(Request $request)
    {
        $createParticipant = $request->all();

        // if it has image file name image then store it in storage
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move('images/participants', $filename);
            $createParticipant['image'] = 'images/participants/' . $filename;
        }

        // encode data to json
        $createParticipant['data'] = json_encode($createParticipant['data']);

        $participant = Participant::create($createParticipant);

        return response()->json([
            'message' => 'Participant created successfully',
            'participant' => $participant
        ]);
    }

    // update participant by id
    public function updateParticipant(Request $request, $id)
    {
        $updateParticipant = $request->all();
        // get participant by id
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json([
                'message' => 'Participant not found'
            ], 404);
        }

        // if it has image file name image then store it in storage
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $file->move('images/participants', $filename);
            $updateParticipant['image'] = 'images/participants/' . $filename;
        }

        // delete old image if new image is uploaded
        if ($request->hasFile('image')) {
            if (file_exists(public_path("images/participants/{$participant->image}"))) {
                unlink(public_path("images/participants/{$participant->image}"));
            }
        }

        // update participant
        $participant->update($updateParticipant);

        return response()->json([
            'message' => 'Participant updated successfully',
            'participant' => $participant
        ]);
    }

    // delete participant by id
    public function deleteParticipant($id)
    {
        $participant = Participant::find($id);

        if (!$participant) {
            return response()->json([
                'message' => 'Participant not found'
            ], 404);
        }

        // delete image
        if (file_exists(public_path("images/participants/{$participant->image}"))) {
            unlink(public_path("images/participants/{$participant->image}"));
        }

        $participant->delete();

        return response()->json([
            'message' => 'Participant deleted successfully'
        ]);
    }
}
