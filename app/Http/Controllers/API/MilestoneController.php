<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MilestoneController extends Controller
{
    public function show($id)
    {
        $milestone  = Milestone::where('season_id',$id)->get();
        return response()->json([
            'status' => 'success',
            'milestones' => $milestone
        ]);
    }

    public function create(Request $request,$id)
    {
        $validated = $request->validate([
            'activity' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
            'pictures' => 'nullable|array',
            'pictures.*' => 'image|mimes:jpg,jpeg,png,webp',
        ]);

        $picturePaths = [];


        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $image) {
                $originalName = $image->getClientOriginalName(); // e.g., spraying-day1.jpg
                $filename = time() . '-' . $originalName;

                // Define paths
                $relativePath = 'uploads/milestones/' . $filename;
                $fullStoragePath = storage_path('app/public/' . $relativePath);

                // Create directory if not exists
                if (!file_exists(dirname($fullStoragePath))) {
                    mkdir(dirname($fullStoragePath), 0777, true);
                }

                // Load and compress using GD
                $imageResource = imagecreatefromstring(file_get_contents($image->getRealPath()));
                if ($imageResource === false) {
                    continue; // Skip if not a valid image
                }

                // Convert to JPEG with reduced quality (e.g., 70%)
                imagejpeg($imageResource, $fullStoragePath, 70); // quality: 0 (worst) - 100 (best)

                imagedestroy($imageResource); // Free up memory

                // Store public path
                $picturePaths[] = 'uploads/milestones/' . $filename;
            }
        }

        $milestone = Milestone::create([
            'user_id'=>Auth::user()->id,
            'season_id'=>$id,
            'date' => $validated['date'],
            'activity' => $validated['activity'],
            'description' => $validated['description'],
            'pictures' => $picturePaths,
        ]);

        return response()->json([
            'status' => 'success',
            'milestone' => $milestone
        ], 201);
    }
//
//    public function show($id)
//    {
//        $milestone = Milestone::findOrFail($id);
//
//        return response()->json([
//            'status' => 'success',
//            'milestone' => $milestone
//        ]);
//    }
//
//    public function update(Request $request, $id)
//    {
//        $milestone = Milestone::findOrFail($id);
//
//        $validated = $request->validate([
//            'date' => 'required|date',
//            'description' => 'required|string',
//            'pictures' => 'nullable|array',
//            'pictures.*' => 'nullable|string'
//        ]);
//
//        $milestone->update($validated);
//
//        return response()->json([
//            'status' => 'success',
//            'milestone' => $milestone
//        ]);
//    }
//
//    public function DeleteMilestone($id)
//    {
//        $milestone = Milestone::findOrFail($id);
//        $milestone->delete();
//
//        return response()->json(['status' => 'success', 'message' => 'Milestone deleted']);
//    }
}
