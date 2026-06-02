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

    // Sidebar & search
    public string $search      = '';
    public ?int   $filterTagId = null;
    public string $activeTab   = 'all'; // all | pinned | trash | daily

    // Active note
    public ?int   $activeNoteId  = null;
    public string $title         = '';
    public string $content       = '';
    public string $drawingData   = '';
    public array  $images        = [];
    public bool   $isPinned      = false;
    public string $noteColor     = '#ffffff';
    public string $titleColor    = '#1f2937';
    public array  $selectedTags  = [];

    // UI panels
    public bool $showDrawingCanvas = false;
    public bool $showTagManager    = false;
    public bool $isFullscreen      = false;

    // Tag manager
    public string $newTagName  = '';
    public string $newTagColor = '#6366f1';

    // Image upload
    public $uploadedImage;
    public bool $isDirty = false;

    // ── Mount ─────────────────────────────────────────────────────

    public function mount(): void
    {
        if (!Auth::check()) {
            Auth::login(User::firstOrCreate(
                ['email' => 'guest@notepad.com'],
                ['name' => 'Guest', 'password' => bcrypt('password')]
            ));
        }
    }

    // ── Computed ──────────────────────────────────────────────────

    #[Computed]
    public function notes()
    {
        $query = Note::where('user_id', Auth::id());

        if ($this->activeTab === 'trash') {
            $query->onlyTrashed();
        } else {
            if ($this->activeTab === 'pinned') {
                $query->where('is_pinned', true);
            }
            $query->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
                ->when($this->filterTagId, fn($q) => $q->whereHas(
                    'tags',
                    fn($q) =>
                    $q->where('tags.id', $this->filterTagId)
                ))
                ->orderByDesc('is_pinned')
                ->orderByDesc('updated_at');
        }

        return $query->with('tags')->get();
    }

    #[Computed]
    public function allTags()
    {
        return Tag::where('user_id', Auth::id())->get();
    }

    #[Computed]
    public function activeNote()
    {
        return $this->activeNoteId
            ? Note::withTrashed()->with('tags')->find($this->activeNoteId)
            : null;
    }

    #[Computed]
    public function dailyNotes()
    {
        $notes = Note::where('user_id', Auth::id())
            ->when($this->search, fn($q) => $q->where('title', 'like', '%' . $this->search . '%'))
            ->when($this->filterTagId, fn($q) => $q->whereHas(
                'tags',
                fn($q) => $q->where('tags.id', $this->filterTagId)
            ))
            ->orderByDesc('is_pinned')
            ->orderByDesc('updated_at')
            ->with('tags')
            ->get();

        $today = now()->startOfDay();
        $yesterday = now()->subDay()->startOfDay();
        $weekAgo = now()->subDays(7)->startOfDay();

        $grouped = [
            'Today' => $notes->filter(fn($n) => $n->updated_at->startOfDay()->eq($today)),
            'Yesterday' => $notes->filter(fn($n) => $n->updated_at->startOfDay()->eq($yesterday)),
            'This Week' => $notes->filter(
                fn($n) =>
                $n->updated_at->startOfDay()->gt($weekAgo) &&
                    $n->updated_at->startOfDay()->lt($yesterday)
            ),
            'Older' => $notes->filter(fn($n) => $n->updated_at->startOfDay()->lte($weekAgo)),
        ];

        return array_filter($grouped, fn($items) => $items->count() > 0);
    }

    // ── Note CRUD ─────────────────────────────────────────────────

    public function createNote(): void
    {
        $this->activeTab = 'all';

        $note = Note::create([
            'user_id'     => Auth::id(),
            'title'       => 'Untitled Note',
            'content'     => '',
            'color'       => '#ffffff',
            'title_color' => '#1f2937',
        ]);

        $this->openNote($note->id);
    }

    public function openNote(int $id): void
    {
        $note = Note::withTrashed()->with('tags')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

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
        if ($this->activeTab === 'trash') return;
        $this->content = $htmlContent;
        $this->saveNote();
    }

    public function saveNote(): void
    {
        if (!$this->activeNoteId || $this->activeTab === 'trash') return;

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

    // Soft delete — pindah ke sampah
    public function deleteNote(): void
    {
        if (!$this->activeNoteId) return;
        Note::where('user_id', Auth::id())->findOrFail($this->activeNoteId)->delete();
        $this->resetEditor();
    }

    // Restore dari sampah
    public function restoreNote(int $id): void
    {
        $note = Note::onlyTrashed()->where('user_id', Auth::id())->find($id);
        if ($note) {
            $note->restore();
            $this->activeTab = 'all';
            $this->resetEditor();
        }
    }

    // Hapus permanen
    public function forceDeleteNote(int $id): void
    {
        $note = Note::onlyTrashed()->where('user_id', Auth::id())->find($id);
        if ($note) {
            if (!empty($note->images)) {
                foreach ($note->images as $imageUrl) {
                    $path = str_replace('/storage/', '', $imageUrl);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
            }
            $note->forceDelete();
            $this->resetEditor();
        }
    }

    public function togglePin(): void
    {
        if ($this->activeTab === 'trash') return;
        $this->isPinned = !$this->isPinned;
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
        $this->isFullscreen = !$this->isFullscreen;
    }

    // ── Drawing ───────────────────────────────────────────────────

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

    // ── Images ────────────────────────────────────────────────────

    public function uploadImage(): void
    {
        if ($this->activeTab === 'trash') return;
        $this->validate(['uploadedImage' => 'image|max:4096']);
        $path = $this->uploadedImage->store('note-images', 'public');
        $this->images[] = Storage::url($path);
        $this->uploadedImage = null;
        $this->saveNote();
    }

    public function removeImage(int $index): void
    {
        if ($this->activeTab === 'trash') return;
        if (!isset($this->images[$index])) return;
        $path = str_replace('/storage/', '', $this->images[$index]);
        if (Storage::disk('public')->exists($path)) Storage::disk('public')->delete($path);
        array_splice($this->images, $index, 1);
        $this->saveNote();
    }

    // ── Tags ──────────────────────────────────────────────────────

    public function createTag(): void
    {
        $this->validate([
            'newTagName'  => 'required|string|max:32',
            'newTagColor' => 'required|string',
        ]);
        Tag::create(['user_id' => Auth::id(), 'name' => $this->newTagName, 'color' => $this->newTagColor]);
        $this->newTagName = '';
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

    // ── Helper ────────────────────────────────────────────────────

    private function resetEditor(): void
    {
        $this->activeNoteId  = null;
        $this->title         = '';
        $this->content       = '';
        $this->drawingData   = '';
        $this->images        = [];
        $this->selectedTags  = [];
        $this->isPinned      = false;
    }

    // ── Render ────────────────────────────────────────────────────

    public function render(): View
    {
        return view('livewire.notepad-page')->layout('layouts.notepad');
    }
}
