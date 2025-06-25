<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

        $season = auth()->user()->farmingSeasons()->create($validated);

        return response()->json($season, 201);
    }

}
