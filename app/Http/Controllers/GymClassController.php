<?php

namespace App\Http\Controllers;

use App\Models\GymClass;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GymClassController extends Controller
{
    public function index(): View
    {
        $classes = GymClass::withCount('bookings')->orderBy('id', 'desc')->get();
        return view('classes.index', compact('classes'));
    }

    public function create(): View
    {
        return view('classes.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'instructor_name' => ['required', 'string', 'max:255'],
            'schedule_time' => ['required', 'date'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        GymClass::create($validated);

        return redirect()->route('classes.index')->with('success', 'Class scheduled successfully');
    }

    public function edit(GymClass $class): View
    {
        return view('classes.edit', ['gymClass' => $class]);
    }

    public function update(Request $request, GymClass $class): RedirectResponse
    {
        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'instructor_name' => ['required', 'string', 'max:255'],
            'schedule_time' => ['required', 'date'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        $class->update($validated);

        return redirect()->route('classes.index')->with('success', 'Class updated successfully');
    }

    public function destroy(GymClass $class): RedirectResponse
    {
        $class->delete();

        return redirect()->route('classes.index')->with('success', 'Class deleted successfully');
    }
}
