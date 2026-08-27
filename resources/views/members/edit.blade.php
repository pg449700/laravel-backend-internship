@extends('layouts.app')

@section('content')
<div class="page-header">
    <div class="page-title">
        <h1>Member Registry</h1>
        <p>Modify club member profile.</p>
    </div>
</div>

<div class="form-panel" style="max-width: 600px; margin: 0 auto; animation: slideUp 0.3s ease-out;">
    <div class="form-title">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
        Modify Profile: {{ $member->full_name }}
    </div>
    <form action="{{ route('members.update', $member) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" class="form-control" value="{{ old('first_name', $member->first_name) }}" required>
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" class="form-control" value="{{ old('last_name', $member->last_name) }}" required>
        </div>
        <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $member->email) }}" required>
        </div>
        <div class="form-group">
            <label for="join_date">Join Date</label>
            <input type="date" id="join_date" name="join_date" class="form-control" value="{{ old('join_date', $member->join_date->format('Y-m-d')) }}" required>
        </div>
        <div class="form-actions">
            <a href="{{ route('members.index') }}" class="btn btn-secondary">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Member</button>
        </div>
    </form>
</div>
@endsection
