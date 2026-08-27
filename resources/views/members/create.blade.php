@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Member Registry</h1>
        <p>Register a new club member.</p>
    </div>
</div>

<div class="form-panel" style="max-width: 600px; margin: 0 auto; animation: slideUp 0.3s ease-out;">
    <div class="form-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="17" y1="11" x2="23" y2="11"></line></svg>
        Register New Member
    </div>
    <form action="{{ route('members.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name') }}" placeholder="e.g. John" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name') }}" placeholder="e.g. Doe" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" placeholder="e.g. john.doe@example.com" required>
        </div>
        <div class="form-group">
            <label for="join_date">Join Date</label>
            <input type="date" id="join_date" name="join_date" class="form-control" value="{{ old('join_date', date('Y-m-d')) }}" required>
        </div>
        <div class="form-actions">
            <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Register Member</button>
        </div>
    </form>
</div>
@endsection
