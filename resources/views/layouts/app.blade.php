<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SmartPantry') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <style>
        .favorite-btn.favorited {
            color: #dc2626; /* Red color for favorited state */
            animation: heartPulse 0.3s ease-in-out;
        }
        .favorite-btn.favorited svg {
            fill: currentColor;
        }
        .favorite-btn:not(.favorited) svg {
            fill: none;
        }

        .save-btn.saved {
            color: #059669; /* Green color for saved state */
            animation: heartPulse 0.3s ease-in-out;
        }
        .save-btn.saved svg {
            fill: currentColor;
        }
        .save-btn:not(.saved) svg {
            fill: none;
        }

        @keyframes heartPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.2); }
            100% { transform: scale(1); }
        }
    </style>
    <script>
        function toggleFavorite(mealId, type, button) {
            // Get CSRF token
            const csrfToken = document.querySelector('meta[name="csrf-token"]');
            const token = csrfToken ? csrfToken.getAttribute('content') : '';

            fetch(`/meals/${mealId}/toggle-favorite`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ type: type })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (type === 'favorite') {
                        button.classList.toggle('favorited');
                    } else if (type === 'saved') {
                        button.classList.toggle('saved');
                    }
                    const action = type === 'favorite' ? 'favorites' : 'saved meals';
                    showToast(data.is_favorited ? `Added to ${action}!` : `Removed from ${action}!`);
                } else {
                    throw new Error('Server returned success=false');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Error updating status. Please try again.');
            });
        }

        function showToast(message) {
            // Remove existing toasts
            const existingToasts = document.querySelectorAll('.toast-notification');
            existingToasts.forEach(toast => toast.remove());

            // Create new toast
            const toast = document.createElement('div');
            toast.className = 'toast-notification fixed top-4 right-4 bg-[#4c1d95] text-white px-4 py-2 rounded-lg shadow-lg z-50 max-w-sm';
            toast.textContent = message;
            document.body.appendChild(toast);

            // Auto remove after 3 seconds
            setTimeout(() => {
                if (toast.parentNode) {
                    toast.remove();
                }
            }, 3000);
        }
    </script>
</head>
<body class="bg-[#fafaf9] text-[#1f2937]">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-[#f9fafb] border-r border-slate-200 flex flex-col shadow-lg">
            <div class="p-6 flex items-center gap-2">
                {{-- Health-focused meal prep logo --}}
                <div class="w-8 h-8 bg-gradient-to-br from-[#4c1d95] to-[#d4af37] rounded-lg flex items-center justify-center shadow-md">
                    <i class="fas fa-utensils text-white text-sm"></i>
                </div>
                <span class="text-xl font-bold text-[#374151]">SmartPantry</span>
            </div>
            <nav class="flex-1 px-4 space-y-2">
                <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-[#f3f4f6] transition-colors group">
                    <i class="fas fa-utensils mr-2 text-[#6b7280] group-hover:text-[#4c1d95] transition-colors"></i> Meal Dashboard
                </a>
                <a href="{{ route('favorites') }}" class="block px-3 py-2 rounded-lg hover:bg-[#f3f4f6] transition-colors group">
                    <i class="fas fa-heart mr-2 text-[#6b7280] group-hover:text-[#4c1d95] transition-colors"></i> Favorite Recipes
                </a>
                <a href="{{ route('pantry') }}" class="block px-3 py-2 rounded-lg hover:bg-[#f3f4f6] transition-colors group">
                    <i class="fas fa-seedling mr-2 text-[#6b7280] group-hover:text-[#4c1d95] transition-colors"></i> Ingredient Inventory
                </a>
                <a href="{{ route('meals.add') }}" class="block px-3 py-2 rounded-lg hover:bg-[#f3f4f6] transition-colors group">
                    <i class="fas fa-plus-circle mr-2 text-[#6b7280] group-hover:text-[#4c1d95] transition-colors"></i> Create Recipe
                </a>

                <div class="my-2 border-t border-slate-300"></div>

                @auth
                    <a href="{{ route('profile') }}" class="block px-3 py-2 rounded-lg hover:bg-[#fef3c7] bg-[#f9fafb] border border-[#d4af37]/30 hover:border-[#d4af37] transition-all duration-200 group">
                        <i class="fas fa-user-circle mr-2 text-[#d4af37] group-hover:text-[#b7950b] transition-colors"></i> <span class="text-[#d4af37] font-semibold group-hover:text-[#b7950b]">Nutrition Profile</span>
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg hover:bg-[#ede9fe] bg-[#f9fafb] border border-[#4c1d95]/30 hover:border-[#4c1d95] transition-all duration-200 group">
                        <i class="fas fa-user-circle mr-2 text-[#4c1d95] group-hover:text-[#3b0d7a] transition-colors"></i> <span class="text-[#4c1d95] font-semibold group-hover:text-[#3b0d7a]">Nutrition Profile</span>
                    </a>
                @endauth
            </nav>
            <div class="px-4 py-6 border-t border-slate-200">
                @auth
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <button type="submit" class="text-sm hover:text-[#4c1d95] font-semibold transition-colors flex items-center">
                            <i class="fas fa-sign-out-alt mr-1"></i> End Session
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-sm hover:text-[#4c1d95] font-semibold transition-colors flex items-center mb-2">
                        <i class="fas fa-sign-in-alt mr-1"></i> Start Meal Planning
                    </a>
                    <a href="{{ route('register') }}" class="block text-sm hover:text-[#4c1d95] font-semibold transition-colors flex items-center">
                        <i class="fas fa-user-plus mr-1"></i> Join Healthy Community
                    </a>
                @endauth
            </div>
        </aside>
        <!-- main content -->
        <main class="flex-1 p-6 overflow-auto">
            @yield('content')
        </main>
    </div>
</body>
</html>