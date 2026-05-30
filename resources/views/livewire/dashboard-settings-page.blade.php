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
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/50 rounded-lg transition-colors">
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
                class="flex items-center gap-3 px-3 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
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

        {{-- Header --}}
        <div
            class="flex items-center justify-between px-8 py-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 shadow-sm transition-colors duration-200">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Dashboard Settings</h1>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Ringkasan aktivitas dan statistik catatan Anda
                </p>
            </div>
        </div>

        {{-- Content --}}
        <div class="flex-1 overflow-y-auto px-8 py-8">

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">

                {{-- Total Notes --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-colors hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Notes</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalNotes }}</p>
                        </div>
                    </div>
                </div>

                {{-- Notes Dipin --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-colors hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-yellow-100 dark:bg-yellow-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="currentColor"
                                viewBox="0 0 24 24">
                                <path
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Dipin</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $pinnedNotes }}</p>
                        </div>
                    </div>
                </div>

                {{-- Notes di Sampah --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-colors hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-red-100 dark:bg-red-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Di Sampah</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $trashedNotes }}</p>
                        </div>
                    </div>
                </div>

                {{-- Notes Aktif --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-colors hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-green-100 dark:bg-green-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Notes Aktif</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $activeNotes }}</p>
                        </div>
                    </div>
                </div>

                {{-- Rata-rata Waktu --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-colors hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-indigo-100 dark:bg-indigo-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Waktu</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $avgTimeInMinutes }} <span
                                    class="text-sm font-normal text-gray-500">menit</span></p>
                        </div>
                    </div>
                </div>

                {{-- Total Waktu --}}
                <div
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-colors hover:shadow-md">
                    <div class="flex items-center gap-4">
                        <div class="p-3 bg-purple-100 dark:bg-purple-900/50 rounded-lg">
                            <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6l4 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 dark:text-gray-400">Total Waktu</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalTimeInHours }} <span
                                    class="text-sm font-normal text-gray-500">jam</span></p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Additional Stats & Recent Notes --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- Quick Stats --}}
                <div
                    class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-colors">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Statistik Cepat</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Total Kata</span>
                            <span
                                class="text-sm font-semibold text-gray-900 dark:text-white">{{ number_format($totalWords) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Kata/Note</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $totalNotes > 0 ? number_format(round($totalWords / $totalNotes)) : 0 }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600 dark:text-gray-400">Persentase Dipin</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                {{ $totalNotes > 0 ? round(($pinnedNotes / $totalNotes) * 100) : 0 }}%
                            </span>
                        </div>
                        @if ($totalTimeInHours > 0)
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600 dark:text-gray-400">Rata-rata Waktu/Hari</span>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ round($totalTimeInHours / max(1, now()->diffInDays(Note::where('user_id', $userId)->oldest()->first()->created_at ?? now())), 1) }}
                                    jam
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Recent Notes --}}
                <div
                    class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6 transition-colors">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Catatan Terbaru</h2>
                    @if ($recentNotes->count() > 0)
                        <div class="space-y-3">
                            @foreach ($recentNotes as $note)
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-lg">
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2">
                                            @if ($note->is_pinned)
                                                <svg class="w-4 h-4 text-yellow-500 flex-shrink-0" fill="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path
                                                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                                </svg>
                                            @endif
                                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                                                {{ $note->title ?? 'Tanpa Judul' }}</p>
                                        </div>
                                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                            {{ $note->created_at->diffForHumans() }}</p>
                                    </div>
                                    <a href="{{ route('notepad') }}"
                                        class="text-xs text-indigo-600 dark:text-indigo-400 hover:underline ml-4">Ke Notepad</a>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-8">Belum ada catatan</p>
                    @endif
                </div>

            </div>

        </div>

    </main>

</div>
