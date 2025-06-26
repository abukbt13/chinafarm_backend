<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FarmingSeason;
use Illuminate\Http\Request;

class FarmingSeasonController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'crop' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
        ]);
//            dd($validated);
        $validated['user_id'] = auth()->id(); // ✅ Add logged-in user ID

        $season = FarmingSeason::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Farming Season created.',
        ]);
    }
    public function show(){
        $crops = FarmingSeason::all();
        return response()->json([
            'status' => 'success',
            'crops' => $crops,
        ]);
    }
}
