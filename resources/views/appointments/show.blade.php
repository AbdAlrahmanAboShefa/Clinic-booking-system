@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Appointment Details') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="mb-6 flex justify-between items-center">
                    <h3 class="text-lg font-semibold">Appointment #{{ $appointment->id }}</h3>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full 
                        @switch($appointment->status)
                            @case('confirmed') bg-green-100 text-green-800 @break
                            @case('pending') bg-yellow-100 text-yellow-800 @break
                            @case('completed') bg-blue-100 text-blue-800 @break
                            @case('cancelled') bg-red-100 text-red-800 @break
                            @case('no_show') bg-gray-100 text-gray-800 @break
                        @endswitch">
                        {{ ucfirst($appointment->status) }}
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="border p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-700 mb-3 border-b pb-2">Date & Time</h4>
                        <p><span class="text-gray-600">Date:</span> {{ $appointment->appointment_date }}</p>
                        <p><span class="text-gray-600">Time:</span> {{ $appointment->start_time }} - {{ $appointment->end_time }}</p>
                        <p><span class="text-gray-600">Type:</span> {{ ucfirst($appointment->type) }}</p>
                    </div>

                    <div class="border p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-700 mb-3 border-b pb-2">Patient Information</h4>
                        <p><span class="text-gray-600">Name:</span> {{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</p>
                        <p><span class="text-gray-600">Phone:</span> {{ $appointment->patient->phone }}</p>
                        <p><span class="text-gray-600">Email:</span> {{ $appointment->patient->email ?? 'N/A' }}</p>
                    </div>

                    <div class="border p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-700 mb-3 border-b pb-2">Doctor Information</h4>
                        <p><span class="text-gray-600">Name:</span> {{ $appointment->doctor->user->name }}</p>
                        <p><span class="text-gray-600">Specialization:</span> {{ $appointment->doctor->specialization->name ?? 'N/A' }}</p>
                    </div>

                    @if($appointment->notes)
                    <div class="border p-4 rounded-lg md:col-span-2">
                        <h4 class="font-semibold text-gray-700 mb-3 border-b pb-2">Notes</h4>
                        <p>{{ $appointment->notes }}</p>
                    </div>
                    @endif

                    @if($appointment->status === 'cancelled' && $appointment->cancellation_reason)
                    <div class="border p-4 rounded-lg md:col-span-2 border-red-200 bg-red-50">
                        <h4 class="font-semibold text-red-700 mb-3 border-b pb-2">Cancellation Details</h4>
                        <p><span class="text-gray-600">Reason:</span> {{ $appointment->cancellation_reason }}</p>
                        @if($appointment->cancelled_at)
                        <p><span class="text-gray-600">Cancelled At:</span> {{ $appointment->cancelled_at }}</p>
                        @endif
                    </div>
                    @endif
                </div>

                <div class="mt-6 flex gap-4">
                    @if(auth()->user()->hasRole('doctor') && $appointment->status === 'pending' && $appointment->doctor_id === auth()->user()->doctor->id)
                        <form action="{{ route('appointments.confirm', $appointment) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-primary bg-green-600 hover:bg-green-700">Confirm Appointment</button>
                        </form>
                        <form action="{{ route('appointments.reject', $appointment) }}" method="POST" onsubmit="return confirm('Are you sure you want to reject this appointment?');">
                            @csrf
                            <button type="submit" class="btn-danger bg-red-600 hover:bg-red-700">Reject Appointment</button>
                        </form>
                    @endif

                    @can('appointments.edit')
                        @if($appointment->status !== 'cancelled' && $appointment->status !== 'completed')
                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn-secondary">Edit Appointment</a>
                        @endif
                    @endcan

                    <a href="{{ route('appointments.index') }}" class="btn-secondary">Back to List</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
