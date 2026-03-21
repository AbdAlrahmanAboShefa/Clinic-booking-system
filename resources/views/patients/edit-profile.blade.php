@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Patient Profile') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="border-2 border-black rounded-xl p-6">
                    <p class="mb-4 text-gray-600">Update your patient information below.</p>
                    
                    <form method="POST" action="{{ route('patient.profile.update') }}">
                        @csrf
                        @method('PATCH')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="label">First Name</label>
                                <input type="text" name="first_name" class="input-field" value="{{ old('first_name', $patient->first_name) }}" required>
                            </div>
                            
                            <div>
                                <label class="label">Last Name</label>
                                <input type="text" name="last_name" class="input-field" value="{{ old('last_name', $patient->last_name) }}" required>
                            </div>
                            
                            <div>
                                <label class="label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="input-field" value="{{ old('date_of_birth', $patient->date_of_birth) }}">
                            </div>
                            
                            <div>
                                <label class="label">Gender</label>
                                <select name="gender" class="input-field">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="label">Phone</label>
                                <input type="text" name="phone" class="input-field" value="{{ old('phone', $patient->phone) }}" required>
                            </div>
                            
                            <div>
                                <label class="label">Email</label>
                                <input type="email" name="email" class="input-field" value="{{ old('email', $patient->email) }}">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="label">Address</label>
                                <textarea name="address" class="input-field" rows="2">{{ old('address', $patient->address) }}</textarea>
                            </div>
                            
                            <div>
                                <label class="label">Emergency Contact Name</label>
                                <input type="text" name="emergency_contact_name" class="input-field" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}">
                            </div>
                            
                            <div>
                                <label class="label">Emergency Contact Phone</label>
                                <input type="text" name="emergency_contact_phone" class="input-field" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}">
                            </div>
                            
                            <div>
                                <label class="label">Blood Type</label>
                                <input type="text" name="blood_type" class="input-field" value="{{ old('blood_type', $patient->blood_type) }}" placeholder="e.g., A+, O-">
                            </div>
                            
                            <div>
                                <label class="label">Allergies (comma separated)</label>
                                <input type="text" name="allergies" class="input-field" value="{{ is_array($patient->allergies) ? implode(', ', $patient->allergies) : $patient->allergies }}" placeholder="e.g., Penicillin, Pollen">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="label">Medical Notes</label>
                                <textarea name="medical_notes" class="input-field" rows="3">{{ old('medical_notes', $patient->medical_notes) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="btn-primary">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
