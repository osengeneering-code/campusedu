<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\User; // Added
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ActivityLogController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) // Added Request $request
    {
        $this->authorize('viewAny', ActivityLog::class);

        $query = ActivityLog::with(['user', 'entreprise']);

        // Filter by user if user_id is provided in the request
        if ($request->has('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $activityLogs = $query->oldest()->paginate(); // Changed to oldest()
        $users = User::all(); // Get all users for the filter list

        return view('activitylogs.index', compact('activityLogs', 'users')); // Pass users to the view
    }

    /**
     * Display the specified resource.
     */
    public function show(ActivityLog $activityLog)
    {
        $this->authorize('view', $activityLog);

        $activityLog->load(['user', 'entreprise']);

        return view('activitylogs.show', compact('activityLog'));
    }
}
