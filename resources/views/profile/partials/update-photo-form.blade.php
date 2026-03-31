<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">{{ __('Profile Photo') }}</h2>
        <p class="mt-1 text-sm text-gray-600">{{ __('Upload a new profile photo.') }}</p>
    </header>

    <form method="POST" action="{{ route('profile.photo.update') }}"
          enctype="multipart/form-data" class="mt-6 space-y-6"
          x-data="{ preview: null }">
        @csrf

        <div class="flex items-center gap-6">
            {{-- الصورة الحالية --}}
            <div class="shrink-0">
                <img id="photo-preview"
                     :src="preview ?? '{{ $user->profile_photo_url }}'"
                     class="w-20 h-20 rounded-full object-cover ring-2 ring-primary-500"
                     alt="Profile photo">
            </div>

            {{-- زر الرفع --}}
            <div>
                <label class="cursor-pointer bg-white border border-gray-300 rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 transition">
                    {{ __('Choose Photo') }}
                    <input type="file" name="profile_photo" accept="image/*" class="hidden"
                           x-on:change="preview = URL.createObjectURL($event.target.files[0])">
                </label>
                <p class="mt-1 text-xs text-gray-500">JPG, PNG, WEBP — max 2MB</p>
                <x-input-error :messages="$errors->get('profile_photo')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save Photo') }}</x-primary-button>
            @if(session('status') === 'photo-updated')
                <p x-data="{ show: true }" x-show="show" x-transition
                   x-init="setTimeout(() => show = false, 2000)"
                   class="text-sm text-gray-600">{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>