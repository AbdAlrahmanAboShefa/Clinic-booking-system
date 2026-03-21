<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $query = Activity::with('causer');

        if ($request->log_name) {
            $query->where('log_name', $request->log_name);
        }

        if ($request->causer_id) {
            $query->where('causer_id', $request->causer_id);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $activities = $query->latest()->paginate(20);

        $logNames = Activity::distinct()->pluck('log_name')->filter();

        return view('admin.activity-log.index', compact('activities', 'logNames'));
    }

    public function show(Activity $activity)
    {
        $activity->load('causer', 'subject');

        return view('admin.activity-log.show', compact('activity'));
    }
}
