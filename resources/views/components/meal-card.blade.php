<div class="bg-white rounded-lg shadow hover:shadow-lg overflow-hidden flex flex-col">
    {{-- card size uses helper's default dimensions (400x240) --}}
    <img src="{{ $meal->imageUrl(400, 240) }}" alt="{{ $meal->name ?? 'Meal' }}" class="w-full h-40 object-cover" onerror="this.src='https://picsum.photos/400/240?random=999'">
    <div class="p-4 flex-1 flex flex-col">
        <h3 class="text-lg font-semibold mb-1 text-[#1f2937]">{{ $meal->name ?? 'Unknown Meal' }}</h3>
        <p class="text-sm text-slate-600 mb-2 flex-1">{{ $meal->description ?? 'A delicious recipe.' }}</p>
        <p class="text-xs text-slate-500 mb-3">
            @php
                $ings = $meal->ingredients?->pluck('name')->toArray() ?? ['egg','flour','milk'];
            @endphp
            @foreach(array_slice($ings,0,3) as $ing)
                {{ $ing }}@if(!$loop->last), @endif
            @endforeach
            @if(count($ings) > 3) ... @endif
        </p>
        <div class="flex justify-between items-center">
            @auth
                <div class="flex gap-2">
                    <button onclick="toggleFavorite({{ $meal->id }}, 'favorite', this)"
                            class="favorite-btn text-[#d4af37] hover:text-[#b7950b] focus:outline-none transition-colors {{ auth()->user()->allFavoritedMeals()->where('meal_id', $meal->id)->wherePivot('type', 'favorite')->exists() ? 'favorited' : '' }}"
                            title="Add to favorites">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 heart-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.41 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.41 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                    <button onclick="toggleFavorite({{ $meal->id }}, 'saved', this)"
                            class="save-btn text-[#4c1d95] hover:text-[#3730a3] focus:outline-none transition-colors {{ auth()->user()->allFavoritedMeals()->where('meal_id', $meal->id)->wherePivot('type', 'saved')->exists() ? 'saved' : '' }}"
                            title="Save for later">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 save-icon" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                        </svg>
                    </button>
                </div>
            @else
                <div class="flex gap-2">
                    <button onclick="window.location.href='{{ route('login') }}'"
                            class="text-[#d4af37] hover:text-[#b7950b] focus:outline-none transition-colors"
                            title="Login to like meals">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.41 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.41 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                    </button>
                    <button onclick="window.location.href='{{ route('login') }}'"
                            class="text-[#4c1d95] hover:text-[#3730a3] focus:outline-none transition-colors"
                            title="Login to save meals">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                        </svg>
                    </button>
                </div>
            @endauth
            <a href="{{ route('meals.show', ['id' => $meal->id ?? 1]) }}" class="text-[#4c1d95] hover:text-[#3730a3] font-semibold text-sm transition-colors">View details</a>
        </div>
    </div>
</div>