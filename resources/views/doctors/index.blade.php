@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Doctors') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-between items-center mb-6">
                    <form method="GET" class="flex gap-4">
                        <select name="specialization" class="input-field">
                            <option value="">All Specializations</option>
                            @foreach($specializations as $spec)
                            <option value="{{ $spec->id }}" {{ request('specialization') == $spec->id ? 'selected' : '' }}>{{ $spec->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-primary">Filter</button>
                    </form>
                    @can('doctors.create')
                    <a href="{{ route('doctors.create') }}" class="btn-primary">Add Doctor</a>
                    @endcan
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($doctors as $doctor)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-lg font-semibold">{{ $doctor->user->name }}</h3>
                            <span class="px-2 py-1 text-xs rounded-full {{ $doctor->is_available ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $doctor->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                        <p class="text-sm text-gray-600 mb-2">
                            {{ $doctor->specialization?->name ?? 'General' }}
                        </p>
                        <p class="text-sm text-gray-600 mb-4">
                            {{ $doctor->qualification ?? 'No qualification listed' }}
                        </p>
                        <div class="flex gap-2">
                            <a href="{{ route('doctors.show', $doctor) }}" class="text-blue-600 hover:text-blue-900">View</a>
                            @can('doctors.edit')
                            <a href="{{ route('doctors.edit', $doctor) }}" class="ml-4 text-yellow-600 hover:text-yellow-900">Edit</a>
                            @endcan
                        </div>
                    </div>
                    @empty
                    <div class="col-span-full text-center text-gray-500 py-8">
                        No doctors found.
                    </div>
                    @endforelse
                </div>

                <div class="mt-4">
                    {{ $doctors->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
