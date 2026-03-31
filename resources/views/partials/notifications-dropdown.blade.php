<div class="flex items-center justify-between px-4 py-2 border-b border-gray-100">
    <span class="text-xs font-semibold text-gray-500 uppercase">Notifications</span>
    @if(Auth::user()->unreadNotifications->count() > 0)
        <form method="POST" action="{{ route('notifications.markAllRead') }}">
            @csrf
            <button class="text-xs text-primary-600 hover:underline">Mark all read</button>
        </form>
    @endif
</div>

<div class="max-h-64 overflow-y-auto bg-white">
    @forelse(Auth::user()->notifications->take(10) as $notification)
        <a href="{{ route('notifications.read', $notification->id) }}"
           class="flex items-start gap-3 px-4 py-3 hover:bg-gray-50 transition {{ $notification->read_at ? 'opacity-60' : '' }}">
            <div class="mt-1.5 w-2 h-2 rounded-full shrink-0 {{ $notification->read_at ? 'bg-gray-300' : 'bg-primary-500' }}"></div>
            <div>
                <p class="text-sm text-gray-800">{{ $notification->data['message'] ?? 'New notification' }}</p>
                <p class="text-xs text-gray-400 mt-0.5">{{ $notification->created_at->diffForHumans() }}</p>
            </div>
        </a>
    @empty
        <div class="px-4 py-6 text-center text-sm text-gray-400">
            No notifications yet 🔕
        </div>
    @endforelse
</div>