<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GoalController extends Controller
{
    public function index()
    {
        $goal = Goal::where('user_id', Auth::id())->first();
        return view('goals', compact('goal'));
    }

    public function store(Request $request)
    {
        $request->validate(['daily_hours' => 'required|integer|min:1|max:12']);

        Goal::updateOrCreate(
            ['user_id' => Auth::id()],
            ['daily_hours' => $request->daily_hours]
        );

        return redirect()->route('goals.index')->with('success', 'Goal saved!');
    }
}