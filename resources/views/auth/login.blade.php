<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(25px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease;
        }
    </style>
</head>

<body
    class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-indigo-900 to-purple-900 overflow-hidden">

    <!-- Background Glow -->
    <div class="absolute w-80 h-80 bg-pink-500 rounded-full blur-3xl opacity-20 top-0 left-0 animate-pulse"></div>
    <div class="absolute w-96 h-96 bg-indigo-500 rounded-full blur-3xl opacity-20 bottom-0 right-0 animate-pulse"></div>

    <!-- Login Card -->
    <div
        class="relative w-[90%] max-w-md p-10 rounded-3xl bg-white/10 backdrop-blur-xl border border-white/20 shadow-2xl fade-in">

        <!-- Header -->
        <div class="text-center mb-8 animate-float">
            <h2 class="text-4xl font-extrabold text-white">
                Welcome Back 👋
            </h2>

            <p class="text-gray-300 mt-2">
                Login to continue your journey
            </p>
        </div>

        <!-- Success Message -->
        @if (session('success'))
        <div class="bg-green-500/20 border border-green-400 text-green-200 px-4 py-3 rounded-xl mb-5 text-sm">
            ✓ {{ session('success') }}
        </div>
        @endif

        <!-- Error -->
        @if (session('error'))
        <div class="bg-red-500/20 border border-red-400 text-red-200 px-4 py-3 rounded-xl mb-5 text-sm">
            {{ session('error') }}
        </div>
        @endif

        @if ($errors->any())
        <div class="bg-red-500/20 border border-red-400 text-red-200 px-4 py-3 rounded-xl mb-5 text-sm space-y-1">
            @foreach ($errors->all() as $error)
            <div>• {{ $error }}</div>
            @endforeach
        </div>
        @endif

        <!-- Form -->
        <form method="POST" action="{{ url('/login') }}" class="space-y-5">
            @csrf

            <!-- Email -->
            <div>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
                    class="w-full px-5 py-3 rounded-xl bg-white/20 text-white placeholder-gray-300 border border-transparent outline-none focus:ring-2 focus:ring-pink-400 focus:border-pink-400 transition duration-300 @error('email') border-red-400 @enderror">
                @error('email')
                <p class="text-red-200 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <input type="password" name="password" placeholder="Password" required
                    class="w-full px-5 py-3 rounded-xl bg-white/20 text-white placeholder-gray-300 border border-transparent outline-none focus:ring-2 focus:ring-indigo-400 focus:border-indigo-400 transition duration-300 @error('password') border-red-400 @enderror">
                @error('password')
                <p class="text-red-200 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-pink-500 via-purple-500 to-indigo-500 text-white font-bold text-lg shadow-lg hover:scale-105 hover:shadow-purple-500/50 transition duration-300">
                Login
            </button>
        </form>

        <!-- Register -->
        <p class="text-center text-gray-300 mt-6">
            Belum punya akun?
            <a href="/register" class="text-pink-400 font-semibold hover:text-pink-300 transition">
                Register
            </a>
        </p>

    </div>

</body>

</html>