@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Membership Plans</h1>
        <p>Edit membership subscription.</p>
    </div>
</div>

<div class="form-panel" style="max-width: 600px; margin: 0 auto; animation: slideUp 0.3s ease-out;">
    <div class="form-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
        Modify Membership #{{ $membership->id }}
    </div>
    <form action="{{ route('memberships.update', $membership) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="member_id">Select Member</label>
            <select id="member_id" name="member_id" class="form-control" required>
                @foreach($members as $m)
                    <option value="{{ $m->id }}" {{ old('member_id', $membership->member_id) == $m->id ? 'selected' : '' }}>
                        {{ $m->last_name }}, {{ $m->first_name }} (#{{ $m->id }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="membership_type">Membership Tier</label>
            <select id="membership_type" name="membership_type" class="form-control" required>
                <option value="Basic" {{ old('membership_type', $membership->membership_type) === 'Basic' ? 'selected' : '' }}>Basic Plan</option>
                <option value="Standard" {{ old('membership_type', $membership->membership_type) === 'Standard' ? 'selected' : '' }}>Standard Plan</option>
                <option value="Premium" {{ old('membership_type', $membership->membership_type) === 'Premium' ? 'selected' : '' }}>Premium VIP</option>
            </select>
        </div>
        <div class="form-group">
            <label for="monthly_fee">Monthly Fee ($)</label>
            <input type="number" step="0.01" id="monthly_fee" name="monthly_fee" class="form-control" value="{{ old('monthly_fee', $membership->monthly_fee) }}" required>
        </div>
        <div class="form-group">
            <label for="status">Membership Status</label>
            <select id="status" name="status" class="form-control" required>
                <option value="Active" {{ old('status', $membership->status) === 'Active' ? 'selected' : '' }}>Active</option>
                <option value="Inactive" {{ old('status', $membership->status) === 'Inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>
        <div class="form-actions">
            <a href="{{ route('memberships.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Membership</button>
        </div>
    </form>
</div>
@endsection
