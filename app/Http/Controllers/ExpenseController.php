<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpenseController extends Controller
{

    public function ShowExpense($farm_project_id)
    {
        $Expense = Expense::with('user')
            ->where('farm_project_id', $farm_project_id)
            ->latest()
            ->get();
        $total = Expense::with('user')
            ->where('farm_project_id', $farm_project_id)
            ->sum('amount');

        return response()->json([
            'status' => 'success',
            'expense' => [
                'all_expense'=>$Expense,
                'total' => $total,
            ]
        ]);
    }

    // ✅ Create a new expense
    public function storeExpense(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required',
            'date' => 'required|date',
            'farm_project_id' => 'required|exists:farm_projects,id',
        ]);
        $validated['user_id'] = Auth::user()->id;
        $expense = Expense::create($validated);
        return response()->json(['status' => 'success'], 201);
    }
    public function editExpense(Request $request, $season_id, $expense_id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'farming_progress_id' => 'required|exists:farming_progress,id',
        ]);

        $validated['user_id'] = Auth::id();

        $expense = Expense::where('id', $expense_id)
            ->where('farming_progress_id', $season_id)
            ->first();

        if (!$expense) {
            return response()->json(['message' => 'Expense not found'], 404);
        }

        $expense->update($validated);

        return response()->json(['status' => 'success', 'message' => 'Expense updated successfully']);
    }

    public function deleteExpense($season_id, $expense_id)
    {
        $expense = Expense::where('id', $expense_id)
            ->where('farm_project_id', $season_id)
            ->first();

        if (!$expense) {
            return response()->json(['status' => 'error', 'message' => 'Expense not found.'], 404);
        }

        $expense->delete();

        return response()->json(['status' => 'success', 'message' => 'Expense deleted successfully.']);
    }
}
