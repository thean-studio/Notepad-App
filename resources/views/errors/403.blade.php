<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>403 - Forbidden</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class', theme: { extend: { fontFamily: { sans: ['"Inter"', 'system-ui', 'sans-serif'] } } } }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>html,body{height:100%;margin:0;}</style>
</head>
<body class="h-full bg-gray-50 dark:bg-gray-900 font-sans antialiased flex items-center justify-center p-4">
    <div class="text-center max-w-md">
        <div class="mb-6">
            <img src="https://i.pinimg.com/736x/6d/9c/82/6d9c82bcb977098312d656044ac1dca6.jpg" alt="403" class="w-64 h-64 mx-auto dark:hidden" onerror="this.style.display='none'">
            <img src="https://i.pinimg.com/736x/6d/9c/82/6d9c82bcb977098312d656044ac1dca6.jpg" alt="403" class="w-64 h-64 mx-auto hidden dark:block" onerror="this.style.display='none'">
        </div>
        <h1 class="text-6xl font-bold text-gray-800 dark:text-gray-200 mb-2">403</h1>
        <h2 class="text-xl font-semibold text-gray-600 dark:text-gray-400 mb-4">Akses Ditolak</h2>
        <p class="text-sm text-gray-500 dark:text-gray-500 mb-8">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ route('notepad') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-xl transition-colors shadow-sm">
            ← Kembali ke Notepad
        </a>
    </div>
</body>
</html>