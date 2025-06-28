<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Milestone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MilestoneController extends Controller
{
    public function show()
    {
        $milestone  = Milestone::all();
        return response()->json([
            'status' => 'success',
            'milestones' => $milestone
        ]);
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'description' => 'required|string',
            'pictures' => 'nullable|array',
            'pictures.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $picturePaths = [];

        if ($request->hasFile('pictures')) {
            foreach ($request->file('pictures') as $image) {
                $originalName = $image->getClientOriginalName(); // original filename (e.g., "spraying-day1.jpg")
                $filename = time() . '-' . $originalName; // make it unique by prefixing with timestamp
                $path = $image->storeAs('public/uploads/milestones', $filename); // Stored in storage/app/public/uploads/milestones
                $picturePaths[] = Storage::url('uploads/milestones/' . $filename); // Returns /storage/uploads/milestones/...
            }
        }

        $milestone = Milestone::create([
            'date' => $validated['date'],
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
