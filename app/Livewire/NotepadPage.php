<?php

namespace App\Livewire;

use App\Models\Note;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Contracts\View\View;

class NotepadPage extends Component
{
    use WithFileUploads;

    public string $search         = '';
    public ?int   $filterTagId    = null;
    public string $activeTab      = 'all'; // Bisa 'all', 'pinned', atau 'trash'

    public ?int   $activeNoteId  = null;
    public string $title         = '';
    public string $content       = '';
    public string $drawingData   = '';
    public array  $images        = [];
    public bool   $isPinned      = false;
    public string $noteColor     = '#ffffff';
    public string $titleColor    = '#1f2937';
    public array  $selectedTags  = [];

    public bool $showDrawingCanvas = false;
    public bool $showTagManager    = false;
    public bool $isFullscreen      = false;

    public string $newTagName  = '';
    public string $newTagColor = '#6366f1';

    public $uploadedImage;
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
    }

    #[Computed]
    public function notes()
    {
        $query = Note::where('user_id', Auth::id());

        // Logika untuk menampilkan tab sampah atau tab biasa
        if ($this->activeTab === 'trash') {
            $query->onlyTrashed();
        } else {
            if ($this->activeTab === 'pinned') {
                $query->where('is_pinned', true);
            }
        }

        return $query->when($this->search, fn($q) => $q->where(function ($query) {
            $query->where('title', 'like', '%' . $this->search . '%')
                ->orWhere('content', 'like', '%' . $this->search . '%');
        }))
            ->when($this->filterTagId, fn($q) => $q->whereHas('tags', fn($query) => $query->where('tags.id', $this->filterTagId)))
            ->with('tags')
            ->orderByDesc('is_pinned')
            ->orderByDesc('updated_at')
            ->get();
    }

    #[Computed]
    public function allTags()
    {
        return Tag::where('user_id', Auth::id())->get();
    }

    #[Computed]
    public function activeNote()
    {
        // Pakai withTrashed() supaya catatan di sampah tetap bisa dirender
        return $this->activeNoteId ? Note::withTrashed()->with('tags')->find($this->activeNoteId) : null;
    }

    public function createNote(): void
    {
        $this->activeTab = 'all'; // Kembalikan ke tab all saat bikin catatan baru

        $note = Note::create([
            'user_id' => Auth::id(),
            'title'   => 'Untitled Note',
            'content' => '',
            'color'   => '#ffffff',
            'title_color' => '#1f2937',
        ]);

        $this->openNote($note->id);
    }

    public function openNote(int $id): void
    {
        // Tambahkan withTrashed() agar bisa membuka catatan di tong sampah
        $note = Note::withTrashed()->with('tags')->where('user_id', Auth::id())->findOrFail($id);

        $this->activeNoteId      = $note->id;
        $this->title             = $note->title;
        $this->content           = $note->content ?? '';
        $this->drawingData       = $note->drawing_data ?? '';
        $this->images            = $note->images ?? [];
        $this->isPinned          = $note->is_pinned;
        $this->noteColor         = $note->color;
        $this->titleColor        = $note->title_color ?? '#1f2937';
        $this->selectedTags      = $note->tags->pluck('id')->toArray();
        $this->showDrawingCanvas = false;
        $this->isDirty           = false;

        $this->dispatch('trix-set-content', content: $note->content ?? '');
    }

    public function saveNoteWithContent(string $htmlContent): void
    {
        // Jangan izinkan save jika sedang di tab sampah
        if ($this->activeTab === 'trash') return;

        $this->content = $htmlContent;
        $this->saveNote();
    }

    public function saveNote(): void
    {
        if (! $this->activeNoteId || $this->activeTab === 'trash') {
            return;
        }

        $note = Note::where('user_id', Auth::id())->findOrFail($this->activeNoteId);

        $note->update([
            'title'        => $this->title ?: 'Untitled Note',
            'content'      => $this->content,
            'drawing_data' => $this->drawingData,
            'images'       => $this->images,
            'is_pinned'    => $this->isPinned,
            'color'        => $this->noteColor,
            'title_color'  => $this->titleColor,
        ]);

        $note->tags()->sync($this->selectedTags);
        $this->isDirty = false;
        $this->dispatch('note-saved');
    }

    public function deleteNote(): void
    {
        if (! $this->activeNoteId) {
            return;
        }

        // Ini sekarang akan melakukan Soft Delete
        $note = Note::where('user_id', Auth::id())->findOrFail($this->activeNoteId);
        $note->delete();

        $this->activeNoteId  = null;
        $this->title         = '';
        $this->content       = '';
        $this->images        = [];
        $this->drawingData   = '';
    }

    // FUNGSI BARU: Mengembalikan catatan dari sampah
    public function restoreNote(int $id): void
    {
        $note = Note::onlyTrashed()->where('user_id', Auth::id())->find($id);
        if ($note) {
            $note->restore();
            $this->activeNoteId = null;
            $this->activeTab = 'all'; // Langsung pindah ke tab semua catatan
        }
    }

    // FUNGSI BARU: Menghapus catatan secara permanen
    public function forceDeleteNote(int $id): void
    {
        $note = Note::onlyTrashed()->where('user_id', Auth::id())->find($id);
        if ($note) {
            // Hapus gambar fisik dari storage jika ada
            if (!empty($note->images)) {
                foreach ($note->images as $imageUrl) {
                    $path = str_replace('/storage/', '', $imageUrl);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }

            $note->forceDelete();
            $this->activeNoteId = null;
            $this->title = '';
            $this->content = '';
            $this->images = [];
            $this->drawingData = '';
        }
    }

    public function togglePin(): void
    {
        if ($this->activeTab === 'trash') return;
        $this->isPinned = ! $this->isPinned;
        $this->saveNote();
    }

    public function setNoteColor(string $color): void
    {
        if ($this->activeTab === 'trash') return;
        $this->noteColor = $color;
        $this->saveNote();
    }

    public function setTitleColor(string $color): void
    {
        if ($this->activeTab === 'trash') return;
        $this->titleColor = $color;
        $this->saveNote();
    }

    public function toggleFullscreen(): void
    {
        $this->isFullscreen = ! $this->isFullscreen;
    }

    public function saveDrawing(string $dataUrl): void
    {
        if ($this->activeTab === 'trash') return;
        $this->drawingData       = $dataUrl;
        $this->showDrawingCanvas = false;
        $this->saveNote();
    }

    public function clearDrawing(): void
    {
        if ($this->activeTab === 'trash') return;
        $this->drawingData = '';
        $this->saveNote();
    }

    public function uploadImage(): void
    {
        if ($this->activeTab === 'trash') return;
        $this->validate(['uploadedImage' => 'image|max:4096']);

        $path           = $this->uploadedImage->store('note-images', 'public');
        $this->images[] = Storage::url($path);
        $this->uploadedImage = null;
        $this->saveNote();
    }

    public function removeImage(int $index): void
    {
        if ($this->activeTab === 'trash') return;
        if (isset($this->images[$index])) {
            $imageUrl = $this->images[$index];
            $path = str_replace('/storage/', '', $imageUrl);

            if (Storage::disk('public')->exists($path)) {
                Storage::disk('public')->delete($path);
            }

            array_splice($this->images, $index, 1);
            $this->saveNote();
        }
    }

    public function createTag(): void
    {
        $this->validate([
            'newTagName'  => 'required|string|max:32',
            'newTagColor' => 'required|string',
        ]);

        Tag::create([
            'user_id' => Auth::id(),
            'name'    => $this->newTagName,
            'color'   => $this->newTagColor,
        ]);

        $this->newTagName  = '';
        $this->newTagColor = '#6366f1';
        unset($this->allTags);
    }

    public function deleteTag(int $id): void
    {
        Tag::where('user_id', Auth::id())->findOrFail($id)->delete();
        $this->selectedTags = array_values(array_filter($this->selectedTags, fn($t) => $t !== $id));
        unset($this->allTags);
    }

    public function toggleTag(int $id): void
    {
        if ($this->activeTab === 'trash') return;
        if (in_array($id, $this->selectedTags)) {
            $this->selectedTags = array_values(array_filter($this->selectedTags, fn($t) => $t !== $id));
        } else {
            $this->selectedTags[] = $id;
        }
    }

    public function render(): View
    {
        return view('livewire.notepad-page')->layout('layouts.notepad');
    }
}
