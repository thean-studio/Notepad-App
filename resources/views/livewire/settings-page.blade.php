<div class="flex h-screen overflow-hidden bg-gray-50">

    {{-- ═══════════════════════════════════════════
    SIDEBAR
    ═══════════════════════════════════════════ --}}
    <aside class="flex flex-col w-72 min-w-[260px] bg-white border-r border-gray-200 shadow-sm">

        {{-- Logo / Header --}}
        <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-100">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span class="text-base font-semibold text-gray-800 tracking-tight">Notepad</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('notepad') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-600 rounded-lg hover:bg-gray-50 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Notes
            </a>
            <button wire:click="$set('isEditing', true)"
                class="flex items-center gap-3 w-full px-3 py-2.5 text-sm font-medium text-indigo-600 bg-indigo-50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </button>
        </nav>

        {{-- User Profile Footer --}}
        <div class="border-t border-gray-100 p-3">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0">
                    @if (auth()->user()->profile_picture)
                    <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                        alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    @else
                    <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                    </svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-gray-500 truncate">{{ auth()->user()->email }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ═══════════════════════════════════════════
    MAIN CONTENT AREA
    ═══════════════════════════════════════════ --}}
    <main class="flex-1 flex flex-col overflow-hidden">

        {{-- Header --}}
        <div class="flex items-center justify-between px-8 py-6 bg-white border-b border-gray-200 shadow-sm">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Settings</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola profil dan preferensi Anda</p>
            </div>
        </div>

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto px-8 py-8">

            {{-- Success Message --}}
            @if ($successMessage)
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-center gap-3">
                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <span class="text-sm text-green-800">{{ $successMessage }}</span>
            </div>
            @endif

            {{-- Settings Form --}}
            <div class="max-w-2xl">

                {{-- Profile Picture --}}
                <div class="mb-8">
                    <label class="block text-sm font-medium text-gray-900 mb-4">Foto Profile</label>
                    <div class="flex items-end gap-6">
                        <div class="relative">
                            <div
                                class="w-32 h-32 rounded-full bg-gray-100 flex items-center justify-center overflow-hidden border-2 border-gray-200">
                                @if ($profilePicture)
                                <img src="{{ $profilePicture->temporaryUrl() }}" alt="Preview"
                                    class="w-full h-full object-cover">
                                @elseif(auth()->user()->profile_picture)
                                <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                                    alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                @else
                                <svg class="w-16 h-16 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                </svg>
                                @endif
                            </div>
                        </div>
                        <div class="flex flex-col gap-2">
                            <input type="file" wire:model="profilePicture" accept="image/*"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 cursor-pointer" />
                            <p class="text-xs text-gray-500">Max 5MB. Format: JPG, PNG</p>
                            @error('profilePicture')
                            <span class="text-xs text-red-600">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Form Fields --}}
                <div class="space-y-6">

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-900 mb-2">Nama</label>
                        <input type="text" id="name" wire:model="name" {{ !$isEditing ? 'disabled' : '' }}
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 transition-colors"
                            placeholder="Nama Anda" />
                        @error('name')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-900 mb-2">Email</label>
                        <input type="email" id="email" wire:model="email" {{ !$isEditing ? 'disabled' : '' }}
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent disabled:bg-gray-50 disabled:text-gray-500 transition-colors"
                            placeholder="Email Anda" />
                        @error('email')
                        <span class="text-xs text-red-600">{{ $message }}</span>
                        @enderror
                    </div>

                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-3 mt-8">
                    @if ($isEditing)
                    <button wire:click="saveSettings"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                        Simpan Perubahan
                    </button>
                    <button wire:click="cancelEdit"
                        class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors">
                        Batal
                    </button>
                    @else
                    <button wire:click="$set('isEditing', true)"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                        Edit Profile
                    </button>
                    @endif
                </div>

                {{-- Logout Section --}}
                <div class="mt-12 pt-8 border-t border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-900 mb-4">Keamanan Akun</h3>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Logout
                        </button>
                    </form>
                </div>

            </div>

        </div>

    </main>

</div>

@script
<script>
    Livewire.on('success-shown', () => {
            setTimeout(() => {
                @this.successMessage = '';
            }, 3000);
        });
</script>
@endscript