@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Complete Your Patient Profile') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="border-2 border-black rounded-xl p-6">
                    <p class="mb-4 text-gray-600">Please complete your patient information below.</p>
                    
                    <form method="POST" action="{{ route('patient.profile.store') }}">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="label">First Name</label>
                                <input type="text" name="first_name" value="{{ explode(' ', auth()->user()->name)[0] ?? '' }}" class="input-field" required>
                            </div>
                            
                            <div>
                                <label class="label">Last Name</label>
                                <input type="text" name="last_name" value="{{ implode(' ', array_slice(explode(' ', auth()->user()->name), 1)) ?? '' }}" class="input-field" required>
                            </div>
                            
                            <div>
                                <label class="label">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="input-field">
                            </div>
                            
                            <div>
                                <label class="label">Gender</label>
                                <select name="gender" class="input-field">
                                    <option value="">Select Gender</option>
                                    <option value="male">Male</option>
                                    <option value="female">Female</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="label">Phone</label>
                                <input type="text" name="phone" class="input-field" required>
                            </div>
                            
                            <div>
                                <label class="label">Email</label>
                                <input type="email" value="{{ auth()->user()->email }}" class="input-field bg-gray-100" readonly>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="label">Address</label>
                                <textarea name="address" class="input-field" rows="2"></textarea>
                            </div>
                            
                            <div>
                                <label class="label">Emergency Contact Name</label>
                                <input type="text" name="emergency_contact_name" class="input-field">
                            </div>
                            
                            <div>
                                <label class="label">Emergency Contact Phone</label>
                                <input type="text" name="emergency_contact_phone" class="input-field">
                            </div>
                            
                            <div>
                                <label class="label">Blood Type</label>
                                <input type="text" name="blood_type" class="input-field" placeholder="e.g., A+, O-">
                            </div>
                            
                            <div>
                                <label class="label">Allergies (comma separated)</label>
                                <input type="text" name="allergies" class="input-field" placeholder="e.g., Penicillin, Pollen">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="label">Medical Notes</label>
                                <textarea name="medical_notes" class="input-field" rows="3"></textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="btn-primary">Save Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
