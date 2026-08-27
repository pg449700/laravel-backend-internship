<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\GymClass;
use App\Models\Member;
use App\Models\Membership;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
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

        return view('dashboard', compact(
            'totalMembers',
            'activeMemberships',
            'scheduledClasses',
            'activeBookings',
            'recentBookings',
            'upcomingClasses'
        ));
    }
}
