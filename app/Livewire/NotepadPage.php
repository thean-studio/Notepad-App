<?php

namespace App\Livewire;

use App\Models\Note;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithFileUploads;

class NotepadPage extends Component
{
    use WithFileUploads;

    // Sidebar & search
    public string $search         = '';
    public ?int   $filterTagId    = null;
    public string $activeTab      = 'all'; // all | pinned

    // Active note state
    public ?int    $activeNoteId  = null;
    public string  $title         = '';
    public string  $content       = '';
    public string  $drawingData   = '';
    public array   $images        = [];
    public bool    $isPinned      = false;
    public string  $noteColor     = '#ffffff';
    public array   $selectedTags  = [];

    // UI panels
    public bool $showDrawingCanvas = false;
    public bool $showTagManager    = false;

    // Tag manager
    public string $newTagName  = '';
    public string $newTagColor = '#6366f1';

    // Image upload (temp)
    public $uploadedImage;

    // Auto-save debounce flag (handled by JS + dispatch)
    public bool $isDirty = false;

    public function mount(): void
    {
        $user = \App\Models\User::firstOrCreate(
            ['email' => 'guest@notepad.com'],
            ['name' => 'Guest', 'password' => bcrypt('password')]
        );
        Auth::login($user);
    }

    // ----------------------------------------------------------------
    // Computed
    // ----------------------------------------------------------------

    #[Computed]
    public function notes()
    {
        return Note::where('user_id', Auth::id())
            ->when($this->search, fn($q) => $q->where(function ($q) {
                $q->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('content', 'like', '%' . $this->search . '%');
            }))
            ->when($this->filterTagId, fn($q) => $q->whereHas('tags', fn($q) => $q->where('tags.id', $this->filterTagId)))
            ->when($this->activeTab === 'pinned', fn($q) => $q->where('is_pinned', true))
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
        return $this->activeNoteId ? Note::with('tags')->find($this->activeNoteId) : null;
    }

    // ----------------------------------------------------------------
    // Note CRUD
    // ----------------------------------------------------------------

    public function createNote(): void
    {
        $note = Note::create([
            'user_id' => Auth::id(),
            'title'   => 'Untitled Note',
            'content' => '',
            'color'   => '#ffffff',
        ]);

        $this->openNote($note->id);
    }

    public function openNote(int $id): void
    {
        $note = Note::with('tags')->where('user_id', Auth::id())->findOrFail($id);

        $this->activeNoteId  = $note->id;
        $this->title         = $note->title;
        $this->content       = $note->content ?? '';
        $this->drawingData   = $note->drawing_data ?? '';
        $this->images        = $note->images ?? [];
        $this->isPinned      = $note->is_pinned;
        $this->noteColor     = $note->color;
        $this->selectedTags  = $note->tags->pluck('id')->toArray();
        $this->showDrawingCanvas = false;
        $this->isDirty       = false;
    }

    public function saveNote(): void
    {
        if (! $this->activeNoteId) {
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

        Note::where('user_id', Auth::id())->findOrFail($this->activeNoteId)->delete();

        $this->activeNoteId = null;
        $this->title        = '';
        $this->content      = '';
        $this->images       = [];
        $this->drawingData  = '';
    }

    public function togglePin(): void
    {
        $this->isPinned = ! $this->isPinned;
        $this->saveNote();
    }

    public function setNoteColor(string $color): void
    {
        $this->noteColor = $color;
        $this->saveNote();
    }

    // ----------------------------------------------------------------
    // Drawing
    // ----------------------------------------------------------------

    public function saveDrawing(string $dataUrl): void
    {
        $this->drawingData = $dataUrl;
        $this->saveNote();
        $this->showDrawingCanvas = false;
    }

    public function clearDrawing(): void
    {
        $this->drawingData = '';
        $this->saveNote();
    }

    // ----------------------------------------------------------------
    // Images
    // ----------------------------------------------------------------

    public function uploadImage(): void
    {
        $this->validate(['uploadedImage' => 'image|max:4096']);

        $path   = $this->uploadedImage->store('note-images', 'public');
        $this->images[] = Storage::url($path);
        $this->uploadedImage = null;
        $this->saveNote();
    }

    public function removeImage(int $index): void
    {
        array_splice($this->images, $index, 1);
        $this->saveNote();
    }

    // ----------------------------------------------------------------
    // Tags
    // ----------------------------------------------------------------

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
        $this->selectedTags = array_filter($this->selectedTags, fn($t) => $t !== $id);
        unset($this->allTags);
    }

    public function toggleTag(int $id): void
    {
        if (in_array($id, $this->selectedTags)) {
            $this->selectedTags = array_values(array_filter($this->selectedTags, fn($t) => $t !== $id));
        } else {
            $this->selectedTags[] = $id;
        }
    }

    // ----------------------------------------------------------------
    // Render
    // ----------------------------------------------------------------

    public function render()
    {
        return view('livewire.notepad-page')->layout('layouts.notepad');
    }
}
