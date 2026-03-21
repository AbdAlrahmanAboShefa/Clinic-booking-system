@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Add Schedule') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="border-2 border-black rounded-xl p-6">
                <form method="POST" action="{{ route('schedules.store') }}">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @if(!Auth::user()->hasRole('doctor'))
                        <div>
                            <label class="label">Doctor</label>
                            <select name="doctor_id" class="input-field" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->user->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif
                        
                        <div>
                            <label class="label">Day of Week</label>
                            <select name="day_of_week" class="input-field" required>
                                <option value="">Select Day</option>
                                <option value="Sunday">Sunday</option>
                                <option value="Monday">Monday</option>
                                <option value="Tuesday">Tuesday</option>
                                <option value="Wednesday">Wednesday</option>
                                <option value="Thursday">Thursday</option>
                                <option value="Friday">Friday</option>
                                <option value="Saturday">Saturday</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="label">Start Time</label>
                            <input type="time" name="start_time" class="input-field" required>
                        </div>
                        
                        <div>
                            <label class="label">End Time</label>
                            <input type="time" name="end_time" class="input-field" required>
                        </div>
                        
                        <div>
                            <label class="label">Break Start (Optional)</label>
                            <input type="time" name="break_start" class="input-field">
                        </div>
                        
                        <div>
                            <label class="label">Break End (Optional)</label>
                            <input type="time" name="break_end" class="input-field">
                        </div>
                        
                        <div>
                            <label class="flex items-center">
                                <input type="checkbox" name="is_active" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500" checked value="1">
                                <span class="ml-2 text-sm text-gray-600">Active</span>
                            </label>
                        </div>
                    </div>
                    
                    <div class="flex justify-end mt-6">
                        <a href="{{ route('schedules.index') }}" class="btn-secondary mr-4">Cancel</a>
                        <button type="submit" class="btn-primary">Create Schedule</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
