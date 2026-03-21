<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;


class PatientController extends Controller
{
    public function createProfile()
    {
        $user = Auth::user();
        
        if ($user->patient) {
            return redirect()->route('dashboard')->with('info', 'You already have a patient profile.');
        }
        
        return view('patients.create-profile');
    }

    public function storeProfile(Request $request)
    {
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
            'medical_notes' => 'nullable|string',
        ]);

        if (!empty($validated['allergies'])) {
            $validated['allergies'] = array_map('trim', explode(',', $validated['allergies']));
        } else {
            $validated['allergies'] = null;
        }

        $validated['patient_code'] = 'PT-' . strtoupper(uniqid());
        $validated['user_id'] = Auth::id();
        $validated['email'] = $user->email;
        
        Patient::create($validated);
        $user->assignRole('patient');
        
        return redirect()->route('dashboard')->with('success', 'Patient profile created successfully.');
    }

    public function editProfile()
    {
        $user = Auth::user();
        
        if (!$user->patient) {
            return redirect()->route('patient.profile.create')->with('info', 'Please create a patient profile first.');
        }
        
        return view('patients.edit-profile', ['patient' => $user->patient]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        if (!$user->patient) {
            return redirect()->route('patient.profile.create')->with('info', 'Please create a patient profile first.');
        }
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|string',
            'medical_notes' => 'nullable|string',
        ]);

        if (!empty($validated['allergies'])) {
            $validated['allergies'] = array_map('trim', explode(',', $validated['allergies']));
        } else {
            $validated['allergies'] = null;
        }

        $user->patient->update($validated);
        
        return back()->with('success', 'Patient profile updated successfully.');
    }

    public function index(Request $request)
    {
        if (Gate::denies('viewAny', Patient::class)) {
            abort(403);
        }
        
        $query = Patient::query();
        
        if ($request->search) {
            $query->where('first_name', 'like', "%{$request->search}%")
                  ->orWhere('last_name', 'like', "%{$request->search}%")
                  ->orWhere('patient_code', 'like', "%{$request->search}%")
                  ->orWhere('phone', 'like', "%{$request->search}%");
        }
        
        $patients = $query->latest()->paginate(10);
        
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        if (Gate::denies('create', Patient::class)) {
            abort(403);
        }
        
        return view('patients.create');
    }

    public function store(Request $request)
    {
        if (Gate::denies('create', Patient::class)) {
            abort(403);
        }
        
        $user = Auth::user();
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|array',
            'medical_notes' => 'nullable|string',
        ]);

        $validated['patient_code'] = 'PT-' . strtoupper(uniqid());
        
        Patient::create($validated);
        
        return redirect()->route('patients.index')->with('success', 'Patient created successfully.');
    }

    public function show(Patient $patient)
    {
        if (Gate::denies('view', $patient)) {
            abort(403);
        }
        
        return view('patients.show', compact('patient'));
    }

    public function edit(Patient $patient)
    {
        if (Gate::denies('update', $patient)) {
            abort(403);
        }
        
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        if (Gate::denies('update', $patient)) {
            abort(403);
        }
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'blood_type' => 'nullable|string|max:5',
            'allergies' => 'nullable|array',
            'medical_notes' => 'nullable|string',
        ]);

        $patient->update($validated);
        
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    public function destroy(Patient $patient)
    {
        if (Gate::denies('delete', $patient)) {
            abort(403);
        }
        
        $patient->delete();
        
        return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
    }
}
