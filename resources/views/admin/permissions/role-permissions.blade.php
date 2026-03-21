@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Manage Permissions for Role: <span class="text-primary-600">{{ $role->name }}</span></h2>
            <a href="{{ route('admin.permissions.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i> Back
            </a>
        </div>

        <!-- Sync Permissions Form -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-indigo-50">
                <h3 class="text-lg font-semibold text-indigo-800">Sync Role Permissions</h3>
                <p class="text-sm text-indigo-600">Select the permissions you want this role to have. Unselected permissions will be removed.</p>
            </div>
            
            <div class="p-6">
                <form action="{{ route('admin.permissions.role.sync', $role->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <div class="space-y-6 mb-6">
                        @forelse($permissions as $group => $perms)
                            <div class="border border-gray-200 rounded-xl p-4">
                                <h4 class="font-semibold text-gray-700 mb-3 flex items-center gap-2">
                                    <i class="fas fa-folder text-gray-400"></i>
                                    {{ $group ?: 'Ungrouped' }}
                                </h4>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-2">
                                    @foreach($perms as $permission)
                                        <label class="flex items-center p-2 bg-gray-50 rounded-lg hover:bg-gray-100 cursor-pointer transition-colors">
                                            <input type="checkbox" 
                                                   name="permissions[]" 
                                                   value="{{ $permission->name }}"
                                                   {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}
                                                   class="w-4 h-4 text-primary-600 rounded border-gray-300 focus:ring-primary-500">
                                            <span class="ml-2 text-sm text-gray-700">{{ $permission->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @empty
                            <p class="text-gray-500 text-center py-8">No permissions available</p>
                        @endforelse
                    </div>
                    
                    <button type="submit" class="w-full px-4 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors font-medium">
                        <i class="fas fa-save mr-2"></i> Update Role Permissions
                    </button>
                </form>
            </div>
        </div>

        <!-- Quick Add/Remove -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Add Permission -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-green-50">
                    <h3 class="text-lg font-semibold text-green-800">
                        <i class="fas fa-plus-circle mr-2"></i> Add Permission
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.permissions.role.give', $role->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <select name="permission" class="flex-1 rounded-xl border-gray-300 focus:ring-green-500 focus:border-green-500">
                            <option value="">Select Permission</option>
                            @foreach($permissions as $group => $perms)
                                <optgroup label="{{ $group ?: 'Ungrouped' }}">
                                    @foreach($perms as $permission)
                                        @if(!$role->hasPermissionTo($permission->name))
                                            <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                                        @endif
                                    @endforeach
                                </optgroup>
                            @endforeach
                        </select>
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-xl hover:bg-green-700 transition-colors">
                            <i class="fas fa-plus"></i>
                        </button>
                    </form>
                </div>
            </div>

            <!-- Remove Permission -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-red-50">
                    <h3 class="text-lg font-semibold text-red-800">
                        <i class="fas fa-minus-circle mr-2"></i> Remove Permission
                    </h3>
                </div>
                <div class="p-6">
                    <form action="{{ route('admin.permissions.role.revoke', $role->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <select name="permission" class="flex-1 rounded-xl border-gray-300 focus:ring-red-500 focus:border-red-500">
                            <option value="">Select Permission</option>
                            @foreach($role->permissions as $permission)
                                <option value="{{ $permission->name }}">{{ $permission->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-xl hover:bg-red-700 transition-colors">
                            <i class="fas fa-minus"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Current Permissions -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Current Permissions</h3>
            </div>
            <div class="p-6">
                @if($role->permissions->count() > 0)
                    <div class="flex flex-wrap gap-2">
                        @foreach($role->permissions as $permission)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <i class="fas fa-check mr-1"></i> {{ $permission->name }}
                            </span>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">This role has no permissions assigned.</p>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
