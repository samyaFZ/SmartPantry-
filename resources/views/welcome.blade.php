<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmartPantry - Simple Kitchen Management</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

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
                        },
                        slate: {
                            25: '#fbfcfd',
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
            background-color: #ffffff;
            color: #0f172a;
        }

        .hero-shape {
            background: radial-gradient(circle at 50% 50%, rgba(124, 58, 237, 0.03) 0%, transparent 70%);
        }
    </style>
</head>

<body class="antialiased selection:bg-primary-100 selection:text-primary-900 text-slate-900">

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
        <div class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <i class="fas fa-leaf text-primary-600 text-lg"></i>
                <span class="text-lg font-bold tracking-tight text-slate-900">SmartPantry</span>
            </div>

            <div class="hidden md:flex items-center gap-8">
                <a href="#features"
                    class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">Features</a>
                <a href="#about"
                    class="text-sm font-medium text-slate-500 hover:text-slate-900 transition-colors">About</a>
            </div>

            <div class="flex items-center gap-3">
                @auth
                    <a href="{{ route('home') }}"
                        class="text-sm font-semibold text-slate-900 hover:text-primary-600 transition-colors">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-medium text-slate-600 hover:text-slate-900 px-3">Log
                        in</a>
                    <a href="{{ route('register') }}"
                        class="px-4 py-2 bg-slate-900 text-white rounded-lg text-sm font-medium hover:bg-slate-800 transition-all">Get
                        Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-24 pb-20 overflow-hidden hero-shape">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <div
                class="inline-flex items-center gap-2 px-3 py-1 bg-primary-50 text-primary-600 text-[11px] font-bold uppercase tracking-wider rounded-full border border-primary-100 mb-8">
                <span class="relative flex h-2 w-2">
                    <span
                        class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-primary-500"></span>
                </span>
                Smarter Kitchen Management
            </div>

            <h1
                class="text-5xl md:text-6xl lg:text-7xl font-bold text-slate-900 mb-8 tracking-tight max-w-4xl mx-auto leading-[1.1]">
                Less waste. <br class="hidden md:block"> Better <span class="text-primary-600">meals</span>. Clearer
                mind.
            </h1>

            <p class="text-lg md:text-xl text-slate-500 max-w-2xl mx-auto mb-10 leading-relaxed font-normal">
                SmartPantry helps you organize your ingredients, discover healthy recipes, and minimize food waste with
                intelligent inventory tracking.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-20">
                <a href="{{ route('register') }}"
                    class="w-full sm:w-auto px-8 py-3.5 bg-primary-600 text-white rounded-xl font-semibold text-base hover:bg-primary-700 hover:shadow-lg hover:shadow-primary-500/20 transition-all">
                    Start your journey
                </a>
                <a href="#features"
                    class="w-full sm:w-auto px-8 py-3.5 bg-white text-slate-700 border border-slate-200 rounded-xl font-semibold text-base hover:bg-slate-50 transition-all">
                    See how it works
                </a>
            </div>

            <div class="relative max-w-5xl mx-auto group">
                <div
                    class="absolute -inset-1 bg-slate-100 rounded-3xl blur-2xl group-hover:bg-primary-100/50 transition-colors duration-500">
                </div>
                <div class="relative bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1556910103-1c02745aae4d?q=80&w=2000&auto=format&fit=crop"
                        alt="Clean organized kitchen"
                        class="w-full aspect-video md:aspect-[21/9] object-cover opacity-90 group-hover:opacity-100 transition-opacity">
                    <div class="absolute inset-0 bg-gradient-to-t from-white/20 to-transparent"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-24 border-t border-slate-50">
        <div class="max-w-6xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="space-y-4">
                    <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-900">
                        <i class="fas fa-barcode text-sm"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Inventory Sync</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Effortlessly track your pantry items. Scan and
                        organize in seconds with our intuitive interface.</p>
                </div>

                <div class="space-y-4">
                    <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-900">
                        <i class="fas fa-clock text-sm"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Expiry Alerts</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Never throw away food again. Get gentle reminders
                        before your ingredients lose their freshness.</p>
                </div>

                <div class="space-y-4">
                    <div class="w-10 h-10 bg-slate-50 rounded-lg flex items-center justify-center text-slate-900">
                        <i class="fas fa-magic text-sm"></i>
                    </div>
                    <h3 class="text-xl font-bold text-slate-900">Smart Recipes</h3>
                    <p class="text-slate-500 leading-relaxed text-sm">Discover what you can cook with what you already
                        have. Intelligent suggestions tailored to you.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Content Section -->
    <section class="pb-24">
        <div class="max-w-6xl mx-auto px-6">
            <div class="bg-slate-900 rounded-[2rem] p-12 md:p-20 text-center text-white overflow-hidden relative">
                <div class="absolute top-0 right-0 w-64 h-64 bg-primary-500/10 blur-3xl -mr-32 -mt-32"></div>
                <div class="relative z-10 max-w-2xl mx-auto">
                    <h2 class="text-3xl md:text-4xl font-bold mb-6">Built for simplicity.</h2>
                    <p class="text-slate-400 text-lg mb-10 leading-relaxed">
                        We believe that technology should fade into the background. SmartPantry is designed to be a
                        quiet companion in your daily life.
                    </p>
                    <a href="{{ route('register') }}"
                        class="inline-flex items-center gap-2 px-6 py-3 bg-white text-slate-900 rounded-xl font-semibold hover:bg-slate-100 transition-colors">
                        Create your free account <i class="fas fa-chevron-right text-xs"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-16 bg-slate-950 text-white">
        <div class="max-w-6xl mx-auto px-6 flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="flex items-center gap-2">
                <i class="fas fa-leaf text-primary-500"></i>
                <span class="text-sm font-bold tracking-tight">SmartPantry</span>
            </div>

            <div class="flex items-center gap-8">
                <a href="#" class="text-xs font-medium text-slate-400 hover:text-white transition-colors">Privacy</a>
                <a href="#" class="text-xs font-medium text-slate-400 hover:text-white transition-colors">Terms</a>
                <a href="#" class="text-xs font-medium text-slate-400 hover:text-white transition-colors">Twitter</a>
            </div>

            <p class="text-xs text-slate-500 font-medium">
                &copy; 2026 SmartPantry. All rights reserved.
            </p>
        </div>
    </footer>

</body>

</html>