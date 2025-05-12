<?php

namespace App\Http\Requests;

use App\Models\Activity;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class StoreSubmissionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user();

        $activityId = $this->route('activity_id') ?? $this->input('activity_id');

        if (!$activityId || !$user) {
            return false;
        }else if (Submission::where('user_id', $user->id)->where('activity_id', $activityId)->exists()) {
            return false; // User has already submitted for this activity
        }
        $activity = Activity::with('practicum')->find($activityId);
        if (!$activity || !$activity->has_submission) {
            return false; // Submissions are not allowed for this activity
        }
        return Activity::where('id', $activityId)
            ->whereHas('practicum.users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'comment' => 'required|string|max:255',
            'files' => 'nullable|array',
            'files.*' => 'file|max:10240', // File validations (example: 10MB max)
        ];
    }
}
