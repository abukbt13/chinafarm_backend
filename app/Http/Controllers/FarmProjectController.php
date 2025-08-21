<?php

namespace App\Http\Controllers;

use App\Models\FarmProject;
use Illuminate\Http\Request;

class FarmProjectController extends Controller
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

        $season = FarmProject::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Farming Season created.',
        ]);
    }
    public function show(){
        $crops = FarmProject::where('user_id', auth()->id())->get();

        return response()->json([
            'status' => 'success',
            'crops' => $crops,
        ]);

    }
    public function countFarmingProjects(){
        $activeprojects = FarmProject::where('user_id', auth()->id())->where('status','pending')->count();

        return response()->json([
            'status' => 'success',
            'projects' => $activeprojects,
        ]);

    }
    public function GetFarmingSeasonById($id)
    {
        $farmingSeason = FarmProject::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'farming_progress' => $farmingSeason,
        ]);

    }
}
