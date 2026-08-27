<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\GymClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class BookingController extends Controller
{
    public function index(): JsonResponse
    {
        $bookings = Booking::with(['member', 'gymClass'])->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $bookings,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'class_id' => ['required', 'exists:gym_classes,id'],
        ]);

        $alreadyBooked = Booking::where('member_id', $validated['member_id'])
            ->where('class_id', $validated['class_id'])
            ->exists();

        if ($alreadyBooked) {
            return response()->json([
                'status' => 'error',
                'message' => 'This member is already booked for this class.',
            ], 422);
        }

        $gymClass = GymClass::withCount('bookings')->findOrFail($validated['class_id']);

        if ($gymClass->bookings_count >= $gymClass->capacity) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cannot book class: Capacity limit reached.',
            ], 422);
        }

        $booking = Booking::create([
            'member_id' => $validated['member_id'],
            'class_id' => $validated['class_id'],
            'booking_date' => now(),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Booking confirmed successfully',
            'data' => $booking->load(['member', 'gymClass']),
        ], 201);
    }

    public function show(Booking $booking): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $booking->load(['member', 'gymClass']),
        ]);
    }

    public function destroy(Booking $booking): JsonResponse
    {
        $booking->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Booking cancelled successfully',
        ]);
    }
}
