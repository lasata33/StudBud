@extends('layouts.app')

@section('content')
<div class="page-title">✅ Tasks</div>
<div class="page-subtitle">Stay on top of your assignments and deadlines</div>

{{-- Add Task Form --}}
<div class="card">
    <div class="section-title">Add New Task</div>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div style="display: grid; grid-template-columns: 2fr 1fr 1fr 120px auto; gap: 12px; align-items: end;">
            <div>
                <label style="font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Task Title</label>
                <input type="text" name="title" placeholder="e.g. Complete ER diagram..." required>
            </div>
            <div>
                <label style="font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Subject</label>
                <select name="subject_id" required>
                    <option value="">Select subject</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label style="font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Deadline</label>
                <input type="date" name="deadline">
            </div>
            <div>
                <label style="font-size: 12px; color: #A39382; display: block; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Est. Mins</label>
                <input type="number" name="estimated_mins" value="25" min="5">
            </div>
            <div>
                <button type="submit" class="btn btn-primary" style="height: 44px; white-space: nowrap;">+ Add</button>
            </div>
        </div>
    </form>
</div>

{{-- Tasks List --}}
<div class="card">
    <div class="section-title">All Tasks</div>
    @forelse($tasks as $task)
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 14px 0; border-bottom: 1px solid #E5DED2; {{ $task->is_completed ? 'opacity: 0.5;' : '' }}">
            <div style="display: flex; align-items: center; gap: 14px;">
                <div style="width: 4px; height: 44px; border-radius: 4px; background: {{ $task->subject->color }};"></div>
                <div>
                    <div style="font-weight: 500; font-size: 15px; {{ $task->is_completed ? 'text-decoration: line-through; color: #A39382;' : '' }}">
                        {{ $task->title }}
                    </div>
                    <div style="font-size: 12px; color: #A39382; margin-top: 2px;">
                        {{ $task->subject->name }} · {{ $task->estimated_mins }} mins
                    </div>
                </div>
            </div>
            <div style="display: flex; gap: 8px; align-items: center;">
                @if($task->deadline)
                    @php $daysLeft = \Carbon\Carbon::today()->diffInDays($task->deadline, false); @endphp
                    <span class="badge {{ $daysLeft < 0 ? 'badge-danger' : ($daysLeft <= 3 ? 'badge-warning' : 'badge-success') }}">
                        {{ $daysLeft < 0 ? 'Overdue' : ($daysLeft === 0 ? 'Due today' : $daysLeft . 'd left') }}
                    </span>
                @endif
                @if(!$task->is_completed)
                    <form method="POST" action="{{ route('tasks.update', $task) }}">
                        @csrf @method('PUT')
                        <button class="btn btn-success" style="padding: 6px 14px; font-size: 12px;">✓ Done</button>
                    </form>
                @else
                    <span class="badge badge-success">✓ Completed</span>
                @endif
                <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                    @csrf @method('DELETE')
                    <button class="btn" style="padding: 6px 12px; font-size: 12px; background: #f5d8d0; color: #a05040; border-radius: 8px;">✕</button>
                </form>
            </div>
        </div>
    @empty
        <div style="text-align: center; padding: 40px 0; color: #A39382;">
            <div style="font-size: 40px; margin-bottom: 12px;">✨</div>
            <div>No tasks yet! Add your first one above.</div>
        </div>
    @endforelse
</div>
@endsection