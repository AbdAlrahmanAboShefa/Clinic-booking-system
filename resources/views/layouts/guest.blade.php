<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'Clinic Booking') }}</title>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
        <script src="https://cdn.tailwindcss.com"></script>
        <style>
            .iti-phone {
                width: 100%;
            }
            .iti {
                position: relative;
                display: block;
            }
            .iti__tel-input {
                width: 100%;
                padding-left: 40px !important;
            }
            .iti__flag-container {
                left: 10px !important;
            }
            .phone-input-wrapper {
                position: relative;
            }
            .phone-icon {
                position: absolute;
                left: 10px;
                top: 50%;
                transform: translateY(-50%);
                z-index: 1;
                pointer-events: none;
            }
            .iti__country-list {
                position: absolute;
                z-index: 2;
                list-style: none;
                text-align: left;
                padding: 0;
                margin: 0 0 0 -1px;
                box-shadow: 1px 1px 4px rgba(0,0,0,0.16);
                background-color: white;
                border: 1px solid #ccc;
                white-space: nowrap;
                max-height: 200px;
                overflow-y: scroll;
            }
            .iti__country {
                padding: 8px 12px;
                cursor: pointer;
            }
            .iti__country:hover {
                background-color: #f3f4f6;
            }
            .iti__dial-code {
                color: #6b7280;
            }
            .iti__country-name {
                color: #374151;
            }
            .iti--separate-dial-code .iti__selected-dial-code {
                margin-left: 6px;
            }
        </style>
        <script>
            tailwind.config = {
                darkMode: 'class',
                theme: {
                    extend: {
                        fontFamily: {
                            sans: ['Figtree', 'sans-serif'],
                        },
                        colors: {
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
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600 via-blue-600 to-indigo-800"></div>
            <div class="absolute inset-0 opacity-30">
                <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
                <div class="absolute top-0 -right-4 w-72 h-72 bg-yellow-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
            </div>
            
            <div class="relative min-h-screen flex flex-col sm:justify-center items-center px-4 sm:px-6 lg:px-8 py-12">
                <!-- Logo & Title -->
                <div class="sm:max-w-md w-full text-center mb-8">
                    <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 backdrop-blur-sm rounded-2xl mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold text-white tracking-tight">{{ config('app.name', 'Clinic Booking') }}</h1>
                    <p class="text-primary-100 mt-2">Manage your clinic appointments with ease</p>
                </div>

                <div class="w-full sm:max-w-md">
                    <div class="bg-white rounded-2xl shadow-2xl p-8 border-2 border-black">
                        {{ $slot }}
                    </div>
                    
                    <div class="text-center mt-6">
                        <p class="text-primary-100 text-sm">
                            &copy; {{ date('Y') }} {{ config('app.name', 'Clinic Booking') }}. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        
        <style>
            @keyframes blob {
                0% { transform: translate(0px, 0px) scale(1); }
                33% { transform: translate(30px, -50px) scale(1.1); }
                66% { transform: translate(-20px, 20px) scale(0.9); }
                100% { transform: translate(0px, 0px) scale(1); }
            }
            .animate-blob {
                animation: blob 7s infinite;
            }
            .animation-delay-2000 {
                animation-delay: 2s;
            }
            .animation-delay-4000 {
                animation-delay: 4s;
            }
        </style>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </body>
</html>
