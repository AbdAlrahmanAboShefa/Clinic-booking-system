@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-gray-800">Permission Management</h2>
            <div class="flex gap-3">
                <a href="{{ route('admin.permissions.users') }}" class="px-4 py-2 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors">
                    <i class="fas fa-users mr-2"></i> Manage User Roles
                </a>
            </div>
        </div>

        <!-- Roles & Permissions Overview -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">Roles & Permissions Overview</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Permissions</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($roles as $role)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800">
                                    {{ $role->name }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap gap-1">
                                    @forelse($role->permissions as $permission)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-700">
                                            {{ $permission->name }}
                                        </span>
                                    @empty
                                        <span class="text-sm text-gray-400">No permissions</span>
                                    @endforelse
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('admin.permissions.role.edit', $role->id) }}" class="text-primary-600 hover:text-primary-900">
                                    <i class="fas fa-edit"></i> Manage
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Permissions by Group -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-800">All Permissions</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @forelse($permissions as $group => $perms)
                        <div class="border border-gray-200 rounded-xl p-4">
                            <h4 class="font-semibold text-gray-700 mb-3">{{ $group ?: 'Ungrouped' }}</h4>
                            <div class="space-y-2">
                                @foreach($perms as $permission)
                                    <div class="flex items-center justify-between p-2 bg-gray-50 rounded-lg">
                                        <span class="text-sm text-gray-600">{{ $permission->name }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500 col-span-full text-center py-8">No permissions found</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
