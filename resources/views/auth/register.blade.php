<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeIn 1s ease-out;
        }
    </style>
</head>

<body
    class="bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-800 min-h-screen flex items-center justify-center overflow-hidden">

    <!-- Background Blur Circle -->
    <div class="absolute w-72 h-72 bg-pink-500 rounded-full blur-3xl opacity-30 top-10 left-10 animate-pulse"></div>
    <div class="absolute w-96 h-96 bg-indigo-500 rounded-full blur-3xl opacity-30 bottom-10 right-10 animate-pulse">
    </div>

    <!-- Card -->
    <div
        class="relative bg-white/10 backdrop-blur-lg border border-white/20 shadow-2xl rounded-3xl p-10 w-[90%] max-w-md fade-in">

        <!-- Title -->
        <div class="text-center mb-8 animate-float">
            <h2 class="text-4xl font-extrabold text-white">
                Create Account
            </h2>
            <p class="text-gray-300 mt-2">
                Join and start your journey 🚀
            </p>
        </div>

        <!-- Form -->
        <form method="POST" action="{{ url('/register') }}" class="space-y-5">
            @csrf

            <!-- Error Messages -->
            @if ($errors->any())
            <div class="bg-red-500/20 border border-red-400 text-red-200 px-4 py-3 rounded-xl text-sm space-y-1">
                @foreach ($errors->all() as $error)
                <div>• {{ $error }}</div>
                @endforeach
            </div>
            @endif

            <!-- Name -->
            <div>
                <input type="text" name="name" placeholder="Nama Lengkap" value="{{ old('name') }}" required
                    class="w-full px-5 py-3 rounded-xl bg-white/20 text-white placeholder-gray-300 outline-none border border-transparent focus:border-pink-400 focus:ring-2 focus:ring-pink-400 transition duration-300 @error('name') border-red-400 @enderror">
                @error('name')
                <p class="text-red-200 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <input type="email" name="email" placeholder="Email" value="{{ old('email') }}" required
                    class="w-full px-5 py-3 rounded-xl bg-white/20 text-white placeholder-gray-300 outline-none border border-transparent focus:border-indigo-400 focus:ring-2 focus:ring-indigo-400 transition duration-300 @error('email') border-red-400 @enderror">
                @error('email')
                <p class="text-red-200 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <input type="password" name="password" placeholder="Password" required
                    class="w-full px-5 py-3 rounded-xl bg-white/20 text-white placeholder-gray-300 outline-none border border-transparent focus:border-purple-400 focus:ring-2 focus:ring-purple-400 transition duration-300 @error('password') border-red-400 @enderror">
                @error('password')
                <p class="text-red-200 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                    class="w-full px-5 py-3 rounded-xl bg-white/20 text-white placeholder-gray-300 outline-none border border-transparent focus:border-purple-400 focus:ring-2 focus:ring-purple-400 transition duration-300 @error('password') border-red-400 @enderror">
            </div>

            <!-- Button -->
            <button type="submit"
                class="w-full py-3 rounded-xl bg-gradient-to-r from-pink-500 to-indigo-500 text-white font-bold text-lg shadow-lg hover:scale-105 hover:shadow-pink-500/50 transition duration-300">
                Register
            </button>
        </form>

        <!-- Login -->
        <p class="text-center text-gray-300 mt-6">
            Sudah punya akun?
            <a href="/login" class="text-pink-400 hover:text-pink-300 font-semibold transition">
                Login
            </a>
        </p>
    </div>

</body>

</html>