@extends('layouts.app')

@section('content')
<div class="page-title">📖 Subjects</div>
<div class="page-subtitle">Manage your subjects and track exam dates</div>

{{-- Add Subject Form --}}
<div class="card">
    <div class="section-title">Add New Subject</div>
    <form method="POST" action="{{ route('subjects.store') }}">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr 120px auto; gap: 12px; align-items: end;">
            <div>
                <label style="font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Subject Name</label>
                <input type="text" name="name" placeholder="e.g. DBMS, Software Engineering..." required>
            </div>
            <div>
                <label style="font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Exam Date</label>
                <input type="date" name="exam_date">
            </div>
            <div>
                <label style="font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Color</label>
                <input type="color" name="color" value="#A39382" style="height: 44px; padding: 4px; cursor: pointer;">
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="height: 44px; white-space: nowrap;">+ Add Subject</button>
            </div>
        </div>
    </form>
</div>

{{-- Subjects Grid --}}
@if($subjects->isEmpty())
    <div class="card" style="text-align: center; padding: 48px;">
        <div style="font-size: 48px; margin-bottom: 12px;">📚</div>
        <div style="font-size: 16px; font-weight: 600; color: #685D54; margin-bottom: 8px;">No subjects yet!</div>
        <div style="font-size: 14px; color: #A39382;">Add your first subject above to get started.</div>
    </div>
@else
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 16px;">
        @foreach($subjects as $subject)
            @php
                $daysLeft = $subject->exam_date ? \Carbon\Carbon::today()->diffInDays($subject->exam_date, false) : null;
            @endphp
            <div style="background: #FFFFFF; border-radius: 20px; padding: 24px; border: 1px solid #E5DED2; border-top: 5px solid {{ $subject->color }}; box-shadow: 0 2px 12px rgba(168,147,130,0.08); transition: transform 0.2s;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 12px;">
                    <h3 style="font-family: 'Playfair Display', serif; font-size: 20px; font-weight: 700; color: #232323;">{{ $subject->name }}</h3>
                    <form method="POST" action="{{ route('subjects.destroy', $subject) }}">
                        @csrf @method('DELETE')
                        <button class="btn" style="padding: 4px 10px; font-size: 12px; background: #f5d8d0; color: #a05040; border-radius: 8px;">✕</button>
                    </form>
                </div>

                @if($subject->exam_date)
                    <div style="margin-bottom: 12px;">
                        <span class="badge {{ $daysLeft !== null && $daysLeft <= 7 ? 'badge-danger' : 'badge-warning' }}">
                            📅 {{ $daysLeft !== null && $daysLeft >= 0 ? $daysLeft . ' days until exam' : 'Exam passed' }}
                        </span>
                    </div>
                @endif

                <div style="font-size: 13px; color: #A39382; margin-bottom: 10px;">{{ $subject->tasks_count }} task(s) total</div>

                @if($subject->priority >= 3)
                    <span class="badge badge-danger">🔥 High Priority</span>
                @elseif($subject->priority == 2)
                    <span class="badge badge-warning">⚡ Medium Priority</span>
                @endif
            </div>
        @endforeach
    </div>
@endif
@endsection