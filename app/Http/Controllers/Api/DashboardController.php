<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\GymClass;
use App\Models\Member;
use App\Models\Membership;
use Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        $totalMembers = Member::count();
        $activeMemberships = Membership::where('status', 'Active')->count();
        $scheduledClasses = GymClass::count();
        $activeBookings = Booking::count();

        $recentBookings = Booking::with(['member', 'gymClass'])
            ->latest('booking_date')
            ->take(5)
            ->get();

        $upcomingClasses = GymClass::orderBy('schedule_time', 'asc')
            ->take(5)
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => [
                'metrics' => [
                    'total_members' => $totalMembers,
                    'active_memberships' => $activeMemberships,
                    'scheduled_classes' => $scheduledClasses,
                    'active_bookings' => $activeBookings,
                ],
                'recent_bookings' => $recentBookings,
                'upcoming_classes' => $upcomingClasses,
            ],
        ]);
    }
}
