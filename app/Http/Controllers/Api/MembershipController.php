<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MembershipController extends Controller
{
    public function index(): JsonResponse
    {
        $memberships = Membership::with('member')->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $memberships,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'membership_type' => ['required', 'string', 'max:255'],
            'monthly_fee' => ['required', 'numeric', 'min:0.01'],
            'status' => ['required', 'string', 'in:Active,Inactive'],
        ]);

        $membership = Membership::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Membership created successfully',
            'data' => $membership->load('member'),
        ], 201);
    }

    public function show(Membership $membership): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $membership->load('member'),
        ]);
    }

    public function update(Request $request, Membership $membership): JsonResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'membership_type' => ['required', 'string', 'max:255'],
            'monthly_fee' => ['required', 'numeric', 'min:0.01'],
            'status' => ['required', 'string', 'in:Active,Inactive'],
        ]);

        $membership->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Membership updated successfully',
            'data' => $membership->load('member'),
        ]);
    }

    public function destroy(Membership $membership): JsonResponse
    {
        $membership->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Membership deleted successfully',
        ]);
    }
}
