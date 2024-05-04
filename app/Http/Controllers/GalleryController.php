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
        // if images has files then upload them
        if ($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/gallery'), $imageName);
                $images[] = 'images/gallery/' . $imageName;

                // json_encode($images);
                $images = json_encode($images);
            }
        } else{
            // Convert array to JSON string before saving
            $images = json_encode($request->images);
        }
            
        // Create a new gallery instance
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->images = $images; // Assign JSON string to the 'images' attribute
        $gallery->folder = $request->folder;
        $gallery->save();

        return response()->json([
            'message' => 'Gallery created successfully',
            'gallery' => $gallery
        ]);
    }

    // update gallery by id
    public function updateGallery(Request $request, $id)
    {
        // find the gallery by id
        if($request->hasFile('images')) {
            $images = [];
            foreach ($request->file('images') as $image) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/gallery'), $imageName);
                $images[] = 'images/gallery/' . $imageName;

                // json_encode($images);
                $images = json_encode($images);
            }
        } else{
            // Convert array to JSON string before saving
            $images = json_encode($request->images);
        }

        $gallery = Gallery::find($id);

        // also delete the old images if any of the file is found in public path
        $oldImages = json_decode($gallery->images);
        foreach ($oldImages as $oldImage) {
            if (file_exists(public_path($oldImage))) {
                unlink(public_path($oldImage));
            }
        }

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
