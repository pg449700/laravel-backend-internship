@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Member Registry</h1>
        <p>Directory of registered club members and contact details.</p>
    </div>
    <a href="{{ route('members.create') }}" class="btn btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Register Member
    </a>
</div>

<div class="table-container" style="animation: fadeIn 0.4s ease-out;">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Join Date</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
                <tr>
                    <td>#{{ $member->id }}</td>
                    <td style="font-weight: 500;">{{ $member->full_name }}</td>
                    <td>{{ $member->email }}</td>
                    <td>{{ $member->join_date->format('Y-m-d') }}</td>
                    <td style="text-align: right; display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('members.edit', $member) }}" class="btn btn-secondary btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('members.destroy', $member) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this member? All their bookings and memberships will be deleted too.');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="color: var(--text-muted); text-align: center; padding: 3rem;">No members registered yet.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
