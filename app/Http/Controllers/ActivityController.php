<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Attachment;
use App\Http\Requests\StoreActivityRequest;
use App\Http\Requests\UpdateActivityRequest;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($activityId)
    {
        $activity = Activity::with('submissions')  // eager load submissions and their attachments
            ->find($activityId);

        if (!$activity) {
            return response()->json([
                'status' => false,
                'message' => 'Activity not found',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Activity and submissions retrieved successfully',
            'data' => $activity,
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
    public function store(StoreActivityRequest $request)
    {
        $validated = $request->validated();

        $activity = Activity::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Activity created successfully',
            'data' => $activity,
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Activity $activity)
    {
        $activity = Activity::with('attachments')->find($activity->id);
        return response()->json([
            'status' => 'success',
            'message' => 'Activity retrieved successfully',
            'data' => $activity,
        ], 200);
    }
    public function download($attachmentId)
    {
        // Find the attachment by ID

        $attachment = Attachment::findOrFail($attachmentId);

        // Ensure the authenticated user owns the submission
        $submission = Activity::findOrFail($attachment->submission_id);
        if ($submission->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized to access this file',
            ], 403);
        }

        // Get the file path from the attachment link
        $filePath = $attachment->link;
        
        // Check if the file exists in storage
        if (Storage::exists($filePath)) {
            return response()->download(Storage::path($filePath)); // Secure file download
        }

        return response()->json([
            'status' => false,
            'message' => 'File not found',
        ], 404);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Activity $activity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateActivityRequest $request, Activity $activity)
    {
        $validated = $request->validated();

        $activity->update($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Activity updated successfully',
            'data' => $activity,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Activity $activity)
    {
        //
    }

}
