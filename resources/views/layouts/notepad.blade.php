<!DOCTYPE html>
<html lang="en" class="h-full">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notepad</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Inter"', 'system-ui', 'sans-serif']
                    }
                }
            }
        }
    </script>

    <script>
        (function() {
            const saved = localStorage.getItem('theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
            }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2/dist/trix.umd.min.js"></script>

    @livewireStyles

    <style>
    /* Sembunyikan tombol file attachment */
    trix-toolbar [data-trix-button-group="file-tools"] {
        display: none !important;
    }

    /* Styling toolbar Trix agar lebih lega */
    trix-toolbar {
        background-color: #f9fafb !important;
        border-bottom: 1px solid #e5e7eb !important;
        padding: 10px 12px !important;
        display: flex !important;
        flex-wrap: wrap !important;
        gap: 8px !important;
        align-items: center !important;
        justify-content: flex-start !important;
    }

    .dark trix-toolbar {
        background-color: #111827 !important;
        border-bottom: 1px solid #374151 !important;
    }

    trix-toolbar .trix-button-group {
        border: 1px solid #d1d5db !important;
        border-radius: 8px !important;
        margin: 0 !important;
        display: flex !important;
        overflow: hidden !important;
    }

    .dark trix-toolbar .trix-button-group {
        border-color: #4b5563 !important;
    }

    trix-toolbar .trix-button {
        border: none !important;
        background: transparent !important;
        color: #374151 !important;
        padding: 8px 14px !important;
        font-size: 14px !important;
        border-radius: 0 !important;
        min-width: 40px !important;
        display: flex !important;
        align-items: center !important;
        justify-content: center !important;
        transition: background-color 0.2s;
    }

    .dark trix-toolbar .trix-button {
        color: #d1d5db !important;
    }

    trix-toolbar .trix-button:hover {
        background-color: #e5e7eb !important;
    }

    .dark trix-toolbar .trix-button:hover {
        background-color: #374151 !important;
    }

    trix-toolbar .trix-button.trix-active {
        background-color: #6366f1 !important;
        color: white !important;
    }

    /* Ikon agar tetap terlihat jelas */
    trix-toolbar .trix-button::before {
        filter: none !important;
        opacity: 0.8;
    }

    .dark trix-toolbar .trix-button::before {
        filter: invert(0.8) !important;
    }

    .dark trix-toolbar .trix-button.trix-active::before {
        filter: invert(1) !important;
    }

    /* Trix editor content - lebih nyaman untuk menulis */
    trix-editor {
        min-height: 400px;
        outline: none;
        padding: 20px !important;
        font-size: 16px !important;
        line-height: 1.8 !important;
        border: none !important;
    }

    trix-editor:focus {
        outline: none !important;
        box-shadow: none !important;
    }

    trix-editor h1 {
        font-size: 1.8em !important;
        font-weight: 700 !important;
        margin: 0.5em 0 !important;
    }

    .dark trix-editor h1 {
        color: #f9fafb !important;
    }

    trix-editor blockquote {
        border-left: 4px solid #6366f1 !important;
        padding-left: 16px !important;
        margin: 12px 0 !important;
        color: #6b7280 !important;
        font-style: italic !important;
    }

    .dark trix-editor blockquote {
        border-left-color: #818cf8 !important;
        color: #9ca3af !important;
    }

    trix-editor pre {
        background-color: #1f2937 !important;
        color: #e5e7eb !important;
        padding: 16px !important;
        border-radius: 8px !important;
        font-family: 'Courier New', monospace !important;
        font-size: 14px !important;
        overflow-x: auto !important;
        margin: 12px 0 !important;
    }

    .dark trix-editor pre {
        background-color: #111827 !important;
        border: 1px solid #374151 !important;
    }

    /* Note card */
    .note-card {
        transition: transform 0.15s, box-shadow 0.15s;
    }

    .note-card:hover {
        transform: translateY(-1px);
    }

    html, body {
        height: 100%;
        margin: 0;
    }
</style>
</head>

<body class="h-full bg-gray-50 dark:bg-gray-900 font-sans antialiased">

    {{ $slot }}

    @livewireScripts

    <script>
        // ============================================================
        // DARK MODE
        // ============================================================
        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            if (isDark) {
                html.classList.remove('dark');
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                localStorage.setItem('theme', 'dark');
            }
        }

        // ============================================================
        // KONFIGURASI TRIX TOOLBAR - Menampilkan semua fitur
        // ============================================================
        Trix.config.blockAttributes.heading1 = {
            tagName: 'h1',
            terminal: true,
            breakOnReturn: true,
            group: false
        };

        Trix.config.blockAttributes.quote = {
            tagName: 'blockquote',
            nestable: true
        };

        Trix.config.blockAttributes.code = {
            tagName: 'pre',
            nestable: false
        };

        // Trix toolbar lengkap
        Trix.config.toolbar = {
            getDefaultHTML: function() {
                return `
                    <div class="trix-button-row">
                        <span class="trix-button-group trix-button-group--text-tools" data-trix-button-group="text-tools">
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-bold" data-trix-attribute="bold" data-trix-key="b" title="Bold">Bold</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-italic" data-trix-attribute="italic" data-trix-key="i" title="Italic">Italic</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-strike" data-trix-attribute="strike" title="Strikethrough">Strike</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-link" data-trix-attribute="href" data-trix-action="link" data-trix-key="k" title="Link">Link</button>
                        </span>
                        <span class="trix-button-group trix-button-group--block-tools" data-trix-button-group="block-tools">
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-heading-1" data-trix-attribute="heading1" title="Heading">Heading</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-quote" data-trix-attribute="quote" title="Quote">Quote</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-code" data-trix-attribute="code" title="Code">Code</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-bullet-list" data-trix-attribute="bullet" title="Bullets">Bullets</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-number-list" data-trix-attribute="number" title="Numbers">Numbers</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-decrease-nesting-level" data-trix-action="decreaseNestingLevel" title="Decrease Level">Outdent</button>
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-increase-nesting-level" data-trix-action="increaseNestingLevel" title="Increase Level">Indent</button>
                        </span>
                        <span class="trix-button-group trix-button-group--file-tools" data-trix-button-group="file-tools">
                            <button type="button" class="trix-button trix-button--icon trix-button--icon-attach" data-trix-action="attachFiles" title="Attach Files">Attach</button>
                        </span>
                        <span class="trix-button-group-spacer"></span>
                    </div>
                    <div class="trix-dialogs" data-trix-dialogs>
                        <div class="trix-dialog trix-dialog--link" data-trix-dialog="href" data-trix-dialog-attribute="href">
                            <div class="trix-dialog__link-fields">
                                <input type="url" name="href" class="trix-input trix-input--dialog" placeholder="Enter URL…" aria-label="URL" required data-trix-input>
                                <div class="trix-button-group">
                                    <input type="button" class="trix-button trix-button--dialog" value="Link" data-trix-method="setAttribute">
                                    <input type="button" class="trix-button trix-button--dialog" value="Unlink" data-trix-method="removeAttribute">
                                </div>
                            </div>
                        </div>
                    </div>
                `;
            }
        };

        // ============================================================
        // TRIX - simpan konten
        // ============================================================
        window._trixContent = '';
        window._trixFromServer = false;
        window._trixSaveTimer = null;

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('trix-set-content', ({
                content
            }) => {
                const tryLoad = () => {
                    const el = document.querySelector('trix-editor');
                    if (!el || !el.editor) return setTimeout(tryLoad, 150);
                    window._trixFromServer = true;
                    window._trixContent = content || '';
                    el.editor.loadHTML(content || '');
                    setTimeout(() => {
                        window._trixFromServer = false;
                    }, 300);
                };
                tryLoad();
            });
        });

        // ============================================================
        // TRIX - warna teks & highlight
        // ============================================================
        Trix.config.textAttributes.textColor = {
            styleProperty: 'color',
            inheritable: true,
        };
        Trix.config.textAttributes.backgroundColor = {
            styleProperty: 'backgroundColor',
            inheritable: true,
        };

        function applyTextColor(color) {
            const el = document.querySelector('trix-editor');
            if (!el || !el.editor) return;
            el.focus();
            el.editor.activateAttribute('textColor', color);
        }

        function removeTextColor() {
            const el = document.querySelector('trix-editor');
            if (!el || !el.editor) return;
            el.focus();
            el.editor.deactivateAttribute('textColor');
        }

        function applyHighlight(color) {
            const el = document.querySelector('trix-editor');
            if (!el || !el.editor) return;
            el.focus();
            el.editor.activateAttribute('backgroundColor', color);
        }

        function removeHighlight() {
            const el = document.querySelector('trix-editor');
            if (!el || !el.editor) return;
            el.focus();
            el.editor.deactivateAttribute('backgroundColor');
        }

        // ============================================================
        // ALPINE - komponen notepad
        // ============================================================
        function notepadApp() {
            return {
                isDrawing: false,
                brushSize: 4,
                brushColor: '#1f2937',
                eraserMode: false,
                lastX: 0,
                lastY: 0,
                canvas: null,
                ctx: null,
                saving: false,
                saved: false,

                init() {
                    Livewire.on('note-saved', () => {
                        this.saving = false;
                        this.saved = true;
                        setTimeout(() => {
                            this.saved = false;
                        }, 2000);
                    });
                },

                initTrix() {
                    const el = document.querySelector('trix-editor');
                    if (!el) return;
                    el.addEventListener('trix-change', () => {
                        if (window._trixFromServer) return;
                        window._trixContent = el.innerHTML;
                        clearTimeout(window._trixSaveTimer);
                        window._trixSaveTimer = setTimeout(() => {
                            this.saving = true;
                            this.$wire.saveNoteWithContent(window._trixContent);
                        }, 1500);
                    });
                },

                triggerManualSave() {
                    this.saving = true;
                    this.$wire.saveNoteWithContent(window._trixContent);
                },

                initCanvas(existingData) {
                    this.$nextTick(() => {
                        this.canvas = document.getElementById('drawingCanvas');
                        if (!this.canvas) return;
                        this.canvas.width = this.canvas.offsetWidth || 800;
                        this.canvas.height = 400;
                        this.ctx = this.canvas.getContext('2d');
                        this.ctx.fillStyle = '#ffffff';
                        this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
                        if (existingData) {
                            const img = new Image();
                            img.onload = () => this.ctx.drawImage(img, 0, 0, this.canvas.width, this.canvas.height);
                            img.src = existingData;
                        }
                    });
                },

                getPos(e) {
                    if (!this.canvas) return {
                        x: 0,
                        y: 0
                    };
                    const rect = this.canvas.getBoundingClientRect();
                    return {
                        x: (e.clientX - rect.left) * (this.canvas.width / rect.width),
                        y: (e.clientY - rect.top) * (this.canvas.height / rect.height),
                    };
                },

                startDraw(e) {
                    if (!this.ctx) return;
                    this.isDrawing = true;
                    const {
                        x,
                        y
                    } = this.getPos(e);
                    this.lastX = x;
                    this.lastY = y;
                    this.ctx.beginPath();
                    this.ctx.arc(x, y, this.eraserMode ? 20 : this.brushSize / 2, 0, Math.PI * 2);
                    this.ctx.fillStyle = this.eraserMode ? '#ffffff' : this.brushColor;
                    this.ctx.fill();
                },

                draw(e) {
                    if (!this.isDrawing || !this.ctx) return;
                    const {
                        x,
                        y
                    } = this.getPos(e);
                    this.ctx.beginPath();
                    this.ctx.moveTo(this.lastX, this.lastY);
                    this.ctx.lineTo(x, y);
                    this.ctx.strokeStyle = this.eraserMode ? '#ffffff' : this.brushColor;
                    this.ctx.lineWidth = this.eraserMode ? 40 : this.brushSize;
                    this.ctx.lineCap = this.ctx.lineJoin = 'round';
                    this.ctx.stroke();
                    this.lastX = x;
                    this.lastY = y;
                },

                stopDraw() {
                    if (this.isDrawing && this.ctx) this.ctx.closePath();
                    this.isDrawing = false;
                },

                clearCanvas() {
                    if (!this.ctx) return;
                    this.ctx.fillStyle = '#ffffff';
                    this.ctx.fillRect(0, 0, this.canvas.width, this.canvas.height);
                },

                saveCanvasDrawing() {
                    if (!this.canvas) return;
                    this.$wire.saveDrawing(this.canvas.toDataURL('image/png'));
                },
            };
        }
    </script>
</body>

</html>
