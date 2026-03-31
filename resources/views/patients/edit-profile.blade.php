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
                                <label class="block text-sm font-medium text-gray-700">First Name</label>
                                <input type="text" name="first_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('first_name', $patient->first_name) }}" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Name</label>
                                <input type="text" name="last_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('last_name', $patient->last_name) }}" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                <input type="date" name="date_of_birth" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('date_of_birth', $patient->date_of_birth) }}">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Gender</label>
                                <select name="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500">
                                    <option value="">Select Gender</option>
                                    <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                    <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                    <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Phone</label>
                                <input type="text" name="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('phone', $patient->phone) }}" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('email', $patient->email) }}">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Address</label>
                                <textarea name="address" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" rows="2">{{ old('address', $patient->address) }}</textarea>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Emergency Contact Name</label>
                                <input type="text" name="emergency_contact_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('emergency_contact_name', $patient->emergency_contact_name) }}">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Emergency Contact Phone</label>
                                <input type="text" name="emergency_contact_phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('emergency_contact_phone', $patient->emergency_contact_phone) }}">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Blood Type</label>
                                <input type="text" name="blood_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ old('blood_type', $patient->blood_type) }}" placeholder="e.g., A+, O-">
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Allergies (comma separated)</label>
                                <input type="text" name="allergies" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" value="{{ is_array($patient->allergies) ? implode(', ', $patient->allergies) : $patient->allergies }}" placeholder="e.g., Penicillin, Pollen">
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Medical Notes</label>
                                <textarea name="medical_notes" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-primary-500 focus:border-primary-500" rows="3">{{ old('medical_notes', $patient->medical_notes) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="submit" class="bg-primary-600 text-white px-4 py-2 rounded-md hover:bg-primary-700">Update Profile</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
