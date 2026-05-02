@extends('layouts.app')

@section('content')
<div class="page-title">🎯 Goals</div>
<div class="page-subtitle">Set your daily study targets and build consistency</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
    {{-- Set Goal Form --}}
    <div class="card">
        <div class="section-title">Set Daily Study Goal</div>
        <form method="POST" action="{{ route('goals.store') }}">
            @csrf
            <label style="font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Hours per day</label>
            <input type="number" name="daily_hours" min="1" max="12"
                   value="{{ $goal ? $goal->daily_hours : 3 }}"
                   style="max-width: 160px; font-size: 24px; font-weight: 700; text-align: center; color: #685D54;">
            <br>
            <button type="submit" class="btn btn-primary" style="margin-top: 8px;">Save Goal</button>
        </form>

        <hr class="divider">

        <div style="font-size: 13px; color: #A39382; line-height: 1.6;">
            <div style="margin-bottom: 6px;">⏰ <strong style="color: #685D54;">1–2 hours</strong> — Light revision day</div>
            <div style="margin-bottom: 6px;">📚 <strong style="color: #685D54;">3–4 hours</strong> — Solid study session</div>
            <div>🔥 <strong style="color: #685D54;">5+ hours</strong> — Exam prep mode</div>
        </div>
    </div>

    {{-- Streak Card --}}
    <div class="card" style="text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center;">
        @if($goal && $goal->streak_count > 0)
            <div style="font-size: 56px; margin-bottom: 8px;">
                {{ str_repeat('🔥', min($goal->streak_count, 7)) }}
            </div>
            <div style="font-family: 'Playfair Display', serif; font-size: 48px; font-weight: 700; color: #685D54;">
                {{ $goal->streak_count }}
            </div>
            <div style="font-size: 13px; color: #A39382; text-transform: uppercase; letter-spacing: 1px; margin-top: 4px;">Day Streak</div>
            @if($goal->last_studied_date)
                <div style="font-size: 12px; color: #A39382; margin-top: 12px;">
                    Last studied: {{ \Carbon\Carbon::parse($goal->last_studied_date)->diffForHumans() }}
                </div>
            @endif
        @else
            <div style="font-size: 48px; margin-bottom: 12px;">✨</div>
            <div style="font-size: 16px; font-weight: 600; color: #685D54;">Start your streak today!</div>
            <div style="font-size: 13px; color: #A39382; margin-top: 8px;">Complete a Pomodoro session to begin.</div>
        @endif
    </div>
</div>
@endsection