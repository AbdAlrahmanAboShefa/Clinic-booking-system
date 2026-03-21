@props(['type' => 'info'])

@php
$classes = match($type) {
    'success' => 'bg-green-50 border-green-200 text-green-800',
    'error' => 'bg-red-50 border-red-200 text-red-800',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
    'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    default => 'bg-gray-50 border-gray-200 text-gray-800',
};

$icon = match($type) {
    'success' => 'fa-check-circle text-green-500',
    'error' => 'fa-exclamation-circle text-red-500',
    'warning' => 'fa-exclamation-triangle text-yellow-500',
    'info' => 'fa-info-circle text-blue-500',
    default => 'fa-info-circle text-gray-500',
};
@endphp

<div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
    class="{{ $classes }} border rounded-xl p-4 mb-4 flex items-start gap-3" role="alert">
    <i class="fas {{ $icon }} mt-0.5"></i>
    <div class="flex-1">
        {{ $slot }}
    </div>
    <button @click="show = false" class="text-gray-400 hover:text-gray-600">
        <i class="fas fa-times"></i>
    </button>
</div>
