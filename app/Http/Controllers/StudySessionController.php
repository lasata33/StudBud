<?php

namespace App\Http\Controllers;

use App\Models\StudySession;
use App\Models\Goal;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudySessionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'duration_mins' => 'required|integer|min:1',
        ]);

        StudySession::create([
            'user_id' => Auth::id(),
            'subject_id' => $request->subject_id,
            'date' => Carbon::today(),
            'duration_mins' => $request->duration_mins,
            'session_type' => 'pomodoro',
        ]);

        // update streak
        $goal = Goal::firstOrCreate(
            ['user_id' => Auth::id()],
            ['daily_hours' => 3, 'streak_count' => 0]
        );

        $lastStudied = $goal->last_studied_date;

        if ($lastStudied) {
            $diff = Carbon::parse($lastStudied)->diffInDays(Carbon::today());
            if ($diff === 1) {
                $goal->increment('streak_count');
            } elseif ($diff > 1) {
                $goal->update(['streak_count' => 1]);
            }
        } else {
            $goal->update(['streak_count' => 1]);
        }

        $goal->update(['last_studied_date' => Carbon::today()]);

        return response()->json(['success' => true, 'streak' => $goal->streak_count]);
    }

    public function progress()
    {
        $user = Auth::user();

        $weeklyData = StudySession::where('user_id', $user->id)
            ->where('date', '>=', Carbon::now()->subDays(7))
            ->with('subject')
            ->get()
            ->groupBy('date');

        $subjectData = StudySession::where('user_id', $user->id)
            ->with('subject')
            ->get()
            ->groupBy('subject_id');

        $totalMinsToday = StudySession::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->sum('duration_mins');

        $goal = Goal::where('user_id', $user->id)->first();

        return view('progress', compact('weeklyData', 'subjectData', 'totalMinsToday', 'goal'));
    }
}