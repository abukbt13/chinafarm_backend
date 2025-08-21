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
            'period' => 'required|string|max:255',
            'factor' => 'nullable|string',
        ]);

        return PlantingSuggestion::create([
            'user_id' => Auth::id(),
            'crop_name' => $request->crop_name,
            'period' => $request->period,
            'factor' => $request->factor,
        ]);
    }
}
