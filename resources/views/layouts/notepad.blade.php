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
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2/dist/trix.umd.min.js"></script>

    @livewireStyles

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] {
            display: none !important;
        }

        trix-editor {
            min-height: 300px;
            outline: none;
            font-size: 15px;
            line-height: 1.7;
        }

        trix-editor:focus {
            outline: none;
            box-shadow: none;
        }

        .note-card {
            transition: transform 0.15s, box-shadow 0.15s;
        }

        .note-card:hover {
            transform: translateY(-1px);
        }

        html,
        body {
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
        // DARK MODE — toggle class di <html> dan simpan ke localStorage
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
        // TRIX — simpan konten di JS, kirim ke Livewire saat save
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
        // TRIX — warna teks & highlight
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

        function trixFormat(attr) {
            const el = document.querySelector('trix-editor');
            if (!el || !el.editor) return;
            el.focus();
            el.editor.attributeIsActive(attr) ?
                el.editor.deactivateAttribute(attr) :
                el.editor.activateAttribute(attr);
        }

        function trixBlock(attr) {
            const el = document.querySelector('trix-editor');
            if (!el || !el.editor) return;
            el.focus();
            el.editor.attributeIsActive(attr) ?
                el.editor.deactivateAttribute(attr) :
                el.editor.activateAttribute(attr);
        }

        // ============================================================
        // ALPINE — komponen utama notepad
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