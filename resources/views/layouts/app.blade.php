<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SmartPantry') }} - Simple Meal Prep</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            -webkit-font-smoothing: antialiased;
        }

        .sidebar-link.active {
            background-color: #f5f3ff;
            color: #7c3aed;
            font-weight: 600;
        }

        .sidebar-link.active i {
            color: #7c3aed;
            opacity: 1;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #e2e8f0;
            border-radius: 10px;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#f5f3ff',
                            100: '#ede9fe',
                            500: '#8b5cf6',
                            600: '#7c3aed',
                            700: '#6d28d9',
                        },
                        slate: {
                            25: '#fbfcfd',
                        }
                    }
                }
            }
        }

        function toggleFavorite(mealId, type, button) {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            fetch(`/meals/${mealId}/toggle-favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type: type })
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        button.classList.toggle('text-red-500', type === 'favorite' && data.is_favorited);
                        button.classList.toggle('text-green-500', type === 'save' && data.is_saved);
                        showToast(data.is_favorited || data.is_saved ? `Added to favorites!` : `Removed from favorites!`);
                    }
                });
        }

        function showToast(message) {
            const container = document.getElementById('toast-container');
            const toast = document.createElement('div');
            toast.className = 'px-4 py-3 bg-slate-900 text-white text-[11px] font-bold uppercase tracking-wider rounded-xl shadow-xl transition-all duration-300 transform translate-y-0 opacity-100 flex items-center gap-2';
            toast.innerHTML = `<i class="fas fa-check-circle text-primary-400"></i> ${message}`;
            container.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('opacity-0', 'translate-y-2');
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }
    </script>
</head>

<body class="h-full bg-white text-slate-900 antialiased overflow-hidden">
    <div id="toast-container" class="fixed bottom-8 left-1/2 -translate-x-1/2 z-[100] flex flex-col items-center gap-2">
    </div>

    <div class="flex h-full overflow-hidden">
        <!-- Sidebar -->
        <aside class="w-64 border-r border-slate-100 flex flex-col hidden lg:flex bg-slate-25">
            <div class="p-8">
                <a href="{{ route('welcome') }}" class="flex items-center gap-2 group">
                    <i
                        class="fas fa-leaf text-primary-600 text-xl transition-transform group-hover:-translate-y-0.5"></i>
                    <span class="text-xl font-bold tracking-tight text-slate-900">SmartPantry</span>
                </a>
            </div>

            <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto custom-scrollbar">
                <div class="pb-2 px-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Menu</p>
                </div>
                <a href="{{ route('home') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100 {{ request()->routeIs('home') ? 'active' : '' }}">
                    <i class="fas fa-home w-4 opacity-70"></i> Dashboard
                </a>
                <a href="{{ route('favorites') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100 {{ request()->routeIs('favorites') ? 'active' : '' }}">
                    <i class="fas fa-heart w-4 opacity-70"></i> Favorites
                </a>
                <a href="{{ route('pantry') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100 {{ request()->routeIs('pantry') ? 'active' : '' }}">
                    <i class="fas fa-box w-4 opacity-70"></i> Inventory
                </a>
                <a href="{{ route('meals.add') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100 {{ request()->routeIs('meals.add') ? 'active' : '' }}">
                    <i class="fas fa-plus w-4 opacity-70"></i> Create Recipe
                </a>

                <div class="pt-8 pb-2 px-3">
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Settings</p>
                </div>
                <a href="{{ route('profile') }}"
                    class="sidebar-link flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-all text-slate-600 hover:text-slate-900 hover:bg-slate-100 {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <i class="fas fa-user-circle w-4 opacity-70"></i> Profile
                </a>
            </nav>

            <div class="p-6 border-t border-slate-100 bg-white/50 backdrop-blur-sm">
                @auth
                    <div class="flex items-center justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div
                                class="w-8 h-8 rounded-full bg-primary-100 text-primary-600 flex items-center justify-center font-bold text-xs shrink-0">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="min-w-0">
                                <p class="text-xs font-bold text-slate-900 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-[10px] text-slate-500 truncate">Home Chef</p>
                            </div>
                        </div>
                        <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                            @csrf
                            <button type="submit"
                                class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all"
                                title="Exit">
                                <i class="fas fa-power-off text-xs"></i>
                            </button>
                        </form>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                        class="block w-full py-2.5 bg-slate-900 text-white text-center rounded-xl text-sm font-bold shadow-lg shadow-slate-100">Sign
                        In</a>
                @endauth
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 flex flex-col h-full bg-white overflow-hidden relative">
            <!-- Header -->
            <header
                class="h-16 border-b border-slate-100 flex items-center justify-between px-8 bg-white/80 backdrop-blur-md z-30 sticky top-0">
                <h2 class="text-sm font-bold text-slate-900 tracking-tight">
                    @yield('title', 'Overview')
                </h2>
                <div class="flex items-center gap-6">
                    <div class="relative hidden md:block">
                        <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Global search..."
                            class="pl-9 pr-4 py-2 bg-slate-50 border border-slate-100 rounded-xl text-xs focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 w-56 transition-all">
                    </div>
                    <button class="relative text-slate-400 hover:text-slate-900 transition-colors">
                        <i class="far fa-bell"></i>
                        <span
                            class="absolute -top-1 -right-1 w-2 h-2 bg-primary-500 border-2 border-white rounded-full"></span>
                    </button>
                </div>
            </header>

            <div class="flex-1 overflow-y-auto custom-scrollbar">
                <div class="max-w-[1400px] mx-auto p-6 lg:p-10">
                    @yield('content')
                </div>
            </div>
        </main>
    </div>
</body>

</html>