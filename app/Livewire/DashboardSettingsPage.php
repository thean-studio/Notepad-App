<?php

namespace App\Livewire;

use App\Models\Note;
use App\Models\User;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class DashboardSettingsPage extends Component
{
    public function mount(): void
    {
        if (!Auth::check()) {
            $user = User::firstOrCreate(
                ['email' => 'guest@notepad.com'],
                ['name' => 'Guest', 'password' => bcrypt('password')]
            );
            Auth::login($user);
        }
    }

    public function render(): View
    {
        $userId = Auth::id();

        // Total notes
        $totalNotes = Note::where('user_id', $userId)->count();

        // Notes yang di-pin
        $pinnedNotes = Note::where('user_id', $userId)
            ->where('is_pinned', true)
            ->count();

        // Notes di sampah
        $trashedNotes = Note::onlyTrashed()->where('user_id', $userId)->count();

        // Note terbaru
        $recentNotes = Note::where('user_id', $userId)
            ->latest()
            ->take(5)
            ->get();

        // Statistik tambahan - total kata
        $totalWords = Note::where('user_id', $userId)
            ->get()
            ->sum(function ($note) {
                return str_word_count(strip_tags($note->content ?? ''));
            });

        // Notes aktif (tidak di sampah)
        $activeNotes = $totalNotes - $trashedNotes;

        // Rata-rata waktu yang dihabiskan (dalam menit)
        $avgTimeSpent = Note::where('user_id', $userId)
            ->whereNotNull('time_spent')
            ->where('time_spent', '>', 0)
            ->avg('time_spent');

        $avgTimeInMinutes = $avgTimeSpent ? round($avgTimeSpent / 60, 1) : 0;

        // Total waktu yang dihabiskan (dalam jam)
        $totalTimeSpent = Note::where('user_id', $userId)
            ->whereNotNull('time_spent')
            ->sum('time_spent');

        $totalTimeInHours = round($totalTimeSpent / 3600, 1);

        return view('livewire.dashboard-settings-page', [
            'totalNotes' => $totalNotes,
            'pinnedNotes' => $pinnedNotes,
            'trashedNotes' => $trashedNotes,
            'activeNotes' => $activeNotes,
            'avgTimeInMinutes' => $avgTimeInMinutes,
            'totalTimeInHours' => $totalTimeInHours,
            'recentNotes' => $recentNotes,
            'totalWords' => $totalWords,
        ])->layout('layouts.notepad');
    }
}
