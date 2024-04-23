<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    //Schema::create('galleries', function (Blueprint $table) {
    //    $table->id();
    //    $table->string('title');
    //    $table->json('image');
    //    $table->string('folder');
    //    $table->timestamps();
    //});
    
    // get all galleries
    public function getAllGalleries()
    {
        $galleries = Gallery::all();
        $galleriesCount = $galleries->count();
        
        return response()->json([
            'message' => 'Galleries retrieved successfully',
            'count' => $galleriesCount,
            'galleries' => $galleries
        ]);
    }

    // get gallery by id
    public function getGalleryById($id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'message' => 'Gallery not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Gallery retrieved successfully',
            'gallery' => $gallery
        ]);
    }

    // create gallery
    public function createGallery(Request $request)
    {
        $gallery = Gallery::create($request->all());

        return response()->json([
            'message' => 'Gallery created successfully',
            'gallery' => $gallery
        ]);
    }

    // update gallery by id
    public function updateGallery(Request $request, $id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'message' => 'Gallery not found'
            ], 404);
        }

        $gallery->update($request->all());

        return response()->json([
            'message' => 'Gallery updated successfully',
            'gallery' => $gallery
        ]);
    }

    // delete gallery by id
    public function deleteGallery($id)
    {
        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'message' => 'Gallery not found'
            ], 404);
        }

        $gallery->delete();

        return response()->json([
            'message' => 'Gallery deleted successfully'
        ]);
    }
}
