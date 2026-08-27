<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\GymClass;
use App\Models\Member;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function index(): View
    {
        $bookings = Booking::with(['member', 'gymClass'])->orderBy('id', 'desc')->get();
        return view('bookings.index', compact('bookings'));
    }

    public function create(): View
    {
        $members = Member::orderBy('last_name', 'asc')->get();
        $classes = GymClass::withCount('bookings')->orderBy('schedule_time', 'asc')->get();
        return view('bookings.create', compact('members', 'classes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'class_id' => ['required', 'exists:gym_classes,id'],
        ]);

        $alreadyBooked = Booking::where('member_id', $validated['member_id'])
            ->where('class_id', $validated['class_id'])
            ->exists();

        if ($alreadyBooked) {
            throw ValidationException::withMessages([
                'member_id' => 'This member is already booked for this class.',
            ]);
        }

        $gymClass = GymClass::withCount('bookings')->findOrFail($validated['class_id']);

        if ($gymClass->bookings_count >= $gymClass->capacity) {
            throw ValidationException::withMessages([
                'class_id' => 'Cannot book class: Capacity limit reached.',
            ]);
        }

        Booking::create([
            'member_id' => $validated['member_id'],
            'class_id' => $validated['class_id'],
            'booking_date' => now(),
        ]);

        return redirect()->route('bookings.index')->with('success', 'Booking confirmed successfully');
    }

    public function destroy(Booking $booking): RedirectResponse
    {
        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking cancelled successfully');
    }
}
