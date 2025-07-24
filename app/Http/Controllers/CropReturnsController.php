<?php

namespace App\Http\Controllers;

use App\Models\CropReturns;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CropReturnsController extends Controller
{
    public function ShowCropReturnss($season_id)
    {
        $CropReturns = CropReturns::with('user')
            ->where('farming_progress_id', $season_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'CropReturns' => $CropReturns, // ✅ PLURAL and a collection
        ]);
    }

    // ✅ Create a new CropReturns
    public function storeCropReturns(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required',
            'date' => 'required|date',
            'farming_progress_id' => 'required|exists:farming_progress,id',
        ]);
        $validated['user_id'] = Auth::user()->id;

        $CropReturns = CropReturns::create($validated);
        return response()->json(['status' => 'success'], 201);
    }
    public function editCropReturnss(Request $request, $season_id, $CropReturns_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'farming_progress_id' => 'required|exists:farming_progress,id',
        ]);

        $validated['user_id'] = Auth::id();

        $CropReturns = CropReturns::where('id', $CropReturns_id)
            ->where('farming_progress_id', $season_id)
            ->first();

        if (!$CropReturns) {
            return response()->json(['message' => 'CropReturns not found'], 404);
        }

        $CropReturns->update($validated);

        return response()->json(['status' => 'success', 'message' => 'CropReturns updated successfully']);
    }

    public function DeleteCropReturnss($season_id, $CropReturns_id)
    {
        $CropReturns = CropReturns::where('id', $CropReturns_id)
            ->where('farming_progress_id', $season_id)
            ->first();

        if (!$CropReturns) {
            return response()->json(['status' => 'error', 'message' => 'CropReturns not found.'], 404);
        }

        $CropReturns->delete();

        return response()->json(['status' => 'success', 'message' => 'CropReturns deleted successfully.']);
    }

}
