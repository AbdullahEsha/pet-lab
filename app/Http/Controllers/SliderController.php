<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slider;
use App\Http\Controllers\Controller;

class SliderController extends Controller
{
    public function getAllSliders()
    {
        $sliders = Slider::all();
        $slidersCount = $sliders->count();

        // if perams count=true then return only count of sliders
        if (request()->count) {
            return response()->json([
                'message' => 'Sliders count retrieved successfully',
                'count' => $slidersCount
            ]);
        }

        return response()->json([
            'message' => 'Sliders retrieved successfully',
            'count' => $slidersCount,
            'sliders' => $sliders
        ]);
    }

    public function createSlider(Request $request)
    {
        $createslider = $request->all();

        // upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/slider'), $imageName);
            $createslider['image'] = 'images/slider/' . $imageName;
        }

        $slider = Slider::create($createslider);

        return response()->json([
            'message' => 'Slider created successfully',
            'slider' => $slider
        ]);
    }

    // update slider by id
    public function updateSliderById(Request $request, $id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json([
                'message' => 'Slider not found'
            ], 404);
        }

        $updateslider = $request->all();

        // upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            $image->move(public_path('images/slider'), $imageName);
            $updateslider['image'] = 'images/slider/' . $imageName;

            // delete old image
            $imagePath = public_path($slider->image);
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $slider->update($updateslider);

        return response()->json([
            'message' => 'Slider updated successfully',
            'slider' => $slider
        ]);
    }

    // delete slider by id
    public function deleteSliderById($id)
    {
        $slider = Slider::find($id);

        if (!$slider) {
            return response()->json([
                'message' => 'Slider not found'
            ], 404);
        }

        // delete image
        $imagePath = public_path($slider->image);

        $slider->delete();

        return response()->json([
            'message' => 'Slider deleted successfully'
        ]);
    }
}
