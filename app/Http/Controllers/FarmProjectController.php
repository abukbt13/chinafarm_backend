<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Expense;
use App\Models\FarmProject;
use App\Models\PlantingSuggestion;
use App\Models\ProjectReturn;
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
        $blogs = Blog::where('user_id', auth()->id())->count();
        $suggestion = PlantingSuggestion::where('user_id', auth()->id())->count();

        return response()->json([
            'status' => 'success',
            'summary' => ['activecrops'=>$activeprojects,'blogs'=>$blogs,'suggestions'=>$suggestion],
        ]);

    }
    public function GetFarmingSeasonById($id)
    {
        $project = FarmProject::findOrFail($id);

        // Get totals by project id
        $expense = Expense::where('farm_project_id', $id)->sum('amount');
        $returns = ProjectReturn::where('farm_project_id', $id)->sum('amount');

        // Calculate profit
        $profit = $returns - $expense;

        return response()->json([
            'status' => 'success',
            'summary' => [
                'project' => $project,
                'expense' => $expense,
                'returns' => $returns,
                'profit' => $profit,
            ],
        ]);
    }

}
