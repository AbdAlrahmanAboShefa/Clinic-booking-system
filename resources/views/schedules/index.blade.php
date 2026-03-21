@extends('layouts.app')

@section('header')
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Doctor Schedules') }}
    </h2>
@endsection

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <div class="flex justify-end mb-6">
                    <a href="{{ route('schedules.create') }}" class="btn-primary">Add Schedule</a>
                </div>

                <div class="space-y-6">
                    @forelse($doctors as $doctor)
                    <div class="border border-gray-200 rounded-lg p-4">
                        <h3 class="text-lg font-semibold mb-4">{{ $doctor->user->name }}</h3>
                        @if($doctor->schedules->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-7 gap-4">
                            @foreach($doctor->schedules as $schedule)
                            <div class="border rounded p-3">
                                <p class="font-medium">
                                    @switch($schedule->day_of_week)
                                        @case(0) Sunday @break
                                        @case(1) Monday @break
                                        @case(2) Tuesday @break
                                        @case(3) Wednesday @break
                                        @case(4) Thursday @break
                                        @case(5) Friday @break
                                        @case(6) Saturday @break
                                    @endswitch
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $schedule->start_time }} - {{ $schedule->end_time }}
                                </p>
                                @if($schedule->break_start && $schedule->break_end)
                                <p class="text-xs text-gray-500">
                                    Break: {{ $schedule->break_start }} - {{ $schedule->break_end }}
                                </p>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        @else
                        <p class="text-gray-500">No schedule set</p>
                        @endif
                    </div>
                    @empty
                    <p class="text-center text-gray-500">No doctors found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
