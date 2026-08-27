<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Membership;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function index(): View
    {
        $memberships = Membership::with('member')->orderBy('id', 'desc')->get();
        return view('memberships.index', compact('memberships'));
    }

    public function create(): View
    {
        $members = Member::orderBy('last_name', 'asc')->get();
        return view('memberships.create', compact('members'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'membership_type' => ['required', 'string', 'max:255'],
            'monthly_fee' => ['required', 'numeric', 'min:0.01'],
            'status' => ['required', 'string', 'in:Active,Inactive'],
        ]);

        Membership::create($validated);

        return redirect()->route('memberships.index')->with('success', 'Membership plan added successfully');
    }

    public function edit(Membership $membership): View
    {
        $members = Member::orderBy('last_name', 'asc')->get();
        return view('memberships.edit', compact('membership', 'members'));
    }

    public function update(Request $request, Membership $membership): RedirectResponse
    {
        $validated = $request->validate([
            'member_id' => ['required', 'exists:members,id'],
            'membership_type' => ['required', 'string', 'max:255'],
            'monthly_fee' => ['required', 'numeric', 'min:0.01'],
            'status' => ['required', 'string', 'in:Active,Inactive'],
        ]);

        $membership->update($validated);

        return redirect()->route('memberships.index')->with('success', 'Membership updated successfully');
    }

    public function destroy(Membership $membership): RedirectResponse
    {
        $membership->delete();

        return redirect()->route('memberships.index')->with('success', 'Membership deleted successfully');
    }
}
