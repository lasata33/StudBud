<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = Task::where('user_id', Auth::id())
            ->with('subject')
            ->orderBy('deadline')
            ->get();

        $subjects = Subject::where('user_id', Auth::id())->get();

        return view('tasks.index', compact('tasks', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'subject_id' => 'required|exists:subjects,id',
            'deadline' => 'nullable|date',
            'estimated_mins' => 'nullable|integer|min:5',
        ]);

        Task::create([
            'user_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'deadline' => $request->deadline,
            'estimated_mins' => $request->estimated_mins ?? 25,
            'is_completed' => false,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task added!');
    }

    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);

        $task->update(['is_completed' => !$task->is_completed]);

        return redirect()->back()->with('success', 'Task updated!');
    }

    public function destroy(Task $task)
    {
        if ($task->user_id !== Auth::id()) abort(403);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted!');
    }
}