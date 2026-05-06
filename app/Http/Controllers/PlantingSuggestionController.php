<?php

namespace App\Http\Controllers;

use App\Models\PlantingSuggestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlantingSuggestionController extends Controller
{
    public function index()
    {
        return PlantingSuggestion::where('user_id', Auth::id())->latest()->get();
    }

    public function store(Request $request)
    {
        $request->validate([
            'crop_name' => 'required|string|max:255',
            'planting_month' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'harvesting_month' => 'required|in:January,February,March,April,May,June,July,August,September,October,November,December',
            'reason'=>'required|min:4'
        ]);

        return PlantingSuggestion::create([
            'user_id' => Auth::id(),
            'crop_name' => $request->crop_name,
            'harvesting_month' => $request->harvesting_month,
            'planting_month' => $request->planting_month,
            'reason' => $request->reason,
        ]);
    }
}
