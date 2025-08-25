<?php

namespace App\Http\Controllers;

use App\Models\ProjectReturn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectReturnController extends Controller
{
    public function showProjectReturns($season_id)
    {
        $ProjectReturns = ProjectReturn::with('user')
            ->where('farm_project_id', $season_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'project_returns' => $ProjectReturns, // ✅ PLURAL and a collection
        ]);
    }

    // ✅ Create a new ProjectReturns
    public function storeProjectReturns(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required',
            'date' => 'required|date',
            'farm_project_id' => 'required|exists:farm_projects,id',
        ]);
        $validated['user_id'] = Auth::user()->id;

        $ProjectReturns = ProjectReturn::create($validated);
        return response()->json(['status' => 'success'], 201);
    }
    public function editProjectReturns(Request $request, $season_id, $ProjectReturns_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'farm_project_id' => 'required|exists:farm_projects,id',
        ]);

        $validated['user_id'] = Auth::id();

        $ProjectReturns = ProjectReturn::where('id', $ProjectReturns_id)
            ->where('farm_project_id', $season_id)
            ->first();

        if (!$ProjectReturns) {
            return response()->json(['message' => 'ProjectReturns not found'], 404);
        }

        $ProjectReturns->update($validated);

        return response()->json(['status' => 'success', 'message' => 'ProjectReturns updated successfully']);
    }

    public function DeleteProjectReturns($season_id, $ProjectReturns_id)
    {
        $ProjectReturns = ProjectReturn::where('id', $ProjectReturns_id)
            ->where('farm_project_id', $season_id)
            ->first();

        if (!$ProjectReturns) {
            return response()->json(['status' => 'error', 'message' => 'ProjectReturns not found.'], 404);
        }

        $ProjectReturns->delete();

        return response()->json(['status' => 'success', 'message' => 'ProjectReturns deleted successfully.']);
    }
}
