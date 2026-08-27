@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Dashboard</h1>
        <p>Live status of club memberships, reservations, and trainer schedules.</p>
    </div>
</div>

<div class="grid-stats">
    <div class="stat-card">
        <span class="stat-title">Total Members</span>
        <span class="stat-value">{{ $totalMembers }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-title">Active Memberships</span>
        <span class="stat-value">{{ $activeMemberships }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-title">Scheduled Classes</span>
        <span class="stat-value">{{ $scheduledClasses }}</span>
    </div>
    <div class="stat-card">
        <span class="stat-title">Active Bookings</span>
        <span class="stat-value">{{ $activeBookings }}</span>
    </div>
</div>

<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; margin-top: 2rem;">
    <div>
        <h2 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Recent Reservations</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Member</th>
                        <th>Class</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentBookings as $booking)
                        <tr>
                            <td>{{ $booking->member ? $booking->member->full_name : 'Deleted Member' }}</td>
                            <td>{{ $booking->gymClass ? $booking->gymClass->class_name : 'Deleted Class' }}</td>
                            <td>{{ $booking->booking_date->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="color: var(--text-muted); text-align: center; padding: 2rem;">No recent reservations.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>
        <h2 style="font-size: 1.15rem; font-weight: 600; margin-bottom: 1rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.5px;">Upcoming Schedule</h2>
        <div class="table-container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Class Name</th>
                        <th>Instructor</th>
                        <th>Schedule Time</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($upcomingClasses as $class)
                        <tr>
                            <td>{{ $class->class_name }}</td>
                            <td>{{ $class->instructor_name }}</td>
                            <td>{{ $class->schedule_time->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="color: var(--text-muted); text-align: center; padding: 2rem;">No classes scheduled.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
