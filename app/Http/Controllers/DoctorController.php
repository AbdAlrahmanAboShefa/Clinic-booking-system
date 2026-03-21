<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialization;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DoctorController extends Controller
{
    public function index(Request $request)
    {
        if (Gate::denies('viewAny', Doctor::class)) {
            abort(403);
        }
        
        $query = Doctor::with(['user', 'specialization']);
        
        if ($request->specialization) {
            $query->where('specialization_id', $request->specialization);
        }
        
        if ($request->available) {
            $query->where('is_available', $request->available === '1');
        }
        
        $doctors = $query->latest()->paginate(10);
        $specializations = Specialization::where('is_active', true)->get();
        
        return view('doctors.index', compact('doctors', 'specializations'));
    }

    public function create()
    {
        if (Gate::denies('create', Doctor::class)) {
            abort(403);
        }
        
        $specializations = Specialization::where('is_active', true)->get();
        $users = User::whereDoesntHave('doctor')
            ->whereDoesntHave('roles', function ($query) {
                $query->whereIn('name', ['admin', 'doctor']);
            })
            ->get();
        
        return view('doctors.create', compact('specializations', 'users'));
    }

    public function store(Request $request)
    {
        if (Gate::denies('create', Doctor::class)) {
            abort(403);
        }
        
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'specialization_id' => 'nullable|integer',
            'qualification' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
            'is_available' => 'nullable|boolean',
        ]);

        $user = User::findOrFail($validated['user_id']);
        
        if (!$user->hasRole('doctor')) {
            $user->assignRole('doctor');
        }
        
        Doctor::create([
            'user_id' => $user->id,
            'specialization_id' => $validated['specialization_id'] ?? null,
            'qualification' => $validated['qualification'],
            'license_number' => $validated['license_number'],
            'bio' => $validated['bio'],
            'is_available' => $request->boolean('is_available'),
        ]);
        
        return redirect()->route('doctors.index')->with('success', 'Doctor created successfully.');
    }

    public function show(Doctor $doctor)
    {
        if (Gate::denies('view', $doctor)) {
            abort(403);
        }
        
        $doctor->load(['user', 'specialization', 'schedules']);
        $appointments = $doctor->appointments()->with(['patient.user'])->latest()->paginate(10);
        
        return view('doctors.show', compact('doctor', 'appointments'));
    }

    public function edit(Doctor $doctor)
    {
        if (Gate::denies('update', $doctor)) {
            abort(403);
        }
        
        $specializations = Specialization::where('is_active', true)->get();
        
        return view('doctors.edit', compact('doctor', 'specializations'));
    }

    public function update(Request $request, Doctor $doctor)
    {
        if (Gate::denies('update', $doctor)) {
            abort(403);
        }
        
        $validated = $request->validate([
            'specialization_id' => 'nullable|exists:specializations,id',
            'qualification' => 'nullable|string|max:255',
            'license_number' => 'nullable|string|max:100',
            'bio' => 'nullable|string',
        ]);

        $doctor->update(array_merge($validated, [
            'is_available' => $request->boolean('is_available'),
        ]));
        
        return redirect()->route('doctors.index')->with('success', 'Doctor updated successfully.');
    }

    public function destroy(Doctor $doctor)
    {
        if (Gate::denies('delete', $doctor)) {
            abort(403);
        }
        
        if ($doctor->appointments()->whereIn('status', ['pending', 'confirmed'])->exists()) {
            return redirect()->route('doctors.index')->with('error', 'Cannot delete doctor with pending or confirmed appointments.');
        }
        
        $user = $doctor->user;
        $doctor->delete();
        $user->delete();
        
        return redirect()->route('doctors.index')->with('success', 'Doctor deleted successfully.');
    }
}
