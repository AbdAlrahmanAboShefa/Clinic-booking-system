<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ScheduleController extends Controller
{
    private array $dayMapping = [
        'Sunday' => 0,
        'Monday' => 1,
        'Tuesday' => 2,
        'Wednesday' => 3,
        'Thursday' => 4,
        'Friday' => 5,
        'Saturday' => 6,
    ];
    public function index(Request $request)
    {
        if (Gate::denies('viewAny', DoctorSchedule::class)) {
            abort(403);
        }
        
        if (Auth::user()->hasRole('doctor') && Auth::user()->doctor) {
            $doctors = Doctor::with(['user', 'schedules'])
                ->where('id', Auth::user()->doctor->id)
                ->get();
        } else {
            $doctors = Doctor::with(['user', 'schedules'])->get();
        }
        
        return view('schedules.index', compact('doctors'));
    }

    public function create()
    {
        if (Gate::denies('create', DoctorSchedule::class)) {
            abort(403);
        }
        
        if (Auth::user()->hasRole('doctor') && Auth::user()->doctor) {
            $doctors = Doctor::with('user')
                ->where('id', Auth::user()->doctor->id)
                ->get();
        } else {
            $doctors = Doctor::with('user')->get();
        }
        
        return view('schedules.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        if (Gate::denies('create', DoctorSchedule::class)) {
            abort(403);
        }
        
        $validated = $request->validate([
            'day_of_week' => 'required|string|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'break_start' => 'nullable',
            'break_end' => 'nullable',
            'is_active' => 'boolean',
        ]);

        if (Auth::user()->hasRole('doctor') && Auth::user()->doctor) {
            $validated['doctor_id'] = Auth::user()->doctor->id;
        } else {
            $validated['doctor_id'] = $request->doctor_id;
        }
        
        $validated['day_of_week'] = $this->dayMapping[$validated['day_of_week']];
        
        DoctorSchedule::create($validated);
        
        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    public function edit(DoctorSchedule $schedule)
    {
        if (Gate::denies('update', $schedule)) {
            abort(403);
        }
        
        $doctors = Doctor::with('user')->get();
        
        return view('schedules.edit', compact('schedule', 'doctors'));
    }

    public function update(Request $request, DoctorSchedule $schedule)
    {
        if (Gate::denies('update', $schedule)) {
            abort(403);
        }
        
        $validated = $request->validate([
            'day_of_week' => 'required|string|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'break_start' => 'nullable',
            'break_end' => 'nullable',
            'is_active' => 'boolean',
        ]);

        $validated['day_of_week'] = $this->dayMapping[$validated['day_of_week']];
        $schedule->update($validated);
        
        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    public function destroy(DoctorSchedule $schedule)
    {
        if (Gate::denies('delete', $schedule)) {
            abort(403);
        }
        
        $schedule->delete();
        
        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}
