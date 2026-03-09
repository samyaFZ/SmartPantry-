<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SmartPantry</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.min.css">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            200: '#ddd6fe',
                            300: '#c4b5fd',
                            400: '#a78bfa',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                            800: '#5b21b6',
                            900: '#4c1d95',
                        }
                    },
                    fontFamily: {
                        sans: ['Instrument Sans', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
        }
    </style>
</head>

<body class="h-full bg-white text-slate-900 antialiased overflow-hidden">

    <div class="flex h-screen">
        <!-- Left Side: Background Section -->
        <div class="hidden lg:block lg:w-[55%] relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br from-primary-600/20 to-slate-900/40 mix-blend-multiply z-10">
            </div>
            <img src="https://images.unsplash.com/photo-1610832958506-aa56368176cf?w=1920&h=1080&fit=crop&auto=format&auto=webp&q=80"
                alt="Fresh ingredients" class="absolute inset-0 w-full h-full object-cover">

            <div class="absolute bottom-16 left-16 z-20 max-w-md text-white">
                <div class="w-12 h-1 bg-white mb-8 rounded-full opacity-50"></div>
                <h2 class="text-4xl font-bold mb-4 leading-tight tracking-tight">"Welcome back to your organized life."
                </h2>
                <p class="text-white/70 text-lg font-medium">Your pantry is waiting for your next culinary masterpiece.
                </p>
            </div>
        </div>

        <!-- Right Side: Form Section -->
        <div class="w-full lg:w-[45%] flex flex-col p-6 md:p-10 lg:p-12 overflow-hidden">
            <div class="mb-6 lg:mb-10">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
                    <i
                        class="fas fa-leaf text-lg text-primary-600 transition-transform group-hover:-translate-y-0.5"></i>
                    <span class="text-lg font-bold tracking-tight text-slate-900">SmartPantry</span>
                </a>
            </div>

            <div class="flex-1 max-w-sm mx-auto w-full flex flex-col justify-center">
                <div class="mb-6 lg:mb-8">
                    <h1 class="text-2xl lg:text-3xl font-bold text-slate-900 mb-2 tracking-tight">Welcome back</h1>
                    <p class="text-slate-500 text-sm">Please sign in to access your dashboard.</p>
                </div>

                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-50 text-red-600 rounded-xl border border-red-100 text-xs">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li><i class="fas fa-circle-exclamation mr-1.5"></i>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4 lg:space-y-5">
                    @csrf
                    <div>
                        <label class="block text-xs font-semibold text-slate-700 mb-1.5 uppercase tracking-wide">Email
                            Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            placeholder="jane@example.com"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all" />
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label
                                class="block text-xs font-semibold text-slate-700 uppercase tracking-wide">Password</label>
                            <a href="#"
                                class="text-[11px] font-bold text-primary-600 hover:text-primary-700 transition-colors uppercase tracking-wider">Forgot?</a>
                        </div>
                        <input type="password" name="password" required placeholder="••••••••"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all" />
                    </div>

                    <div class="flex items-center gap-2 py-1">
                        <input type="checkbox" name="remember" id="remember"
                            class="w-4 h-4 rounded border-slate-300 text-primary-600 focus:ring-primary-100">
                        <label for="remember" class="text-xs text-slate-500 font-medium cursor-pointer">Remember me for
                            30 days</label>
                    </div>

                    <button type="submit"
                        class="w-full py-3.5 bg-slate-900 text-white font-bold rounded-xl hover:bg-slate-800 transition-all shadow-lg shadow-slate-200 flex items-center justify-center gap-2 group mt-2">
                        Sign In <i
                            class="fas fa-sign-in-alt text-xs group-hover:translate-x-1 transition-transform"></i>
                    </button>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-slate-500 text-xs">
                        Don't have an account?
                        <a href="{{ route('register') }}"
                            class="text-primary-600 font-bold hover:text-primary-700 transition-colors">Create one
                            here</a>
                    </p>
                </div>
            </div>

            <div class="mt-auto pt-6 text-center">
                <p class="text-[9px] text-slate-400 font-bold uppercase tracking-[0.2em]">&copy; 2026 SmartPantry</p>
            </div>
        </div>
    </div>

</body>

</html>