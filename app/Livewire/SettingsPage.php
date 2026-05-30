<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;

class SettingsPage extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public $profilePicture;
    public bool $isEditing = false;
    public string $successMessage = '';
    public bool $isDirty = false;

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

    public function saveSettings(): void
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'profilePicture' => 'nullable|image|max:5000', // Maksimal 5MB
        ]);

        $user = Auth::user();
        $user->name = $this->name;
        $user->email = $this->email;

        if ($this->profilePicture) {
            // Hapus foto lama jika ada
            if ($user->profile_picture && Storage::exists($user->profile_picture)) {
                Storage::delete($user->profile_picture);
            }

            // Simpan foto baru
            $path = $this->profilePicture->store('profile-pictures', 'public');
            $user->profile_picture = $path;
        }

        $user->save();

        $this->successMessage = 'Profile berhasil diperbarui!';
        $this->isEditing = false;
        $this->isDirty = false;
        $this->profilePicture = null;

        // Clear success message after 3 seconds
        $this->dispatch('success-shown');
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
        return view('livewire.settings-page')->layout('layouts.notepad');
    }
}
