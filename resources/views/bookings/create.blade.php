@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Class Bookings</h1>
        <p>Reserve a workout spot for a club member.</p>
    </div>
</div>

<div class="form-panel" style="max-width: 600px; margin: 0 auto; animation: slideUp 0.3s ease-out;">
    <div class="form-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
        Create Reservation
    </div>
    <form action="{{ route('bookings.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="member_id">Select Member</label>
            <select id="member_id" name="member_id" class="form-control" required>
                <option value="">-- Choose Member --</option>
                @foreach($members as $m)
                    <option value="{{ $m->id }}" {{ old('member_id') == $m->id ? 'selected' : '' }}>
                        {{ $m->last_name }}, {{ $m->first_name }} ({{ $m->email }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="class_id">Select Class Session</label>
            <select id="class_id" name="class_id" class="form-control" required>
                <option value="">-- Choose Class --</option>
                @foreach($classes as $c)
                    <option value="{{ $c->id }}" {{ old('class_id') == $c->id ? 'selected' : '' }} {{ $c->bookings_count >= $c->capacity ? 'disabled' : '' }}>
                        {{ $c->class_name }} &bull; {{ $c->instructor_name }} &bull; {{ $c->schedule_time->format('M d, H:i') }} ({{ $c->bookings_count }}/{{ $c->capacity }} booked) {{ $c->bookings_count >= $c->capacity ? '[FULL]' : '' }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-actions">
            <a href="{{ route('bookings.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Confirm Reservation</button>
        </div>
    </form>
</div>
@endsection
