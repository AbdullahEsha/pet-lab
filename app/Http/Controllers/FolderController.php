<?php

namespace App\Http\Controllers;

use App\Models\Folder;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    // Get all folders
    public function getAllFolders()
    {
        $folders = Folder::all();
        $foldersCount = $folders->count();

        // If perams count=true then return only count of folders
        if (request()->count) {
            return response()->json([
                'message' => 'Folders count retrieved successfully',
                'foldersCount' => $foldersCount
            ]);
        }

        return response()->json([
            'message' => 'Folders retrieved successfully',
            'foldersCount' => $foldersCount,
            'folders' => $folders
        ]);
    }

    // Get folder by id
    public function getFolderById($id)
    {
        $folder = Folder::find($id);

        if (!$folder) {
            return response()->json([
                'message' => 'Folder not found'
            ], 404);
        }

        return response()->json([
            'message' => 'Folder retrieved successfully',
            'folder' => $folder
        ]);
    }

    // Create folder
    public function createFolder(Request $request)
    {
        $createFolder = $request->all();
        // If image has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/gallery'), $imageName);
            $createFolder['image'] = 'images/gallery/'. $imageName;
        }

        $folder = Folder::create($createFolder);

        return response()->json([
            'message' => 'Folder created successfully',
            'folder' => $folder
        ]);
    }

    // Update folder
    public function updateFolder(Request $request, $id)
    {
        $updateFolder = $request->all();
        $folder = Folder::find($id);

        if (!$folder) {
            return response()->json([
                'message' => 'Folder not found'
            ], 404);
        }

        // If image has file then upload it
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/gallery'), $imageName);
            $updateFolder['image'] = 'images/gallery/'. $imageName;
        }

        $folder->fill($updateFolder);
        $folder->save();

        return response()->json([
            'message' => 'Folder updated successfully',
            'folder' => $folder
        ]);
    }

    // Delete folder
    public function deleteFolder($id)
    {
        $folder = Folder::find($id);

        if (!$folder) {
            return response()->json([
                'message' => 'Folder not found'
            ], 404);
        }

        $folder->delete();

        return response()->json([
            'message' => 'Folder deleted successfully'
        ]);
    }
}
