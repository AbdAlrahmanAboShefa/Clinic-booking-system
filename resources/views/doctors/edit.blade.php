@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Edit Doctor') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="border-2 border-black rounded-xl p-6">
                    @if($errors->any())
                        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('doctors.update', $doctor->id) }}">
                    @csrf
                    @method('PUT')
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="md:col-span-2">
                            <label class="label">Doctor Name</label>
                            <input type="text" value="{{ $doctor->user->name }}" class="input-field" disabled>
                        </div>
                        
                        <div>
                            <label class="label">Specialization</label>
                            <select name="specialization_id" class="input-field">
                                <option value="">Select Specialization</option>
                                @foreach($specializations as $spec)
                                <option value="{{ $spec->id }}" {{ $doctor->specialization_id == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="label">Qualification</label>
                            <input type="text" name="qualification" value="{{ $doctor->qualification }}" class="input-field">
                        </div>
                        
                        <div>
                            <label class="label">License Number</label>
                            <input type="text" name="license_number" value="{{ $doctor->license_number }}" class="input-field">
                        </div>
                        
                        <div class="md:col-span-2">
                            <label class="label">Bio</label>
                            <textarea name="bio" class="input-field" rows="3">{{ $doctor->bio }}</textarea>
                        </div>
                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_available" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" {{ $doctor->is_available ? 'checked' : '' }}>
                                <span class="ml-2 text-sm text-gray-600">Available for appointments</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('doctors.index') }}" class="btn-secondary mr-4">Cancel</a>
                        <button type="submit" class="btn-primary">Update Doctor</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
