<?php

namespace App\Http\Controllers;

use App\Models\Practicum;

class UserController extends Controller
{
    public function enroll($user_id, $practicum_id)
    {
        $practicum = Practicum::find($practicum_id);

        if (!$practicum) {
            return response()->json([
                'status' => false,
                'message' => 'Practicum not found',
            ], 404);
        }

        $practicum->users()->attach($user_id);

        return response()->json([
            'status' => true,
            'message' => 'User enrolled successfully',
        ]);
    }
}