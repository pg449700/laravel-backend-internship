@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Class Schedules</h1>
        <p>Available fitness sessions, trainers, and max attendance thresholds.</p>
    </div>
    <a href="{{ route('classes.create') }}" class="btn btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Schedule Class
    </a>
</div>

<div class="table-container" style="animation: fadeIn 0.4s ease-out;">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Class Name</th>
                <th>Instructor</th>
                <th>Schedule Time</th>
                <th>Booked / Capacity</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($classes as $class)
                <tr>
                    <td>#{{ $class->id }}</td>
                    <td style="font-weight: 500;">{{ $class->class_name }}</td>
                    <td>{{ $class->instructor_name }}</td>
                    <td>{{ $class->schedule_time->format('Y-m-d H:i') }}</td>
                    <td>
                        <span class="badge {{ $class->bookings_count >= $class->capacity ? 'badge-inactive' : 'badge-active' }}">
                            {{ $class->bookings_count }} / {{ $class->capacity }} spots
                        </span>
                    </td>
                    <td style="text-align: right; display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('classes.edit', $class) }}" class="btn btn-secondary btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('classes.destroy', $class) }}" method="POST" onsubmit="return confirm('Are you sure you want to cancel and delete this class? All associated reservations will be deleted.');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="color: var(--text-muted); text-align: center; padding: 3rem;">No workout classes scheduled yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
