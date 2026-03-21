@extends('layouts.app')

@section('content')
    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Activity Information</h3>
                            
                            <div class="space-y-3">
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Description:</span>
                                    <p class="text-sm text-gray-900">{{ $activity->description }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Log Name:</span>
                                    <p class="text-sm text-gray-900">{{ $activity->log_name }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Event:</span>
                                    <p class="text-sm text-gray-900">{{ $activity->event ?? '-' }}</p>
                                </div>
                                
                                <div>
                                    <span class="text-sm font-medium text-gray-500">Created At:</span>
                                    <p class="text-sm text-gray-900">{{ $activity->created_at->format('Y-m-d H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">User Information</h3>
                            
                            @if($activity->causer)
                                <div class="space-y-3">
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">User:</span>
                                        <p class="text-sm text-gray-900">{{ $activity->causer->name }}</p>
                                    </div>
                                    
                                    <div>
                                        <span class="text-sm font-medium text-gray-500">User ID:</span>
                                        <p class="text-sm text-gray-900">{{ $activity->causer_id }}</p>
                                    </div>
                                </div>
                            @else
                                <p class="text-sm text-gray-500">System action (no user)</p>
                            @endif
                        </div>
                    </div>
                    
                    @if($activity->subject)
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Subject Information</h3>
                        
                        <div class="space-y-3">
                            <div>
                                <span class="text-sm font-medium text-gray-500">Subject Type:</span>
                                <p class="text-sm text-gray-900">{{ class_basename($activity->subject) }}</p>
                            </div>
                            
                            <div>
                                <span class="text-sm font-medium text-gray-500">Subject ID:</span>
                                <p class="text-sm text-gray-900">{{ $activity->subject_id }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                    
                    @if($activity->getChanges())
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Changes</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @if($activity->getChanges()['attributes'] ?? null)
                            <div>
                                <span class="text-sm font-medium text-gray-500">New Values:</span>
                                <pre class="mt-1 text-sm bg-gray-50 p-3 rounded overflow-x-auto">{{ json_encode($activity->getChanges()['attributes'], JSON_PRETTY_PRINT) }}</pre>
                            </div>
                            @endif
                            
                            @if($activity->getChanges()['old'] ?? null)
                            <div>
                                <span class="text-sm font-medium text-gray-500">Old Values:</span>
                                <pre class="mt-1 text-sm bg-gray-50 p-3 rounded overflow-x-auto">{{ json_encode($activity->getChanges()['old'], JSON_PRETTY_PRINT) }}</pre>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <div class="mt-6">
                        <a href="{{ route('admin.activity-log.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            Back to Activity Log
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
