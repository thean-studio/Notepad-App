<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Notepad</title>

    {{-- Tailwind CSS via CDN (swap for Vite in production) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['"Inter"', 'system-ui', 'sans-serif'],
                        mono: ['"JetBrains Mono"', 'monospace'],
                    }
                }
            }
        }
    </script>

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=JetBrains+Mono&display=swap" rel="stylesheet">

    {{-- Trix rich text editor --}}
    <link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2/dist/trix.css">
    <script type="text/javascript" src="https://unpkg.com/trix@2/dist/trix.umd.min.js"></script>

    @livewireStyles

    <style>
        trix-toolbar [data-trix-button-group="file-tools"] { display: none; }
        trix-editor { min-height: 300px; outline: none; font-size: 15px; line-height: 1.7; }
        trix-editor:focus { outline: none; box-shadow: none; }
        .note-card:hover { transform: translateY(-1px); }
        .note-card { transition: transform 0.15s, box-shadow 0.15s; }
        html, body { height: 100%; margin: 0; }
    </style>
</head>
<body class="h-full bg-gray-50 font-sans antialiased">
    {{ $slot }}

    @livewireScripts
</body>
</html>