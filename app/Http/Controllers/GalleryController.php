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
        // images contain multiple files in json format
        if($request->hasFile('images')) {
            $images = $request->file('images');
            $imagePaths = [];
            foreach ($images as $image) {
                $imageName = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('images/gallery'), $imageName);
                $imagePaths[] = 'images/gallery/' . $imageName;
            }
            $request->images = json_encode($imagePaths);
        }

        $gallery = Gallery::create($request->all());

        return response()->json([
            'message' => 'Gallery created successfully',
            'gallery' => $gallery
        ]);
    }


    // update gallery by id
    public function updateGallery(Request $request, $id)
    {
        // find the gallery by id
        if($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images/gallery'), $imageName);
            $request->image = 'images/gallery/' . $imageName;
        }

        $gallery = Gallery::find($id);

        // also delete the old image
        if (file_exists(public_path($gallery->image))) {
            unlink(public_path($gallery->image));
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
