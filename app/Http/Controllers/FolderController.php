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
        $folder = Folder::create($request->all());

        return response()->json([
            'message' => 'Folder created successfully',
            'folder' => $folder
        ]);
    }

    // Update folder
    public function updateFolder(Request $request, $id)
    {
        $folder = Folder::find($id);

        if (!$folder) {
            return response()->json([
                'message' => 'Folder not found'
            ], 404);
        }

        $folder->fill($request->all());
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
