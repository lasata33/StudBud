<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Subject;
use App\Models\StudySession;
use App\Models\Goal;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $todayTasks = Task::where('user_id', $user->id)
            ->where('is_completed', false)
            ->whereDate('deadline', '>=', Carbon::today())
            ->with('subject')
            ->orderBy('deadline')
            ->get();

        $completedTasks = Task::where('user_id', $user->id)
            ->where('is_completed', true)
            ->with('subject')
            ->latest()
            ->take(5)
            ->get();

        $subjects = Subject::where('user_id', $user->id)->get();

        $todayMinutes = StudySession::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->sum('duration_mins');

        $goal = Goal::where('user_id', $user->id)->first();

        $streak = $goal ? $goal->streak_count : 0;

        return view('dashboard', compact(
            'todayTasks',
            'completedTasks', 
            'subjects',
            'todayMinutes',
            'goal',
            'streak'
        ));
    }
}