<div class="flex h-screen overflow-hidden bg-gray-50 dark:bg-gray-900 transition-colors duration-200">

    {{-- ═══════════════════════════════════════════
    SIDEBAR
    ═══════════════════════════════════════════ --}}
    <aside
        class="flex flex-col w-72 min-w-[260px] bg-white dark:bg-gray-800 border-r border-gray-200 dark:border-gray-700 shadow-sm transition-colors duration-200">

        {{-- Logo / Header --}}
        <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-100 dark:border-gray-700">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span class="text-base font-semibold text-gray-800 dark:text-gray-100 tracking-tight">Notepad</span>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-3 py-4 space-y-1">
            <a href="{{ route('dashboard-settings') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Dashboard Settings
            </a>
            <a href="{{ route('notepad') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Notes
            </a>
            <a href="{{ route('settings') }}"
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                Settings
            </a>
        </nav>

        {{-- Toggle Dark Mode --}}
        <div class="px-3 pb-3">
            <button onclick="toggleDarkMode()"
                class="flex items-center justify-between w-full px-3 py-2 text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 dark:hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                    </svg>
                    <svg class="w-4 h-4 hidden dark:block text-amber-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Mode Malam
                </div>
                <div
                    class="relative inline-flex h-4 w-7 items-center rounded-full bg-gray-300 dark:bg-indigo-500 transition-colors">
                    <span
                        class="inline-block h-3 w-3 transform rounded-full bg-white transition-transform translate-x-0.5 dark:translate-x-3.5 shadow-sm"></span>
                </div>
            </button>
        </div>

        {{-- User Profile Footer --}}
        <div class="border-t border-gray-100 dark:border-gray-700 p-3">
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden flex-shrink-0">
                    @if (auth()->check() && auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                            alt="{{ auth()->user()->name ?? 'User' }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-800 dark:text-gray-200 truncate">
                        {{ auth()->user()->name ?? 'Guest' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                        {{ auth()->user()->email ?? 'guest@notepad.com' }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ═══════════════════════════════════════════
    MAIN CONTENT AREA
    ═══════════════════════════════════════════ --}}
    <main class="flex-1 flex flex-col overflow-hidden">

        {{-- Header dengan User Info --}}
        <div
            class="flex items-center justify-between px-8 py-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm transition-colors duration-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Settings</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola profil, keamanan, dan preferensi Anda
                </p>
            </div>

            {{-- User Info di Header --}}
            <div class="flex items-center gap-3">
                <div class="text-right">
                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                        {{ auth()->check() ? auth()->user()->name : 'Guest' }}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">
                        {{ auth()->check() ? auth()->user()->email : 'guest@notepad.com' }}</p>
                </div>
                <div
                    class="w-10 h-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center overflow-hidden flex-shrink-0 border-2 border-indigo-200 dark:border-indigo-800">
                    @if (auth()->check() && auth()->user()->profile_picture)
                        <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                            alt="{{ auth()->user()->name ?? 'User' }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                        </svg>
                    @endif
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto">

            {{-- Success Message --}}
            @if ($successMessage)
                <div
                    class="mx-8 mt-6 p-4 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 rounded-lg flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    <span class="text-sm text-green-800 dark:text-green-200">{{ $successMessage }}</span>
                </div>
            @endif

            {{-- Tabs Navigation --}}
            <div class="border-b border-gray-200 dark:border-gray-700 px-8">
                <nav class="flex gap-0 -mb-px">
                    <button wire:click="$set('activeTab', 'profile')"
                        class="px-4 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'profile' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            Profile
                        </div>
                    </button>
                    <button wire:click="$set('activeTab', 'security')"
                        class="px-4 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'security' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Keamanan
                        </div>
                    </button>
                    <button wire:click="$set('activeTab', 'preferences')"
                        class="px-4 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'preferences' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                            </svg>
                            Preferensi
                        </div>
                    </button>
                    <button wire:click="$set('activeTab', 'data')"
                        class="px-4 py-3 text-sm font-medium border-b-2 transition-colors {{ $activeTab === 'data' ? 'border-indigo-500 text-indigo-600 dark:text-indigo-400' : 'border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                            </svg>
                            Data
                        </div>
                    </button>
                </nav>
            </div>

            {{-- Tab Content --}}
            <div class="px-8 py-8">

                {{-- PROFILE TAB --}}
                @if ($activeTab === 'profile')
                    <div class="max-w-2xl">
                        {{-- Profile Picture --}}
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-4">Foto
                                Profile</label>
                            <div class="flex items-end gap-6">
                                <div class="relative">
                                    <div
                                        class="w-32 h-32 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center overflow-hidden border-2 border-gray-200 dark:border-gray-600">
                                        @if ($profilePicture)
                                            <img src="{{ $profilePicture->temporaryUrl() }}" alt="Preview"
                                                class="w-full h-full object-cover">
                                        @elseif(auth()->check() && auth()->user()->profile_picture)
                                            <img src="{{ asset('storage/' . auth()->user()->profile_picture) }}"
                                                alt="{{ auth()->user()->name ?? 'User' }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            <svg class="w-16 h-16 text-gray-400 dark:text-gray-500"
                                                fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z" />
                                            </svg>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col gap-2">
                                    <input type="file" wire:model="profilePicture" accept="image/*"
                                        class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 dark:file:bg-indigo-900/50 dark:file:text-indigo-400 hover:file:bg-indigo-100 dark:hover:file:bg-indigo-900 cursor-pointer" />
                                    <p class="text-xs text-gray-500 dark:text-gray-400">Max 5MB. Format: JPG, PNG</p>
                                    @error('profilePicture')
                                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Form Fields --}}
                        <div class="space-y-6">
                            <div>
                                <label for="name"
                                    class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-2">Nama</label>
                                <input type="text" id="name" wire:model="name"
                                    {{ !$isEditing ? 'disabled' : '' }}
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent disabled:bg-gray-50 dark:disabled:bg-gray-900 disabled:text-gray-500 dark:disabled:text-gray-500 transition-colors"
                                    placeholder="Nama Anda" />
                                @error('name')
                                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                            <div>
                                <label for="email"
                                    class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-2">Email</label>
                                <input type="email" id="email" wire:model="email"
                                    {{ !$isEditing ? 'disabled' : '' }}
                                    class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent disabled:bg-gray-50 dark:disabled:bg-gray-900 disabled:text-gray-500 dark:disabled:text-gray-500 transition-colors"
                                    placeholder="Email Anda" />
                                @error('email')
                                    <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Action Buttons --}}
                        <div class="flex gap-3 mt-8">
                            @if ($isEditing)
                                <button wire:click="saveProfile"
                                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                                    Simpan Perubahan
                                </button>
                                <button wire:click="cancelEdit"
                                    class="px-6 py-2.5 bg-gray-200 hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 text-gray-800 dark:text-gray-200 font-medium rounded-lg transition-colors">
                                    Batal
                                </button>
                            @else
                                <button wire:click="$set('isEditing', true)"
                                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                                    Edit Profile
                                </button>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- SECURITY TAB --}}
                @if ($activeTab === 'security')
                    <div class="max-w-2xl space-y-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ubah Password</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="currentPassword"
                                        class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-2">Password
                                        Saat Ini</label>
                                    <input type="password" id="currentPassword" wire:model="currentPassword"
                                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors"
                                        placeholder="Masukkan password saat ini" />
                                    @error('currentPassword')
                                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="newPassword"
                                        class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-2">Password
                                        Baru</label>
                                    <input type="password" id="newPassword" wire:model="newPassword"
                                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors"
                                        placeholder="Minimal 8 karakter" />
                                    @error('newPassword')
                                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div>
                                    <label for="newPasswordConfirmation"
                                        class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-2">Konfirmasi
                                        Password Baru</label>
                                    <input type="password" id="newPasswordConfirmation"
                                        wire:model="newPasswordConfirmation"
                                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors"
                                        placeholder="Ulangi password baru" />
                                    @error('newPasswordConfirmation')
                                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button wire:click="changePassword"
                                    class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                                    Ubah Password
                                </button>
                            </div>
                        </div>

                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Two-Factor
                                Authentication</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Tambahkan lapisan keamanan ekstra
                                ke akun Anda.</p>
                            <button disabled
                                class="px-6 py-2.5 bg-gray-300 dark:bg-gray-600 text-gray-500 dark:text-gray-400 font-medium rounded-lg cursor-not-allowed transition-colors">
                                Segera Hadir
                            </button>
                        </div>

                        <div class="pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Sesi Aktif</h3>
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
                @endif

                {{-- PREFERENCES TAB --}}
                @if ($activeTab === 'preferences')
                    <div class="max-w-2xl space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-2">Font
                                Default</label>
                            <select wire:model="defaultFont"
                                class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-colors">
                                <option value="sans">Sans Serif</option>
                                <option value="serif">Serif</option>
                                <option value="mono">Monospace</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-900 dark:text-gray-200 mb-2">Warna
                                Default Note</label>
                            <input type="color" wire:model="defaultNoteColor"
                                class="w-20 h-10 rounded-lg border border-gray-300 dark:border-gray-600 cursor-pointer">
                        </div>
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-200">Auto Save</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">Simpan otomatis saat mengetik</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" wire:model="autoSave" class="sr-only peer">
                                <div
                                    class="w-9 h-5 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-300 dark:peer-focus:ring-indigo-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-gray-600 peer-checked:bg-indigo-600">
                                </div>
                            </label>
                        </div>
                        <button wire:click="savePreferences"
                            class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg transition-colors">
                            Simpan Preferensi
                        </button>
                    </div>
                @endif

                {{-- DATA TAB --}}
                @if ($activeTab === 'data')
                    <div class="max-w-2xl space-y-8">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Ekspor Catatan</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Download semua catatan Anda dalam
                                format TXT.</p>
                            <button wire:click="exportNotes"
                                class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Ekspor Catatan
                            </button>
                        </div>

                        <div class="pt-6 border-t border-red-200 dark:border-red-800">
                            <div
                                class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-lg p-6">
                                <h3 class="text-lg font-semibold text-red-800 dark:text-red-400 mb-2">Hapus Akun</h3>
                                <p class="text-sm text-red-600 dark:text-red-300 mb-4">Tindakan ini tidak dapat
                                    dibatalkan.</p>
                                <div class="space-y-3">
                                    <input type="text" wire:model="deleteConfirmation"
                                        class="w-full px-4 py-2 bg-white dark:bg-gray-800 border border-red-300 dark:border-red-700 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent transition-colors"
                                        placeholder='Ketik "HAPUS" untuk konfirmasi' />
                                    @error('deleteConfirmation')
                                        <span class="text-xs text-red-600 dark:text-red-400">{{ $message }}</span>
                                    @enderror
                                    <button wire:click="deleteAccount"
                                        class="px-6 py-2.5 bg-red-600 hover:bg-red-700 text-white font-medium rounded-lg transition-colors">
                                        Hapus Akun Saya
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

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
