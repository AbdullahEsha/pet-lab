<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

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
        $createGallery = $request->all();
        // if images has files then upload them
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images/gallery'), $imageName);
                $images[] = 'images/gallery/' . $imageName;
            }

            // json_encode($images);
            $createGallery['images'] = json_encode($images);
        }

        $gallery = Gallery::create($createGallery);

        return response()->json([
            'message' => 'Gallery created successfully',
            'gallery' => $gallery
        ]);
    }

    // update gallery by id
    public function updateGallery(Request $request, $id)
    {
        $updateGallery = $request->all();

        $gallery = Gallery::find($id);

        if (!$gallery) {
            return response()->json([
                'message' => 'Gallery not found'
            ], 404);
        }

        // if images has files then upload them
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = $image->getClientOriginalName();
                $image->move(public_path('images/gallery'), $imageName);
                $images[] = 'images/gallery/' . $imageName;
            }

            // json_encode($images);
            $updateGallery['images'] = json_encode($images);
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

        $gallery->fill($updateGallery);
        $gallery->save();

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
