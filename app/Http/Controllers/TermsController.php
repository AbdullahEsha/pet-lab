<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Terms;

class TermsController extends Controller
{
    public function getAllTerms()
    {
        $terms = Terms::all();
        $termsCount = $terms->count();

        if (request()->count) {
            return response()->json([
                'message' => 'Terms count retrieved successfully',
                'count' => $termsCount
            ]);
        }

        return response()->json([
            'message' => 'Terms retrieved successfully',
            'count' => $termsCount,
            'terms' => $terms
        ]);
    }

    public function getTermById($id)
    {
        $term = Terms::find($id);

        if (!$term) {
            return response()->json([
                'message' => 'Term not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Term retrieved successfully',
            'term' => $term
        ]);
    }

    public function createTerm(Request $request)
    {
        $term = Terms::create($request->all());

        return response()->json([
            'message' => 'Term created successfully',
            'term' => $term
        ]);
    }

    public function updateTerm(Request $request, $id)
    {
        $term = Terms::find($id);

        if (!$term) {
            return response()->json([
                'message' => 'Term not found'
            ], 404);
        }

        $term->update($request->all());

        return response()->json([
            'message' => 'Term updated successfully',
            'term' => $term
        ]);
    }

    public function deleteTerm($id)
    {
        $term = Terms::find($id);

        if (!$term) {
            return response()->json([
                'message' => 'Term not found'
            ], 404);
        }

        $term->delete();

        return response()->json([
            'message' => 'Term deleted successfully'
        ]);
    }
}
