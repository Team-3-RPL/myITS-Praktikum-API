<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Submission;
use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSubmissionRequest;
use App\Http\Requests\UpdateSubmissionRequest;

class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store($activity_id, StoreSubmissionRequest $request)
    {
        $validated = $request->validated();

        $submission = Submission::create([
            'comment' => $validated['comment'],
            'activity_id' => $activity_id,
            'user_id' => auth()->id(),
        ]);

        // Upload file to storage/private/submissions
        if (!empty($validated['files'])) {
            foreach ($validated['files'] as $file) {
                $path = $file->store('submissions');

                $submission->attachments()->create([
                    'submission_id' => $submission->id,
                    'link' => $path,
                    'filename' => $file->getClientOriginalName(),
                    'activity_id' => $activity_id,
                ]);
            }
        }

        return response()->json([
            'status' => true,
            'message' => 'Submission created successfully',
            'data' => $submission->load('attachments'),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($activity_id)
    {
        $userId = auth()->id();
        $submission = Submission::with('attachments')
            ->where('user_id', $userId)
            ->where('activity_id', $activity_id)
            ->first();

        if (!$submission) {
            return response()->json([
                'status' => false,
                'message' => 'Submission not found for this activity.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Submission retrieved successfully',
            'data' => $submission,
        ]);
    }
    public function gradeSubmission($submissionId, Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
        ]);

        // Find the submission by ID
        $submission = Submission::findOrFail($submissionId);

        // Ensure the authenticated user is an assistant
        /*if (!auth()->user()->hasRole('assistant')) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized to grade this submission',
            ], 403);
        }*/

        // Update the submission with the grade
        $submission->update([
            'grade' => $validated['grade'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Submission graded successfully',
            'data' => $submission,
        ]);
    }
    public function download($attachmentId)
    {
        // Find the attachment by ID

        $attachment = Attachment::findOrFail($attachmentId);

        // Ensure the authenticated user owns the submission
        $submission = Submission::findOrFail($attachment->submission_id);
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
    public function deleteAttachment($attachmentId)
    {
        // Find the attachment by ID
        $attachment = Attachment::findOrFail($attachmentId);

        // Ensure the authenticated user owns the submission
        $submission = Submission::findOrFail($attachment->submission_id);
        if ($submission->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized to delete this file',
            ], 403);
        }

        // Delete the file from storage
        Storage::delete($attachment->link);

        // Delete the attachment record
        $attachment->delete();

        return response()->json([
            'status' => true,
            'message' => 'File deleted successfully',
        ]);
    }
    public function addFile($activity_id, Request $request)
    {
        // Validate: multiple files allowed, each file max 10MB
        $validated = $request->validate([
            'files' => 'required|array',
            'files.*' => 'file|max:10240', // 10MB max per file
        ]);

        // Find the user's submission for this activity
        $submission = Submission::where('activity_id', $activity_id)
            ->where('user_id', auth()->id())
            ->first();

        if (!$submission) {
            return response()->json([
                'status' => false,
                'message' => 'Submission not found for this activity.',
            ], 404);
        }

        // Store each file
        foreach ($request->file('files') as $file) {
            $path = $file->store('submissions'); // private storage

            $submission->attachments()->create([
                'submission_id' => $submission->id,
                'link' => $path,
                'filename' => $file->getClientOriginalName(),
                'activity_id' => $activity_id,
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Files added successfully',
            'data' => $submission->load('attachments'),
        ], 201);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Submission $submission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSubmissionRequest $request, Submission $submission)
    {
        $validated = $request->validated();

        $submission->update([
            'comment' => $validated['comment'],
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Comment updated successfully',
            'data' => $submission,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Submission $submission)
    {
        // Ensure the authenticated user owns the submission
        if ($submission->user_id !== auth()->id()) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthorized to delete this submission',
            ], 403);
        }

        // Delete the submission and its attachments
        $submission->attachments()->each(function ($attachment) {
            Storage::delete($attachment->link); // Delete the file from storage
            $attachment->delete(); // Delete the attachment record
        });

        $submission->delete(); // Delete the submission record

        return response()->json([
            'status' => true,
            'message' => 'Submission deleted successfully',
        ]);
    }
}
