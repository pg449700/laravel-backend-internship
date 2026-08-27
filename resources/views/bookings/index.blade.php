@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Class Bookings</h1>
        <p>Active roster and seat reservations for upcoming classes.</p>
    </div>
    <a href="{{ route('bookings.create') }}" class="btn btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        New Booking
    </a>
</div>

<div class="table-container" style="animation: fadeIn 0.4s ease-out;">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Member</th>
                <th>Class</th>
                <th>Schedule</th>
                <th>Booking Timestamp</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
                <tr>
                    <td>#{{ $booking->id }}</td>
                    <td>
                        @if($booking->member)
                            <div style="font-weight: 500;">{{ $booking->member->full_name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $booking->member->email }}</div>
                        @else
                            <div style="color: var(--text-muted);">Deleted Member</div>
                        @endif
                    </td>
                    <td>
                        @if($booking->gymClass)
                            <div style="font-weight: 500;">{{ $booking->gymClass->class_name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Trainer: {{ $booking->gymClass->instructor_name }}</div>
                        @else
                            <div style="color: var(--text-muted);">Deleted Class</div>
                        @endif
                    </td>
                    <td>
                        @if($booking->gymClass)
                            {{ $booking->gymClass->schedule_time->format('Y-m-d H:i') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $booking->booking_date->format('Y-m-d H:i:s') }}</td>
                    <td style="text-align: right;">
                        <form action="{{ route('bookings.destroy', $booking) }}" method="POST" onsubmit="return confirm('Cancel and delete this reservation?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Cancel Booking</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="color: var(--text-muted); text-align: center; padding: 3rem;">No seat bookings recorded.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
