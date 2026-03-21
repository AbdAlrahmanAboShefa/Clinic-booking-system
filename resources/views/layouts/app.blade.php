<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Clinic Booking') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        colors: {
                            gray: {
                                50: '#f9fafb',
                                100: '#f3f4f6',
                                200: '#e5e7eb',
                                300: '#d1d5db',
                                400: '#9ca3af',
                                500: '#6b7280',
                                600: '#4b5563',
                                700: '#374151',
                                800: '#1f2937',
                                900: '#111827',
                            },
                            primary: {
                                50: '#eff6ff',
                                100: '#dbeafe',
                                200: '#bfdbfe',
                                300: '#93c5fd',
                                400: '#60a5fa',
                                500: '#3b82f6',
                                600: '#2563eb',
                                700: '#1d4ed8',
                                800: '#1e40af',
                                900: '#1e3a8a',
                            }
                        }
                    }
                }
            }
        </script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900">
        <div class="min-h-screen flex">
            <!-- Sidebar -->
            <aside class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transform -translate-x-full lg:translate-x-0 transition-transform duration-300" id="sidebar">
                <div class="flex flex-col h-full">
                    <!-- Logo -->
                    <div class="flex items-center justify-center h-20 border-b border-gray-200 bg-gradient-to-r from-primary-600 to-blue-600">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-white/20 rounded-lg flex items-center justify-center">
                                <i class="fas fa-hospital text-white text-lg"></i>
                            </div>
                            <span class="text-xl font-bold text-white">Clinic</span>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                        <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-primary-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-chart-pie w-5 text-center"></i>
                            <span class="font-medium">Dashboard</span>
                        </a>
                        
                        @can('patients.view')
                        <a href="{{ route('patients.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('patients.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-users w-5 text-center"></i>
                            <span class="font-medium">Patients</span>
                        </a>
                        @endcan
                        
                        @can('appointments.view')
                        <a href="{{ route('appointments.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('appointments.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-calendar-check w-5 text-center"></i>
                            <span class="font-medium">Appointments</span>
                        </a>
                        @endcan
                        
                        @can('doctors.view')
                        <a href="{{ route('doctors.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('doctors.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-user-md w-5 text-center"></i>
                            <span class="font-medium">Doctors</span>
                        </a>
                        @endcan
                        
                        @can('schedules.manage')
                        <a href="{{ route('schedules.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('schedules.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-clock w-5 text-center"></i>
                            <span class="font-medium">Schedules</span>
                        </a>
                        @endcan
                        
                        @if(Auth::user()->hasRole('admin'))
                        <a href="{{ route('admin.permissions.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.permissions.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-key w-5 text-center"></i>
                            <span class="font-medium">Permissions</span>
                        </a>
                        
                        <a href="{{ route('admin.activity-log.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.activity-log.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                            <i class="fas fa-history w-5 text-center"></i>
                            <span class="font-medium">Activity Log</span>
                        </a>
                        @endif

                        <div class="pt-4 border-t border-gray-200">
                            <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('profile.*') ? 'bg-primary-600 text-white shadow-lg' : 'text-gray-600 hover:bg-gray-100' }}">
                                <i class="fas fa-user-cog w-5 text-center"></i>
                                <span class="font-medium">Profile</span>
                            </a>
                            
                            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-100">
                                <i class="fas fa-cog w-5 text-center"></i>
                                <span class="font-medium">Settings</span>
                            </a>
                        </div>
                    </nav>

                    <!-- User Section -->
                    <div class="p-4 border-t border-gray-200">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-gray-50">
                            <div class="w-10 h-10 bg-primary-600 rounded-full flex items-center justify-center text-white font-semibold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 truncate">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="p-2 text-gray-400 hover:text-red-500 transition-colors" title="Logout">
                                    <i class="fas fa-sign-out-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="flex-1 lg:ml-64">
                <!-- Mobile Header -->
                <header class="lg:hidden bg-white border-b border-gray-200 h-16 flex items-center justify-between px-4">
                    <button onclick="toggleSidebar()" class="p-2 rounded-lg text-gray-600 hover:bg-gray-100">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                    <span class="text-lg font-semibold text-gray-800">Clinic Booking</span>
                    <div class="w-8"></div>
                </header>

                <!-- Page Content -->
                <main class="p-4 lg:p-8">
                    @if(session('success'))
                        <x-flash-message type="success">
                            {{ session('success') }}
                        </x-flash-message>
                    @endif
                    
                    @if(session('error'))
                        <x-flash-message type="error">
                            {{ session('error') }}
                        </x-flash-message>
                    @endif
                    
                    @if(session('warning'))
                        <x-flash-message type="warning">
                            {{ session('warning') }}
                        </x-flash-message>
                    @endif
                    
                    @if(session('info'))
                        <x-flash-message type="info">
                            {{ session('info') }}
                        </x-flash-message>
                    @endif
                    
                    @yield('content')
                </main>
            </div>
        </div>

        <!-- Mobile Overlay -->
        <div class="fixed inset-0 bg-black/50 z-40 lg:hidden hidden" id="sidebar-overlay" onclick="toggleSidebar()"></div>

        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                sidebar.classList.toggle('-translate-x-full');
                overlay.classList.toggle('hidden');
            }
        </script>
        @stack('scripts')
    </body>
</html>
