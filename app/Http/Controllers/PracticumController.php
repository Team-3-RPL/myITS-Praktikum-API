<?php

namespace App\Http\Controllers;

use App\Models\Practicum;
use App\Models\Activity;
use App\Http\Requests\StorePracticumRequest;
use App\Http\Requests\UpdatePracticumRequest;

class PracticumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        $practicums = $user->practicums()->get();

        return response()->json([
            'status' => true,
            'message' => 'Practicums retrieved successfully',
            'data' => $practicums,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePracticumRequest $request)
    {
        $validated = $request->validated();

        $practicum = Practicum::create($validated);

        return response()->json([
            'status' => 'true',
            'message' => 'Practicum created successfully',
            'data' => $practicum,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Practicum $practicum)
    {
        $user = auth()->user();
        $isEnrolled = $user->practicums()->where('practicum_id', $practicum->id)->exists();

        if (!$isEnrolled) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized',
            ], 403);
        }
        $practicum = Practicum::with('activities')->find($practicum->id);

        return response()->json([
            'status' => true,
            'message' => 'Practicum retrieved successfully',
            'data' => $practicum,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Practicum $practicum)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePracticumRequest $request, Practicum $practicum)
    {
        $validated = $request->validated();

        $practicum = Practicum::update($validated);

        return response()->json([
            'status' => 'true',
            'message' => 'Practicum updated successfully',
            'data' => $practicum,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Practicum $practicum)
    {
        $practicum->delete();

        return response()->json([
            'status' => 'true',
            'message' => 'Practicum deleted successfully',
        ], 200);
    }
}
