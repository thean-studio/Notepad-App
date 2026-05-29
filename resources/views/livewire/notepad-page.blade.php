<div class="flex h-screen overflow-hidden bg-gray-50" x-data="notepadApp()" x-init="init()">

    {{-- ═══════════════════════════════════════════
         SIDEBAR
    ═══════════════════════════════════════════ --}}
    <aside class="flex flex-col w-72 min-w-[260px] bg-white border-r border-gray-200 shadow-sm">

        {{-- Logo / Header --}}
        <div class="flex items-center gap-2 px-5 py-4 border-b border-gray-100">
            <svg class="w-6 h-6 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            <span class="text-base font-semibold text-gray-800 tracking-tight">Notepad</span>
            <button wire:click="createNote"
                class="ml-auto flex items-center justify-center w-7 h-7 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition-colors"
                title="New Note">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/>
                </svg>
            </button>
        </div>

        {{-- Search --}}
        <div class="px-4 py-3">
            <div class="relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input wire:model.live.debounce.300ms="search"
                    type="text" placeholder="Search notes…"
                    class="w-full pl-9 pr-3 py-2 text-sm bg-gray-100 border border-transparent rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300 focus:bg-white transition-all placeholder-gray-400" />
            </div>
        </div>

        {{-- Tabs --}}
        <div class="flex gap-1 px-4 pb-2">
            <button wire:click="$set('activeTab','all')"
                class="flex-1 py-1.5 text-xs font-medium rounded-lg transition-colors
                    {{ $activeTab === 'all' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:bg-gray-100' }}">
                All Notes
            </button>
            <button wire:click="$set('activeTab','pinned')"
                class="flex-1 py-1.5 text-xs font-medium rounded-lg transition-colors
                    {{ $activeTab === 'pinned' ? 'bg-indigo-100 text-indigo-700' : 'text-gray-500 hover:bg-gray-100' }}">
                📌 Pinned
            </button>
        </div>

        {{-- Tags filter --}}
        @if($this->allTags->count())
        <div class="px-4 pb-2">
            <p class="text-[10px] uppercase tracking-widest text-gray-400 font-semibold mb-1.5">Tags</p>
            <div class="flex flex-wrap gap-1.5">
                <button wire:click="$set('filterTagId', null)"
                    class="px-2.5 py-0.5 text-xs rounded-full border transition-colors
                        {{ is_null($filterTagId) ? 'bg-gray-800 text-white border-gray-800' : 'border-gray-300 text-gray-500 hover:border-gray-400' }}">
                    All
                </button>
                @foreach($this->allTags as $tag)
                <button wire:click="$set('filterTagId', {{ $tag->id }})"
                    class="px-2.5 py-0.5 text-xs rounded-full border transition-colors"
                    style="background-color: {{ $filterTagId === $tag->id ? $tag->color : 'transparent' }};
                           color: {{ $filterTagId === $tag->id ? '#fff' : $tag->color }};
                           border-color: {{ $tag->color }};">
                    {{ $tag->name }}
                </button>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Notes List --}}
        <div class="flex-1 overflow-y-auto px-3 pb-4 space-y-1.5 mt-1">
            @forelse($this->notes as $note)
            <button wire:click="openNote({{ $note->id }})"
                class="note-card w-full text-left px-3 py-3 rounded-xl border transition-all
                    {{ $activeNoteId === $note->id
                        ? 'bg-indigo-50 border-indigo-200 shadow-sm'
                        : 'bg-white border-gray-100 hover:border-gray-200 hover:shadow-sm' }}"
                style="{{ $note->color !== '#ffffff' ? 'border-left: 3px solid '.$note->color.';' : '' }}">
                <div class="flex items-start justify-between gap-2">
                    <p class="text-sm font-medium text-gray-800 truncate leading-5">
                        {{ $note->is_pinned ? '📌 ' : '' }}{{ $note->title }}
                    </p>
                    <span class="text-[10px] text-gray-400 shrink-0 mt-0.5">
                        {{ $note->updated_at->diffForHumans(null, true) }}
                    </span>
                </div>
                @if($note->content)
                <p class="text-xs text-gray-400 mt-1 line-clamp-2 leading-relaxed">
                    {{ strip_tags($note->content) }}
                </p>
                @endif
                @if($note->tags->count())
                <div class="flex flex-wrap gap-1 mt-2">
                    @foreach($note->tags as $tag)
                    <span class="px-1.5 py-0.5 text-[10px] rounded-full text-white"
                          style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                    @endforeach
                </div>
                @endif
            </button>
            @empty
            <div class="flex flex-col items-center justify-center py-12 text-center">
                <svg class="w-10 h-10 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-sm text-gray-400">No notes yet</p>
                <button wire:click="createNote" class="mt-3 text-xs text-indigo-500 hover:text-indigo-600 font-medium">
                    + Create your first note
                </button>
            </div>
            @endforelse
        </div>

        {{-- Tag Manager Button --}}
        <div class="border-t border-gray-100 p-3">
            <button wire:click="$toggle('showTagManager')"
                class="flex items-center gap-2 w-full px-3 py-2 text-xs text-gray-500 hover:text-gray-700 hover:bg-gray-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                </svg>
                Manage Tags
            </button>
        </div>
    </aside>

    {{-- ═══════════════════════════════════════════
         MAIN EDITOR AREA
    ═══════════════════════════════════════════ --}}
    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">

        @if($activeNoteId)

            {{-- Toolbar --}}
            <div class="flex items-center gap-2 px-6 py-3 bg-white border-b border-gray-200 shadow-sm">

                {{-- Pin --}}
                <button wire:click="togglePin"
                    title="{{ $isPinned ? 'Unpin' : 'Pin' }}"
                    class="p-1.5 rounded-lg transition-colors {{ $isPinned ? 'text-amber-500 bg-amber-50' : 'text-gray-400 hover:text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-4 h-4" fill="{{ $isPinned ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"/>
                    </svg>
                </button>

                {{-- Note color picker --}}
                <div class="flex items-center gap-1">
                    @foreach(['#ffffff','#fef3c7','#d1fae5','#dbeafe','#fce7f3','#ede9fe','#fee2e2'] as $clr)
                    <button wire:click="setNoteColor('{{ $clr }}')"
                        class="w-5 h-5 rounded-full border-2 transition-transform hover:scale-110"
                        style="background: {{ $clr }}; border-color: {{ $noteColor === $clr ? '#6366f1' : '#d1d5db' }};"
                        title="{{ $clr }}">
                    </button>
                    @endforeach
                </div>

                <div class="h-5 w-px bg-gray-200 mx-1"></div>

                {{-- Drawing --}}
                <button wire:click="$toggle('showDrawingCanvas')"
                    class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium rounded-lg transition-colors
                        {{ $showDrawingCanvas ? 'bg-indigo-500 text-white' : 'text-gray-600 hover:bg-gray-100' }}">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                    </svg>
                    Draw
                </button>

                {{-- Upload image --}}
                <label class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg cursor-pointer transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Image
                    <input wire:model="uploadedImage" type="file" accept="image/*" class="hidden"
                        wire:change="uploadImage">
                </label>

                {{-- Tags --}}
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open"
                        class="flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"/>
                        </svg>
                        Tags
                    </button>
                    <div x-show="open" @click.outside="open = false" x-cloak
                        class="absolute top-full left-0 mt-1 bg-white border border-gray-200 rounded-xl shadow-lg p-3 w-56 z-50">
                        <p class="text-xs text-gray-500 mb-2 font-medium">Apply tags</p>
                        @forelse($this->allTags as $tag)
                        <label class="flex items-center gap-2 py-1 cursor-pointer hover:bg-gray-50 px-1 rounded-lg">
                            <input wire:click="toggleTag({{ $tag->id }})" type="checkbox"
                                {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-indigo-500 focus:ring-indigo-300" />
                            <span class="w-2.5 h-2.5 rounded-full" style="background: {{ $tag->color }}"></span>
                            <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                        </label>
                        @empty
                        <p class="text-xs text-gray-400 text-center py-2">No tags yet</p>
                        @endforelse
                    </div>
                </div>

                <div class="flex-1"></div>

                {{-- Save indicator --}}
                <span x-show="saving" x-cloak class="text-xs text-gray-400 animate-pulse">Saving…</span>
                <span x-show="saved" x-cloak class="text-xs text-green-500 flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                    </svg>
                    Saved
                </span>

                {{-- Tombol Save Alpine --}}
                <button x-on:click="triggerManualSave()"
                    class="px-3 py-1.5 text-xs font-medium bg-indigo-500 hover:bg-indigo-600 text-white rounded-lg transition-colors">
                    Save
                </button>

                <button wire:click="deleteNote"
                    onclick="return confirm('Delete this note?')"
                    class="p-1.5 text-gray-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                    </svg>
                </button>
            </div>

            {{-- Editor Content --}}
            <div class="flex-1 overflow-y-auto"
                 style="background-color: {{ $noteColor }}">
                <div class="max-w-4xl mx-auto px-8 py-6">

                    {{-- Title --}}
                    <input wire:model.live.debounce.600ms="title"
                        type="text"
                        placeholder="Note title…"
                        class="w-full text-3xl font-semibold text-gray-900 bg-transparent border-none outline-none placeholder-gray-300 mb-4 leading-tight" />

                    {{-- Tags display --}}
                    @if(count($selectedTags))
                    <div class="flex flex-wrap gap-1.5 mb-4">
                        @foreach($this->allTags->whereIn('id', $selectedTags) as $tag)
                        <span class="px-2.5 py-1 text-xs font-medium rounded-full text-white"
                              style="background-color: {{ $tag->color }}">{{ $tag->name }}</span>
                        @endforeach
                    </div>
                    @endif

                    {{-- DRAWING CANVAS --}}
                    @if($showDrawingCanvas)
                    <div class="mb-6 rounded-2xl overflow-hidden border border-gray-200 bg-white shadow-sm"
                         x-init="initCanvas('{{ addslashes($drawingData ?? '') }}')">
                        <div class="flex items-center justify-between px-4 py-2 bg-gray-50 border-b border-gray-200">
                            <span class="text-xs font-medium text-gray-600">✏️ Drawing Canvas</span>
                            <div class="flex items-center gap-2">
                                <label class="text-xs text-gray-500">
                                    Brush:
                                    <input type="range" x-model="brushSize" min="1" max="30" class="w-20 mx-1 align-middle" />
                                    <span x-text="brushSize + 'px'"></span>
                                </label>
                                <input type="color" x-model="brushColor" class="w-7 h-7 rounded cursor-pointer border-0" title="Brush color" />
                                <button @click="eraserMode = !eraserMode"
                                    :class="eraserMode ? 'bg-gray-800 text-white' : 'bg-white text-gray-600 border border-gray-300'"
                                    class="px-2 py-1 text-xs rounded-lg transition-colors">
                                    Eraser
                                </button>
                                <button @click="clearCanvas()"
                                    class="px-2 py-1 text-xs bg-white border border-gray-300 text-gray-600 rounded-lg hover:bg-red-50 hover:text-red-500 hover:border-red-300 transition-colors">
                                    Clear
                                </button>
                                <button @click="saveCanvasDrawing()"
                                    class="px-3 py-1 text-xs bg-indigo-500 text-white rounded-lg hover:bg-indigo-600 transition-colors font-medium">
                                    Insert Drawing
                                </button>
                            </div>
                        </div>
                        <canvas id="drawingCanvas"
                            class="w-full touch-none cursor-crosshair"
                            style="height: 400px; display: block;"
                            @mousedown="startDraw($event)"
                            @mousemove="draw($event)"
                            @mouseup="stopDraw()"
                            @mouseleave="stopDraw()"
                            @touchstart.prevent="startDraw($event.touches[0])"
                            @touchmove.prevent="draw($event.touches[0])"
                            @touchend="stopDraw()">
                        </canvas>
                    </div>
                    @endif

                    {{-- Existing Drawing --}}
                    @if($drawingData && !$showDrawingCanvas)
                    <div class="mb-6 rounded-2xl overflow-hidden border border-gray-200 shadow-sm relative group">
                        <img src="{{ $drawingData }}" alt="Sketch" class="w-full" />
                        <div class="absolute top-2 right-2 flex gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                            <button wire:click="$toggle('showDrawingCanvas')"
                                class="px-2 py-1 text-xs bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50">
                                Edit
                            </button>
                            <button wire:click="clearDrawing"
                                class="px-2 py-1 text-xs bg-white border border-red-200 text-red-500 rounded-lg shadow-sm hover:bg-red-50">
                                Remove
                            </button>
                        </div>
                    </div>
                    @endif

                    {{-- Images --}}
                    @if(count($images))
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-6">
                        @foreach($images as $index => $img)
                        <div class="relative group rounded-xl overflow-hidden border border-gray-200 shadow-sm aspect-video">
                            <img src="{{ $img }}" alt="Note image" class="w-full h-full object-cover" />
                            <button wire:click="removeImage({{ $index }})"
                                class="absolute top-1.5 right-1.5 w-6 h-6 flex items-center justify-center bg-black/60 text-white rounded-full opacity-0 group-hover:opacity-100 transition-opacity text-xs">
                                ✕
                            </button>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    {{-- TRIX RICH TEXT EDITOR --}}
                    <div wire:ignore class="rounded-xl border border-gray-200 overflow-hidden bg-white"
                         x-init="initTrix()">

                        {{-- Text Color Toolbar --}}
                        <div class="flex items-center gap-2 px-3 py-2 border-b border-gray-100 bg-gray-50">
                            <span class="text-xs text-gray-400 font-medium">Text color</span>
                            <div class="flex gap-1.5 flex-wrap">
                                @foreach([
                                    '#1f2937' => 'Black', '#6b7280' => 'Gray', '#ef4444' => 'Red',
                                    '#f97316' => 'Orange', '#eab308' => 'Yellow', '#22c55e' => 'Green',
                                    '#3b82f6' => 'Blue', '#8b5cf6' => 'Purple', '#ec4899' => 'Pink',
                                    '#14b8a6' => 'Teal'
                                ] as $hex => $name)
                                <button
                                    onclick="applyTextColor('{{ $hex }}')"
                                    title="{{ $name }}"
                                    class="w-5 h-5 rounded-full border-2 border-white hover:scale-110 transition-transform ring-1 ring-gray-200"
                                    style="background: {{ $hex }};">
                                </button>
                                @endforeach
                                
                                {{-- Custom color --}}
                                <label title="Custom color" class="w-5 h-5 rounded-full border-2 border-dashed border-gray-300 flex items-center justify-center cursor-pointer hover:scale-110 transition-transform overflow-hidden">
                                    <input type="color" id="customTextColor" class="opacity-0 absolute w-0 h-0"
                                        onchange="applyTextColor(this.value)" />
                                    <span class="text-gray-400 text-[10px] leading-none">+</span>
                                </label>

                                {{-- TOMBOL RESET TEXT COLOR --}}
                                <button onclick="removeTextColor()" title="Reset Text Color" class="w-5 h-5 ml-1 rounded-full border border-gray-300 flex items-center justify-center hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                            
                            <div class="ml-auto flex items-center gap-1.5">
                                <span class="text-xs text-gray-400">Highlight</span>
                                @foreach(['#fef08a','#bbf7d0','#bfdbfe','#fecaca','#e9d5ff'] as $bg)
                                <button
                                    onclick="applyHighlight('{{ $bg }}')"
                                    title="{{ $bg }}"
                                    class="w-5 h-5 rounded border border-gray-200 hover:scale-110 transition-transform"
                                    style="background: {{ $bg }};">
                                </button>
                                @endforeach

                                {{-- TOMBOL RESET HIGHLIGHT --}}
                                <button onclick="removeHighlight()" title="Remove Highlight" class="w-5 h-5 ml-1 rounded border border-gray-300 flex items-center justify-center hover:bg-red-50 text-gray-400 hover:text-red-500 transition-colors">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>
                        </div>

                        <input id="trix-input" type="hidden" value="{{ $content }}" />
                        <trix-editor
                            input="trix-input"
                            class="border-0 shadow-none ring-0 bg-transparent min-h-[300px] text-gray-700 px-4 py-3"
                            placeholder="Start writing…">
                        </trix-editor>
                    </div>

                </div>
            </div>

        @else
            {{-- Empty state --}}
            <div class="flex-1 flex flex-col items-center justify-center bg-gray-50">
                <svg class="w-16 h-16 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h2 class="text-xl font-medium text-gray-400 mb-2">Select or create a note</h2>
                <p class="text-sm text-gray-400 mb-6">Your notes will appear here</p>
                <button wire:click="createNote"
                    class="px-5 py-2.5 bg-indigo-500 hover:bg-indigo-600 text-white rounded-xl text-sm font-medium transition-colors shadow-sm">
                    + New Note
                </button>
            </div>
        @endif
    </main>

    {{-- ═══════════════════════════════════════════
         TAG MANAGER MODAL
    ═══════════════════════════════════════════ --}}
    @if($showTagManager)
    <div class="fixed inset-0 bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-md">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-800">Manage Tags</h3>
                <button wire:click="$toggle('showTagManager')"
                    class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-6">
                {{-- Create tag --}}
                <div class="flex gap-2 mb-4">
                    <input wire:model="newTagName" type="text" placeholder="Tag name…"
                        class="flex-1 px-3 py-2 text-sm border border-gray-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-300" />
                    <input wire:model="newTagColor" type="color"
                        class="w-10 h-10 rounded-lg border-0 cursor-pointer p-0.5 bg-transparent" />
                    <button wire:click="createTag"
                        class="px-4 py-2 bg-indigo-500 hover:bg-indigo-600 text-white text-sm font-medium rounded-lg transition-colors">
                        Add
                    </button>
                </div>

                {{-- Tag list --}}
                <div class="space-y-2 max-h-64 overflow-y-auto">
                    @forelse($this->allTags as $tag)
                    <div class="flex items-center justify-between py-2 px-3 rounded-lg hover:bg-gray-50">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full" style="background: {{ $tag->color }}"></span>
                            <span class="text-sm text-gray-700">{{ $tag->name }}</span>
                        </div>
                        <button wire:click="deleteTag({{ $tag->id }})"
                            onclick="return confirm('Delete tag {{ $tag->name }}?')"
                            class="text-gray-400 hover:text-red-500 transition-colors p-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    @empty
                    <p class="text-sm text-gray-400 text-center py-6">No tags yet. Create one above!</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    @endif

</div>