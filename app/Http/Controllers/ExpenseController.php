<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{
    public function ShowExpenses($season_id)
    {
        $expenses = Expense::with('user')
            ->where('farming_progress_id', $season_id)
            ->latest()
            ->get();

        return response()->json([
            'status' => 'success',
            'expenses' => $expenses, // ✅ PLURAL and a collection
        ]);
    }

    // ✅ Create a new expense
    public function storeExpenses(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'date' => 'required|date',
            'farming_progress_id' => 'required|exists:farming_progress,id',
        ]);
        $validated['user_id'] = Auth::user()->id;

        $expense = Expense::create($validated);
        return response()->json(['status' => 'success'], 201);
    }
}
