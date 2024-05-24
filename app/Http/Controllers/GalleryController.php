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
      try {
        $data = $request->all();
    
        // Validate title presence (optional)
        if (!isset($data['title']) || empty($data['title'])) {
          throw new Exception('Missing required field: title');
        }
    
        // Validate folder presence (optional)
        if (!isset($data['folder']) || empty($data['folder'])) {
          throw new Exception('Missing required field: folder');
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
            $data['images'] = json_encode($images);
        }

        $gallery = Gallery::create($data);
    
        return response()->json([
          'message' => 'Gallery created successfully',
          'gallery' => $gallery
        ]);
      } catch (\Throwable $th) {
        return response()->json([
          'message' => $th->getMessage()
        ], 500);
      }
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
