@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Appointments') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <form method="GET" class="flex gap-4">
                        <input type="date" name="date" class="input-field" value="{{ request('date') }}">
                        <select name="status" class="input-field">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="confirmed" {{ request('status') == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn-primary">Filter</button>
                    </form>
                    @can('appointments.create')
                    <a href="{{ route('appointments.create') }}" class="btn-primary">New Appointment</a>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Date</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Time</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Patient</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Doctor</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($appointments as $appointment)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->appointment_date }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->start_time }} - {{ $appointment->end_time }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->patient->first_name }} {{ $appointment->patient->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $appointment->doctor->user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        @switch($appointment->status)
                                            @case('confirmed') bg-green-100 text-green-800 @break
                                            @case('pending') bg-yellow-100 text-yellow-800 @break
                                            @case('completed') bg-blue-100 text-blue-800 @break
                                            @case('cancelled') bg-red-100 text-red-800 @break
                                        @endswitch">
                                        {{ ucfirst($appointment->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('appointments.show', $appointment) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    @can('appointments.edit')
                                    <a href="{{ route('appointments.edit', $appointment) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Edit</a>
                                    @endcan
                                    @if(auth()->user()->hasRole('doctor') && $appointment->status === 'pending' && $appointment->doctor_id === auth()->user()->doctor->id)
                                        <form action="{{ route('appointments.confirm', $appointment) }}" method="POST" class="inline ml-4">
                                            @csrf
                                            <button type="submit" class="text-green-600 hover:text-green-900">Confirm</button>
                                        </form>
                                        <form action="{{ route('appointments.reject', $appointment) }}" method="POST" class="inline ml-2" onsubmit="return confirm('Are you sure you want to reject this appointment?');">
                                            @csrf
                                            <button type="submit" class="text-red-600 hover:text-red-900">Reject</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">No appointments found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $appointments->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
