@extends('layouts.app')

@section('content')
<div class="page-title">🧠 Smart Suggestions</div>
<div class="page-subtitle">Personalised tips based on your study patterns</div>

<div style="display: flex; flex-direction: column; gap: 12px;">
    @foreach($suggestions as $suggestion)
        <div style="
            background: {{ $suggestion['type'] === 'danger' ? '#f5d8d0' : ($suggestion['type'] === 'warning' ? '#f5e6d0' : '#d8ecd0') }};
            border: 1px solid {{ $suggestion['type'] === 'danger' ? '#e8c0b0' : ($suggestion['type'] === 'warning' ? '#e8d0b0' : '#c0dab0') }};
            border-left: 5px solid {{ $suggestion['type'] === 'danger' ? '#a05040' : ($suggestion['type'] === 'warning' ? '#a07040' : '#4a7a40') }};
            color: {{ $suggestion['type'] === 'danger' ? '#a05040' : ($suggestion['type'] === 'warning' ? '#a07040' : '#4a7a40') }};
            border-radius: 14px; padding: 18px 20px; font-size: 15px; font-weight: 500;">
            {{ $suggestion['message'] }}
        </div>
    @endforeach
</div>

<div class="card" style="margin-top: 24px;">
    <div class="section-title">💡 Study Tips</div>
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 12px;">
        <div style="background: #FBF7F4; border-radius: 14px; padding: 16px; border: 1px solid #E5DED2;">
            <div style="font-size: 24px; margin-bottom: 8px;">🍅</div>
            <div style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">Pomodoro Technique</div>
            <div style="font-size: 13px; color: #A39382;">Study for 25 mins, break for 5. Repeat 4 times then take a long break.</div>
        </div>
        <div style="background: #FBF7F4; border-radius: 14px; padding: 16px; border: 1px solid #E5DED2;">
            <div style="font-size: 24px; margin-bottom: 8px;">📝</div>
            <div style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">Active Recall</div>
            <div style="font-size: 13px; color: #A39382;">Test yourself instead of re-reading. It's proven to boost retention significantly.</div>
        </div>
        <div style="background: #FBF7F4; border-radius: 14px; padding: 16px; border: 1px solid #E5DED2;">
            <div style="font-size: 24px; margin-bottom: 8px;">😴</div>
            <div style="font-weight: 600; font-size: 14px; margin-bottom: 4px;">Sleep Matters</div>
            <div style="font-size: 13px; color: #A39382;">Your brain consolidates memory during sleep. Don't sacrifice it for late night cramming!</div>
        </div>
    </div>
</div>
@endsection