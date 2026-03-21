@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Manage Roles for {{ $user->name }}</h2>
            <a href="{{ route('admin.permissions.users') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold text-lg">
                        {{ substr($user->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-medium text-gray-900">{{ $user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $user->email }}</p>
                    </div>
                </div>
            </div>
            
            <div class="p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Sync User Roles</h3>
                <form action="{{ route('admin.permissions.user.sync', $user->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-3 mb-6">
                        @foreach($roles as $role)
                            <label class="flex items-center p-3 border border-gray-200 rounded-xl hover:bg-gray-50 cursor-pointer transition-colors">
                                <input type="checkbox" 
                                       name="roles[]" 
                                       value="{{ $role->name }}"
                                       {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                       class="w-5 h-5 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                                <span class="ml-3 text-gray-700">{{ $role->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    
                    <button type="submit" class="w-full px-4 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i> Update User Roles
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
            </div>
            <div class="p-6 grid grid-cols-2 gap-4">
                <form action="{{ route('admin.permissions.user.assign-role', $user->id) }}" method="POST" class="flex gap-2">
                    @csrf
                    <select name="role" class="flex-1 rounded-xl border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            @if(!$user->hasRole($role->name))
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors">
                        <i class="fas fa-plus"></i>
                    </button>
                </form>

                <form action="{{ route('admin.permissions.user.remove-role', $user->id) }}" method="POST" class="flex gap-2">
                    @csrf
                    <select name="role" class="flex-1 rounded-xl border-gray-300 focus:ring-primary-500 focus:border-primary-500">
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            @if($user->hasRole($role->name))
                                <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                        <i class="fas fa-minus"></i>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
