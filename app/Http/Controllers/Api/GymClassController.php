<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GymClass;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GymClassController extends Controller
{
    public function index(): JsonResponse
    {
        $classes = GymClass::withCount('bookings')->orderBy('id', 'desc')->get();
        return response()->json([
            'status' => 'success',
            'data' => $classes,
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'instructor_name' => ['required', 'string', 'max:255'],
            'schedule_time' => ['required', 'date'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        $gymClass = GymClass::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Class created successfully',
            'data' => $gymClass,
        ], 201);
    }

    public function show(GymClass $class): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'data' => $class->load('bookings.member'),
        ]);
    }

    public function update(Request $request, GymClass $class): JsonResponse
    {
        $validated = $request->validate([
            'class_name' => ['required', 'string', 'max:255'],
            'instructor_name' => ['required', 'string', 'max:255'],
            'schedule_time' => ['required', 'date'],
            'capacity' => ['required', 'integer', 'min:1'],
        ]);

        $class->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Class updated successfully',
            'data' => $class,
        ]);
    }

    public function destroy(GymClass $class): JsonResponse
    {
        $class->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Class deleted successfully',
        ]);
    }
}
