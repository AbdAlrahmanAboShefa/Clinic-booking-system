@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Patients') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <form method="GET" class="flex gap-4">
                        <input type="text" name="search" placeholder="Search patients..." 
                               class="input-field"
                               value="{{ request('search') }}">
                        <button type="submit" class="btn-primary">Search</button>
                    </form>
                    @can('patients.create')
                    <a href="{{ route('patients.create') }}" class="btn-primary">Add Patient</a>
                    @endcan
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Phone</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($patients as $patient)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $patient->patient_code }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $patient->first_name }} {{ $patient->last_name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $patient->phone }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $patient->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('patients.show', $patient) }}" class="text-blue-600 hover:text-blue-900">View</a>
                                    @can('patients.edit')
                                    <a href="{{ route('patients.edit', $patient) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Edit</a>
                                    @endcan
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No patients found.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $patients->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
