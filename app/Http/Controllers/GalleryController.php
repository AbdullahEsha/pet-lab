<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    // get all galleries
    public function getAllGalleries()
    {
        $galleries = Gallery::all();
        $galleriesCount = $galleries->count();

        // if perams count=true then return only count of galleries
        if (request()->count) {
            return response()->json([
                'message' => 'Galleries count retrieved successfully',
                'count' => $galleriesCount
            ]);
        }

        // if perams folder="folder_name" then return only galleries with that folder name 
        if (request()->folder) {
            $galleries = Gallery::where('folder', request()->folder)->get();
            $galleriesCount = $galleries->count();
        }

        // update folder from JSON to array
        foreach ($galleries as $gallery) {
            $gallery->folder = json_decode($gallery->folder);
        }
        
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

        // update folder from JSON to array
        $gallery->folder = json_decode($gallery->folder);

        return response()->json([
            'message' => 'Gallery retrieved successfully',
            'gallery' => $gallery
        ]);
    }

    // create gallery
    public function createGallery(Request $request)
    {
        $createGallery = $request->all();

        // convert $createGallery['folder'] to JSON
        $createGallery['folder'] = json_encode($createGallery['folder']);

        $gallery = Gallery::create($createGallery);

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

        // delete old images
        if ($gallery->images) {
            $oldImages = json_decode($gallery->images);
            foreach ($oldImages as $oldImage) {
                if (file_exists(public_path($oldImage))) {
                    unlink(public_path($oldImage));
                }
            }
        }

        $gallery->delete();

        return response()->json([
            'message' => 'Gallery deleted successfully'
        ]);
    }
}
