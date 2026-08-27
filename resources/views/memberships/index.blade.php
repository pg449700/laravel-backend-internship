@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Membership Plans</h1>
        <p>Manage subscription tiers and billing statuses.</p>
    </div>
    <a href="{{ route('memberships.create') }}" class="btn btn-primary">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
        Assign Plan
    </a>
</div>

<div class="table-container" style="animation: fadeIn 0.4s ease-out;">
    <table class="data-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Member</th>
                <th>Plan Type</th>
                <th>Monthly Rate</th>
                <th>Status</th>
                <th style="text-align: right;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($memberships as $membership)
                <tr>
                    <td>#{{ $membership->id }}</td>
                    <td>
                        @if($membership->member)
                            <div style="font-weight: 500;">{{ $membership->member->full_name }}</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">{{ $membership->member->email }}</div>
                        @else
                            <div style="color: var(--text-muted);">Deleted Member</div>
                        @endif
                    </td>
                    <td>{{ $membership->membership_type }}</td>
                    <td>${{ number_format($membership->monthly_fee, 2) }}</td>
                    <td>
                        <span class="badge {{ $membership->status === 'Active' ? 'badge-active' : 'badge-inactive' }}">
                            {{ $membership->status }}
                        </span>
                    </td>
                    <td style="text-align: right; display: flex; justify-content: flex-end; gap: 0.5rem;">
                        <a href="{{ route('memberships.edit', $membership) }}" class="btn btn-secondary btn-sm">
                            Edit
                        </a>
                        <form action="{{ route('memberships.destroy', $membership) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this membership plan?');" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="color: var(--text-muted); text-align: center; padding: 3rem;">No active membership records found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
