<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $exception->getStatusCode() ?? 500 }} - {{ config('app.name', 'Clinic Booking') }}</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    </head>
    <body class="font-sans antialiased bg-gray-50 min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full bg-white rounded-2xl shadow-lg p-8 text-center">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full flex items-center justify-center @switch($exception->getStatusCode())
                @case(403) bg-red-100 @break
                @case(404) bg-yellow-100 @break
                @case(419) bg-orange-100 @break
                @case(429) bg-purple-100 @break
                @default bg-gray-100 @break
            @endswitch">
                <i class="fas @switch($exception->getStatusCode())
                    @case(403) fa-lock text-red-500 text-3xl @break
                    @case(404) fa-search text-yellow-500 text-3xl @break
                    @case(419) fa-clock text-orange-500 text-3xl @break
                    @case(429) fa-server text-purple-500 text-3xl @break
                    @default fa-exclamation-triangle text-gray-500 text-3xl @break
                @endswitch"></i>
            </div>
            
            <h1 class="text-6xl font-bold text-gray-800 mb-2">{{ $exception->getStatusCode() ?? 500 }}</h1>
            
            <h2 class="text-xl font-semibold text-gray-700 mb-4">
                @switch($exception->getStatusCode())
                    @case(403) Access Forbidden @break
                    @case(404) Page Not Found @break
                    @case(419) Session Expired @break
                    @case(429) Too Many Requests @break
                    @default Server Error @break
                @endswitch
            </h2>
            
            <p class="text-gray-500 mb-8">
                @switch($exception->getStatusCode())
                    @case(403) You don't have permission to access this resource. @break
                    @case(404) The page you're looking for doesn't exist or has been moved. @break
                    @case(419) Your session has expired. Please refresh the page and try again. @break
                    @case(429) You've made too many requests. Please wait a moment and try again. @break
                    @default Something went wrong. Please try again later. @break
                @endswitch
            </p>
            
            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ url()->previous() }}" class="px-6 py-3 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i> Go Back
                </a>
                <a href="{{ route('dashboard') }}" class="px-6 py-3 bg-primary-600 text-white rounded-xl hover:bg-primary-700 transition-colors">
                    <i class="fas fa-home mr-2"></i> Dashboard
                </a>
            </div>
        </div>
    </body>
</html>
