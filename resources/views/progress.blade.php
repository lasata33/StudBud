@extends('layouts.app')

@section('content')
<div class="page-title">📊 Progress</div>
<div class="page-subtitle">Track your study habits and growth</div>

{{-- Stat Cards --}}
<div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 24px;">
    <div class="stat-card">
        <div class="stat-number">{{ round($totalMinsToday / 60, 1) }}h</div>
        <div class="stat-label">Studied Today</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $goal ? $goal->daily_hours : 3 }}h</div>
        <div class="stat-label">Daily Goal</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $goal ? $goal->streak_count : 0 }}</div>
        <div class="stat-label">🔥 Day Streak</div>
    </div>
</div>

{{-- Weekly Chart --}}
<div class="card">
    <div class="section-title">📅 Last 7 Days</div>
    <canvas id="weeklyChart" height="100"></canvas>
</div>

{{-- Subject Progress --}}
<div class="card">
    <div class="section-title">📚 Study Time by Subject</div>
    @forelse($subjectData as $subjectId => $sessions)
        @php
            $subject = $sessions->first()->subject;
            $totalMins = $sessions->sum('duration_mins');
            $maxMins = $subjectData->map->sum('duration_mins')->max();
            $pct = $maxMins > 0 ? round(($totalMins / $maxMins) * 100) : 0;
        @endphp
        <div style="margin-bottom: 16px;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 6px;">
                <span style="font-size: 14px; font-weight: 500;">{{ $subject->name }}</span>
                <span style="font-size: 13px; color: #A39382;">{{ $totalMins }} mins</span>
            </div>
            <div style="background: #E5DED2; border-radius: 10px; height: 8px; overflow: hidden;">
                <div style="background: {{ $subject->color }}; height: 100%; width: {{ $pct }}%; border-radius: 10px; transition: width 0.8s ease;"></div>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 32px; color: #A39382;">
            <div style="font-size: 36px; margin-bottom: 8px;">📖</div>
            <div>No study sessions yet! Start your Pomodoro timer.</div>
        </div>
    @endforelse
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const weeklyData = @json($weeklyData);
    const labels = [];
    const data = [];

    for (let i = 6; i >= 0; i--) {
        const date = new Date();
        date.setDate(date.getDate() - i);
        const key = date.toISOString().split('T')[0];
        labels.push(date.toLocaleDateString('en', { weekday: 'short', month: 'short', day: 'numeric' }));
        const sessions = weeklyData[key] || [];
        const mins = sessions.reduce((sum, s) => sum + s.duration_mins, 0);
        data.push(Math.round(mins / 60 * 10) / 10);
    }

    const ctx = document.getElementById('weeklyChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Hours Studied',
                data: data,
                backgroundColor: '#A39382',
                borderRadius: 10,
                borderSkipped: false,
                hoverBackgroundColor: '#685D54',
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => ctx.parsed.y + ' hours'
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { color: '#E5DED2' },
                    ticks: { color: '#A39382', font: { family: 'DM Sans' } }
                },
                x: {
                    grid: { display: false },
                    ticks: { color: '#A39382', font: { family: 'DM Sans' } }
                }
            }
        }
    });
</script>
@endsection