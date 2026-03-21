<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use App\Notifications\NewAppointmentForDoctor;
use App\Notifications\AppointmentConfirmedForPatient;
use App\Notifications\AppointmentCancelledNotification;

class AppointmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Appointment::with(['patient', 'doctor']);
        
        $user = Auth::user();
        
        if ($user->hasRole('patient') && $user->patient) {
            $query->where('patient_id', $user->patient->id);
        } elseif ($user->hasRole('doctor') && $user->doctor) {
            $query->where('doctor_id', $user->doctor->id);
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->date) {
            $query->where('appointment_date', $request->date);
        }
        
        $appointments = $query->latest()->paginate(10);
        
        return view('appointments.index', compact('appointments'));
    }

    public function create()
    {
        $user = Auth::user();
        
        if ($user->hasRole('patient') && $user->patient) {
            $patient = $user->patient;
            $patients = collect([$patient]);
        } else {
            $patient = null;
            $patients = Patient::all();
        }
        
        $doctors = Doctor::with('user')->where('is_available', true)->get();
        
        return view('appointments.create', compact('patients', 'doctors', 'patient'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'type' => 'required|in:consultation,followup,procedure',
            'notes' => 'nullable|string',
        ]);
        
        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['error' => 'This time slot is already booked.'])->withInput();
        }
        
        $validated['status'] = 'pending';
        
       $appointment = Appointment::create($validated);
        $appointment->load(['patient', 'doctor.user']);
        $appointment->doctor->user->notify(new NewAppointmentForDoctor($appointment));
        
        return redirect()->route('appointments.index')->with('success', 'Appointment created successfully.');
    }

    public function show(Appointment $appointment)
    {
        if (Gate::denies('view', $appointment)) {
            abort(403);
        }
        
        $appointment->load(['patient', 'doctor', 'services']);
        
        return view('appointments.show', compact('appointment'));
    }

    public function edit(Appointment $appointment)
    {
        if (Gate::denies('update', $appointment)) {
            abort(403);
        }
        
        $patients = Patient::all();
        $doctors = Doctor::with('user')->get();
        
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    public function update(Request $request, Appointment $appointment)
    {
        if (Gate::denies('update', $appointment)) {
            abort(403);
        }
        
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'status' => 'required|in:pending,confirmed,completed,cancelled,no_show',
            'type' => 'required|in:consultation,followup,procedure',
            'notes' => 'nullable|string',
        ]);

        $conflict = Appointment::where('doctor_id', $validated['doctor_id'])
            ->where('appointment_date', $validated['appointment_date'])
            ->whereIn('status', ['pending', 'confirmed'])
            ->where('id', '!=', $appointment->id)
            ->where(function ($query) use ($validated) {
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>', $validated['start_time']);
                });
            })
            ->exists();

        if ($conflict) {
            return back()->withErrors(['error' => 'This time slot is already booked.'])->withInput();
        }
        
        $appointment->update($validated);
        
        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    public function destroy(Appointment $appointment)
    {
        if (Gate::denies('delete', $appointment)) {
            abort(403);
        }
        
        $appointment->delete();
        
        return redirect()->route('appointments.index')->with('success', 'Appointment deleted successfully.');
    }

    public function cancel(Request $request, Appointment $appointment)
    {
        if (Gate::denies('cancel', $appointment)) {
            abort(403);
        }
        
        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->reason,
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
        ]);
        
        $appointment->load(['patient', 'doctor.user']);
        $appointment->patient->user->notify(new AppointmentCancelledNotification($appointment));
        
        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled successfully.');
    }

    public function confirm(Appointment $appointment)
    {
        if (Gate::denies('confirm', $appointment)) {
            abort(403);
        }

        if ($appointment->status !== 'pending') {
            return redirect()->route('appointments.index')->with('error', 'Only pending appointments can be confirmed.');
        }

        $appointment->update(['status' => 'confirmed']);
        $appointment->load(['patient', 'doctor.user']);
        
        $appointment->patient->user->notify(new AppointmentConfirmedForPatient($appointment));

        return redirect()->route('appointments.index')->with('success', 'Appointment confirmed successfully.');
    }

    public function reject(Request $request, Appointment $appointment)
    {
        if (Gate::denies('reject', $appointment)) {
            abort(403);
        }

        if ($appointment->status !== 'pending') {
            return redirect()->route('appointments.index')->with('error', 'Only pending appointments can be rejected.');
        }

        $appointment->update([
            'status' => 'cancelled',
            'cancellation_reason' => $request->reason ?? 'Rejected by doctor',
            'cancelled_by' => auth()->id(),
            'cancelled_at' => now(),
        ]);
        
        $appointment->load(['patient', 'doctor.user']);
        $appointment->patient->user->notify(new AppointmentCancelledNotification($appointment));

        return redirect()->route('appointments.index')->with('success', 'Appointment rejected successfully.');
    }

    public function getAvailableSlots(Request $request)
{
    $request->validate([
        'doctor_id' => 'required|exists:doctors,id',
        'date' => 'required|date|after_or_equal:today',
    ]);

    $doctorId = $request->doctor_id;
    $date = $request->date;
    $dayOfWeek = date('w', strtotime($date));
    $duration = config('clinic.appointment_duration', 30);

    $schedule = DoctorSchedule::where('doctor_id', $doctorId)
        ->where('day_of_week', $dayOfWeek)
        ->where('is_active', true)
        ->first();

    // حددنا الأوقات من الـ schedule أو من الـ config
    $startTime = strtotime($schedule ? $schedule->start_time : config('clinic.default_start_time', '09:00'));
    $endTime   = strtotime($schedule ? $schedule->end_time   : config('clinic.default_end_time', '17:00'));

    // break time — بس إذا في schedule وعنده break
    $breakStart = ($schedule && $schedule->break_start) ? strtotime($schedule->break_start) : null;
    $breakEnd   = ($schedule && $schedule->break_end)   ? strtotime($schedule->break_end)   : null;

    // جيب الحجوزات المحجوزة بهاليوم
    $bookedAppointments = Appointment::where('doctor_id', $doctorId)
        ->where('appointment_date', $date)
        ->whereIn('status', ['confirmed', 'pending'])
        ->get(['start_time', 'end_time']);

    $slots = [];

    while ($startTime < $endTime) {
        $slotStart = date('H:i', $startTime);
        $slotEnd   = date('H:i', $startTime + ($duration * 60));

        // تحقق إذا الـ slot داخل وقت الـ break
        $isDuringBreak = $breakStart && $breakEnd
            && $startTime >= $breakStart
            && $startTime < $breakEnd;

        // تحقق إذا الـ slot محجوز
       $isBooked = $bookedAppointments->contains(function ($appointment) use ($slotStart) {
    $appStart = substr($appointment->start_time, 0, 5); // "09:00:00" → "09:00"
    $appEnd   = substr($appointment->end_time, 0, 5);
    
    return $slotStart >= $appStart && $slotStart < $appEnd;
});

        if (!$isDuringBreak && !$isBooked) {
            $slots[] = [
                'start' => $slotStart,
                'end'   => $slotEnd,
            ];
        }

        $startTime += ($duration * 60);
    }

    return response()->json($slots);
}
}
