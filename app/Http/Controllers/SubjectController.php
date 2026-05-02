<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::where('user_id', Auth::id())
            ->withCount('tasks')
            ->orderBy('priority', 'desc')
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string',
            'exam_date' => 'nullable|date',
        ]);

        $priority = 0;
        if ($request->exam_date) {
            $daysUntilExam = now()->diffInDays($request->exam_date, false);
            $priority = $daysUntilExam <= 7 ? 3 : ($daysUntilExam <= 14 ? 2 : 1);
        }

        Subject::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'color' => $request->color ?? '#6366f1',
            'exam_date' => $request->exam_date,
            'priority' => $priority,
        ]);

        return redirect()->route('subjects.index')->with('success', 'Subject added!');
    }

    public function destroy(Subject $subject)
    {
        if ($subject->user_id !== Auth::id()) abort(403);
        $subject->delete();
        return redirect()->route('subjects.index')->with('success', 'Subject deleted!');
    }
}