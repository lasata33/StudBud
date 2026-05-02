@extends('layouts.app')

@section('content')
<div class="page-title">Good {{ now()->hour < 12 ? 'morning' : (now()->hour < 17 ? 'afternoon' : 'evening') }}, {{ Auth::user()->name }} ☕</div>
<div class="page-subtitle">{{ now()->format('l, F j, Y') }}</div>

{{-- Stat Cards --}}
<div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-number">{{ $todayTasks->count() }}</div>
        <div class="stat-label">Tasks Today</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $completedTasks->count() }}</div>
        <div class="stat-label">Completed</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ round($todayMinutes / 60, 1) }}h</div>
        <div class="stat-label">Studied Today</div>
    </div>
    <div class="stat-card">
        <div style="font-size: 28px; margin-bottom: 4px;">{{ $streak > 0 ? str_repeat('🔥', min($streak, 5)) : '✨' }}</div>
        <div class="stat-number">{{ $streak }}</div>
        <div class="stat-label">Day Streak</div>
    </div>
</div>

{{-- Goal Ring + Today Tasks --}}
<div style="display: grid; grid-template-columns: 300px 1fr; gap: 20px; margin-bottom: 20px;">

    {{-- Circular Goal Ring --}}
    <div class="card" style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
        <div class="section-title" style="text-align: center;">Today's Goal</div>
        @php
            $goalHours = $goal ? $goal->daily_hours : 3;
            $studiedHours = round($todayMinutes / 60, 1);
            $percentage = min(100, ($studiedHours / $goalHours) * 100);
            $circumference = 2 * pi() * 54;
            $offset = $circumference - ($percentage / 100) * $circumference;
        @endphp
        <div style="position: relative; width: 160px; height: 160px; margin: 16px 0;">
            <svg width="160" height="160" style="transform: rotate(-90deg);">
                <circle cx="80" cy="80" r="54" fill="none" stroke="#E5DED2" stroke-width="12"/>
                <circle cx="80" cy="80" r="54" fill="none" stroke="#685D54" stroke-width="12"
                    stroke-dasharray="{{ $circumference }}"
                    stroke-dashoffset="{{ $offset }}"
                    stroke-linecap="round"
                    style="transition: stroke-dashoffset 1s ease;"/>
            </svg>
            <div style="position: absolute; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <div style="font-family: 'Playfair Display', serif; font-size: 28px; font-weight: 700; color: #685D54;">{{ $studiedHours }}h</div>
                <div style="font-size: 11px; color: #A39382; text-transform: uppercase; letter-spacing: 0.5px;">of {{ $goalHours }}h</div>
            </div>
        </div>
        <div style="font-size: 13px; color: #A39382;">{{ round($percentage) }}% of daily goal</div>
        @if($percentage >= 100)
            <div style="margin-top: 8px; font-size: 13px; color: #4a7a40; font-weight: 500;">Goal reached! 🎉</div>
        @endif
    </div>

    {{-- Today's Tasks --}}
    <div class="card">
        <div class="section-title">📋 Today's Tasks</div>
        @forelse($todayTasks as $task)
            <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #E5DED2;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 3px; height: 36px; border-radius: 4px; background: {{ $task->subject->color }};"></div>
                    <div>
                        <div style="font-weight: 500; font-size: 14px;">{{ $task->title }}</div>
                        <div style="font-size: 12px; color: #A39382;">{{ $task->subject->name }}</div>
                    </div>
                </div>
                <div style="display: flex; gap: 8px; align-items: center;">
                    @if($task->deadline)
                        <span class="badge badge-warning">{{ \Carbon\Carbon::parse($task->deadline)->format('M d') }}</span>
                    @endif
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf @method('PUT')
                        <button class="btn btn-success" style="padding: 6px 14px; font-size: 12px;">✓ Done</button>
                    </form>
                </div>
            </div>
        @empty
            <div style="text-align: center; padding: 32px 0; color: #A39382;">
                <div style="font-size: 32px; margin-bottom: 8px;">✨</div>
                <div>No pending tasks for today!</div>
            </div>
        @endforelse
    </div>
</div>

{{-- Subjects Overview --}}
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px;">
        <div class="section-title" style="margin-bottom: 0;">📚 Your Subjects</div>
        <a href="{{ route('subjects.index') }}" style="font-size: 13px; color: #685D54; text-decoration: none; font-weight: 500;">View all →</a>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(180px, 1fr)); gap: 12px;">
        @forelse($subjects as $subject)
            @php
                $total = $subject->tasks->count();
                $done = $subject->tasks->where('is_completed', true)->count();
                $pct = $total > 0 ? round(($done / $total) * 100) : 0;
            @endphp
            <div style="background: #FBF7F4; border-radius: 14px; padding: 16px; border: 1.5px solid #E5DED2; border-top: 4px solid {{ $subject->color }};">
                <div style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">{{ $subject->name }}</div>
                @if($subject->exam_date)
                    <div style="font-size: 11px; color: #A39382; margin-bottom: 10px;">
                        Exam: {{ \Carbon\Carbon::parse($subject->exam_date)->format('M d') }}
                    </div>
                @endif
                <div style="font-size: 11px; color: #A39382; margin-bottom: 4px;">{{ $done }}/{{ $total }} tasks</div>
                <div style="background: #E5DED2; border-radius: 10px; height: 6px; overflow: hidden;">
                    <div style="background: {{ $subject->color }}; height: 100%; width: {{ $pct }}%; border-radius: 10px; transition: width 0.5s;"></div>
                </div>
            </div>
        @empty
            <div style="color: #A39382; font-size: 14px;">
                No subjects yet. <a href="{{ route('subjects.index') }}" style="color: #685D54; font-weight: 500;">Add one →</a>
            </div>
        @endforelse
    </div>
</div>
@endsection