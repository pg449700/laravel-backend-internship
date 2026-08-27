<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MemberController extends Controller
{
    public function index(): JsonResponse
    {
        $members = Member::with(['memberships', 'bookings'])->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $members,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:members,email'],
            'join_date' => ['required', 'date'],
        ]);

        $member = Member::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Member created successfully',
            'data' => $member,
        ], 201);
    }

    public function show(Member $member): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $member->load(['memberships', 'bookings.gymClass']),
        ]);
    }

    public function update(Request $request, Member $member): JsonResponse
    {
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('members', 'email')->ignore($member->id)],
            'join_date' => ['required', 'date'],
        ]);

        $member->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Member updated successfully',
            'data' => $member,
        ]);
    }

    public function destroy(Member $member): JsonResponse
    {
        $member->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Member deleted successfully',
        ]);
    }
}
