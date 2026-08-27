@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Class Schedules</h1>
        <p>Schedule a new group fitness session.</p>
    </div>
</div>

<div class="form-panel" style="max-width: 600px; margin: 0 auto; animation: slideUp 0.3s ease-out;">
    <div class="form-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3z"></path><path d="M6 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3 3 3 0 0 0 3-3V6a3 3 0 0 0-3-3z"></path></svg>
        Schedule Class
    </div>
    <form action="{{ route('classes.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="class_name">Class Name</label>
            <input type="text" id="class_name" name="class_name" class="form-control" value="{{ old('class_name') }}" placeholder="e.g. HIIT Boot Camp" required>
        </div>
        <div class="form-group">
            <label for="instructor_name">Instructor Name</label>
            <input type="text" id="instructor_name" name="instructor_name" class="form-control" value="{{ old('instructor_name') }}" placeholder="e.g. Sarah Connor" required>
        </div>
        <div class="form-group">
            <label for="schedule_time">Date & Time</label>
            <input type="datetime-local" id="schedule_time" name="schedule_time" class="form-control" value="{{ old('schedule_time', date('Y-m-d\TH:i')) }}" required>
        </div>
        <div class="form-group">
            <label for="capacity">Maximum Capacity (Seats)</label>
            <input type="number" id="capacity" name="capacity" class="form-control" value="{{ old('capacity', 20) }}" min="1" required>
        </div>
        <div class="form-actions">
            <a href="{{ route('classes.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Schedule Session</button>
        </div>
    </form>
</div>
@endsection
