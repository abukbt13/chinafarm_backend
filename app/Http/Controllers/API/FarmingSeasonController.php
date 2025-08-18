<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\FarmingProgress;
use App\Models\FarmingSeason;
use Illuminate\Container\Attributes\Auth;
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

        $season = FarmingProgress::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Farming Season created.',
        ]);
    }
    public function show(){
        $crops = FarmingProgress::where('user_id', auth()->id())->get();

        return response()->json([
            'status' => 'success',
            'crops' => $crops,
        ]);

    }
    public function GetFarmingSeasonById($id)
    {
        $farmingSeason = FarmingProgress::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'farming_progress' => $farmingSeason,
        ]);

    }
}
