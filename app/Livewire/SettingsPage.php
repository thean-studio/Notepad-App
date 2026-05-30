<?php

namespace App\Livewire;

use App\Models\User;
use App\Models\Note;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SettingsPage extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $profilePicture;
    public bool $isEditing = false;
    public string $successMessage = '';
    public bool $isDirty = false;

    // Tab active
    public string $activeTab = 'profile';

    // Change Password
    public string $currentPassword = '';
    public string $newPassword = '';
    public string $newPasswordConfirmation = '';

    // Preferences
    public bool $darkMode = false;
    public string $defaultFont = 'sans';
    public string $defaultNoteColor = '#ffffff';
    public bool $autoSave = true;

    // Danger Zone
    public string $deleteConfirmation = '';

    public function mount(): void
    {
        if (!Auth::check()) {
            $user = User::firstOrCreate(
                ['email' => 'guest@notepad.com'],
                ['name' => 'Guest', 'password' => bcrypt('password')]
            );
            Auth::login($user);
        }
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    public function updatedProfilePicture(): void
    {
        $this->isDirty = true;
    }

    public function saveProfile(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'profilePicture' => 'nullable|image|max:5000',
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->profilePicture) {
            if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
                Storage::delete('public/' . $user->profile_picture);
            }

            $path = $this->profilePicture->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        $this->successMessage = 'Profile berhasil diperbarui!';
        $this->isEditing = false;
        $this->isDirty = false;
        $this->profilePicture = null;

        $this->dispatch('success-shown');
    }

    public function changePassword(): void
    {
        $this->validate([
            'currentPassword' => 'required|string',
            'newPassword' => 'required|string|min:8|different:currentPassword',
            'newPasswordConfirmation' => 'required|string|same:newPassword',
        ]);

        $user = Auth::user();

        if (!Hash::check($this->currentPassword, $user->password)) {
            $this->addError('currentPassword', 'Password saat ini tidak sesuai.');
            return;
        }

        $user->password = Hash::make($this->newPassword);
        $user->save();

        $this->reset(['currentPassword', 'newPassword', 'newPasswordConfirmation']);
        $this->successMessage = 'Password berhasil diubah!';
        $this->dispatch('success-shown');
    }

    public function savePreferences(): void
    {
        // Simpan preferences ke session
        session([
            'dark_mode' => $this->darkMode,
            'default_font' => $this->defaultFont,
            'default_note_color' => $this->defaultNoteColor,
            'auto_save' => $this->autoSave,
        ]);

        $this->successMessage = 'Preferensi berhasil disimpan!';
        $this->dispatch('success-shown');
    }

    public function deleteAccount(): void
    {
        if ($this->deleteConfirmation !== 'HAPUS') {
            $this->addError('deleteConfirmation', 'Ketik "HAPUS" untuk konfirmasi penghapusan akun.');
            return;
        }

        $user = Auth::user();

        // Hapus semua notes user
        Note::where('user_id', $user->id)->forceDelete();

        // Hapus profile picture jika ada
        if ($user->profile_picture && Storage::exists('public/' . $user->profile_picture)) {
            Storage::delete('public/' . $user->profile_picture);
        }

        // Hapus user
        $user->delete();

        // Logout
        Auth::logout();

        // Redirect
        $this->redirect(route('login'));
    }

    public function exportNotes(): StreamedResponse
    {
        $notes = Note::where('user_id', Auth::id())->get();

        $content = "Ekspor Catatan - " . now()->format('d/m/Y H:i') . "\n";
        $content .= str_repeat('=', 50) . "\n\n";

        foreach ($notes as $index => $note) {
            $content .= ($index + 1) . ". " . ($note->title ?? 'Tanpa Judul') . "\n";
            $content .= "   Dibuat: " . $note->created_at->format('d/m/Y H:i') . "\n";
            $content .= "   Status: " . ($note->is_pinned ? '📌 Dipin' : 'Normal') . "\n";
            $content .= "   " . str_repeat('-', 40) . "\n";
            $content .= "   " . wordwrap(strip_tags($note->content ?? ''), 60) . "\n";
            $content .= str_repeat('=', 50) . "\n\n";
        }

        return response()->streamDownload(function () use ($content) {
            echo $content;
        }, 'catatan-' . now()->format('Y-m-d') . '.txt');
    }

    public function cancelEdit(): void
    {
        $this->mount();
        $this->isEditing = false;
        $this->isDirty = false;
        $this->profilePicture = null;
    }

    public function render(): View
    {
        $userId = Auth::id();

        return view('livewire.settings-page', [
            'totalNotes' => Note::where('user_id', $userId)->count(),
            'trashedNotes' => Note::onlyTrashed()->where('user_id', $userId)->count(),
            'avgTime' => 0
        ])->layout('layouts.notepad');
    }
}
