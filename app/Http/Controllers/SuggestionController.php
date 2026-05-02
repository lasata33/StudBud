<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\StudySession;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SuggestionController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $suggestions = [];

        $subjects = Subject::where('user_id', $user->id)->get();

        $todaySessionSubjectIds = StudySession::where('user_id', $user->id)
            ->whereDate('date', Carbon::today())
            ->pluck('subject_id')
            ->toArray();

        foreach ($subjects as $subject) {
            // not studied today
            if (!in_array($subject->id, $todaySessionSubjectIds)) {
                $suggestions[] = [
                    'type' => 'warning',
                    'message' => "You haven't studied {$subject->name} today 👀",
                ];
            }

            // exam is near
            if ($subject->exam_date) {
                $daysLeft = Carbon::today()->diffInDays($subject->exam_date, false);
                if ($daysLeft <= 7 && $daysLeft >= 0) {
                    $suggestions[] = [
                        'type' => 'danger',
                        'message' => "Exam alert! {$subject->name} exam is in {$daysLeft} days — focus up! 🔥",
                    ];
                }
            }
        }

        // pending tasks with passed deadline
        $overdueTasks = Task::where('user_id', $user->id)
            ->where('is_completed', false)
            ->whereDate('deadline', '<', Carbon::today())
            ->with('subject')
            ->get();

        foreach ($overdueTasks as $task) {
            $suggestions[] = [
                'type' => 'danger',
                'message' => "Overdue task: \"{$task->title}\" in {$task->subject->name} 😬",
            ];
        }

        if (empty($suggestions)) {
            $suggestions[] = [
                'type' => 'success',
                'message' => "You're all caught up! Great work today 🎉",
            ];
        }

        return view('suggestions', compact('suggestions'));
    }
}