<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Notepad — Write Freely, Save Forever</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lora:ital,wght@0,400;0,600;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet"/>
    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(-2deg); }
            50% { transform: translateY(-12px) rotate(-2deg); }
        }
        .float-note { animation: float 6s ease-in-out infinite; }
        body { font-family: 'DM Sans', sans-serif; }
        h1, h2, h3 { font-family: 'Lora', serif; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-slate-900 via-indigo-900 to-purple-900 text-white selection:bg-pink-500/30">

    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="absolute w-[500px] h-[500px] bg-pink-500 rounded-full blur-[120px] opacity-10 -top-20 -left-20 animate-pulse"></div>
        <div class="absolute w-[500px] h-[500px] bg-indigo-500 rounded-full blur-[120px] opacity-10 bottom-0 right-0 animate-pulse"></div>
    </div>

    <nav class="relative z-50">
        <div class="max-w-6xl mx-auto px-6 h-20 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-indigo-500 rounded flex items-center justify-center">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><rect x="2" y="1" width="11" height="14" rx="1" fill="white" opacity="0.9"/><line x1="4" y1="5" x2="11" y2="5" stroke="#6366f1" stroke-width="1.2"/><line x1="4" y1="8" x2="11" y2="8" stroke="#6366f1" stroke-width="1.2"/><line x1="4" y1="11" x2="8" y2="11" stroke="#6366f1" stroke-width="1.2"/></svg>
                </div>
                <span class="text-xl font-semibold font-serif">Notepad</span>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('login') }}" class="text-sm font-medium hover:text-pink-400 transition">Log In</a>
                <a href="{{ route('register') }}" class="px-5 py-2 bg-white text-slate-900 text-sm font-bold rounded-xl hover:bg-pink-100 transition">Get Started</a>
            </div>
        </div>
    </nav>

    <section class="relative z-10 max-w-6xl mx-auto px-6 pt-16 pb-24">
        <div class="flex flex-col lg:flex-row items-center gap-16">
            <div class="flex-1 text-center lg:text-left">
                <span class="inline-block px-4 py-1 rounded-full bg-white/10 border border-white/20 text-sm mb-6">✦ Free for everyone</span>
                <h1 class="text-6xl lg:text-7xl leading-tight mb-8">
                    Write Freely,<br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-indigo-400 italic">Save Forever.</span>
                </h1>
                <p class="text-gray-300 text-lg leading-relaxed mb-10 max-w-lg mx-auto lg:mx-0">
                    Notepad is a peaceful writing space — free from distractions, quick to access, and always ready when ideas strike.  Whether you're jotting down a quick thought or crafting your next masterpiece, Notepad is here to help you capture your ideas and keep them safe forever.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start">
                    <a href="{{ route('register') }}" class="px-8 py-4 bg-gradient-to-r from-pink-500 to-indigo-500 rounded-xl font-bold text-lg hover:scale-105 transition shadow-lg shadow-purple-500/20">
                        Get Started Now →
                    </a>
                </div>
            </div>

            <div class="flex-1 hidden lg:block float-note">
                <div class="bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-3xl shadow-2xl">
                    <p class="text-xs text-indigo-300 mb-4 font-mono">📌 Today's Thought</p>
                    <p class="text-lg text-white mb-6">"Notepad is the best tool for thinking clearly."</p>
                    <div class="w-full h-px bg-white/10 mb-4"></div>
                    <div class="flex justify-end gap-2 text-indigo-300 text-sm italic">― Notepad User</div>
                </div>
            </div>
        </div>
    </section>

    <div class="relative z-10 bg-white/5 backdrop-blur-md py-10 border-y border-white/5">
        <div class="max-w-4xl mx-auto px-6 grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            @foreach(['50K+' => 'Users', '2M+' => 'Notes', '99.9%' => 'Uptime', '4.9★' => 'Rating'] as $stat => $label)
            <div>
                <div class="text-3xl font-bold font-serif">{{ $stat }}</div>
                <div class="text-gray-400 text-sm mt-1">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>

</body>
</html>