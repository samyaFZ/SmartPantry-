@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto py-4">
        <div class="flex flex-col lg:flex-row gap-6">
            {{-- Left-Mid Section: Image & Steps --}}
            <div class="lg:w-1/2 space-y-4">
                {{-- Recipe Image --}}
                <div class="rounded-lg overflow-hidden shadow-xl">
                    <img src="{{ $meal->imageUrl(700,400) }}" alt="{{ $meal->name ?? 'Meal' }}" class="w-full h-auto object-cover" onerror="this.src='https://picsum.photos/700/400?random=999'">
                </div>

                {{-- Preparation Steps Section --}}
                <div class="bg-white p-4 rounded-lg shadow border border-slate-200">
                    <h2 class="text-xl font-bold mb-3 text-[#1f2937]">Preparation Steps</h2>
                    <ol class="list-decimal list-inside space-y-3">
                        @forelse($meal->steps ?? [] as $step)
                            <li class="text-slate-700 text-sm">
                                <span class="leading-relaxed">{{ $step }}</span>
                            </li>
                        @empty
                            <li class="text-slate-500 italic text-sm">No preparation steps available</li>
                        @endforelse
                    </ol>
                </div>
            </div>

            {{-- Right-Mid Section: Ingredients & Info --}}
            <div class="lg:w-1/2 space-y-4">
                {{-- Recipe Title --}}
                <h1 class="text-3xl font-bold text-[#1f2937] leading-tight">{{ $meal->name ?? 'Meal Title' }}</h1>

                {{-- Ingredients Section --}}
                <div class="bg-white p-4 rounded-lg shadow border border-slate-200">
                    <h2 class="text-xl font-bold mb-3 text-[#1f2937]">Ingredients</h2>
                    <ul class="space-y-2">
                        @forelse($meal->ingredients ?? [] as $ing)
                            <li class="text-slate-700 text-sm flex items-center">
                                <span class="w-2 h-2 bg-[#4c1d95] rounded-full mr-3 flex-shrink-0"></span>
                                {{ $ing->name ?? $ing }}
                            </li>
                        @empty
                            <li class="text-slate-500 italic text-sm">No ingredients listed</li>
                        @endforelse
                    </ul>
                </div>

                {{-- Nutrition Information Card --}}
                <div class="bg-[#f9fafb] p-4 rounded-lg shadow border border-slate-200">
                    <h2 class="text-xl font-bold mb-4 text-[#1f2937]">Nutrition Information</h2>
                    <div class="grid grid-cols-2 gap-4">
                        {{-- Left Column --}}
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-medium text-slate-600 mb-1">Calories</p>
                                <p class="text-lg font-bold text-[#1f2937]">{{ $meal->calories ?? 'N/A' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-600 mb-1">Prep Time</p>
                                <p class="text-lg font-bold text-[#1f2937]">{{ $meal->prep_time ?? 'N/A' }} min</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-600 mb-1">Proteins</p>
                                <p class="text-lg font-bold text-[#1f2937]">{{ $meal->protein ?? 'N/A' }}g</p>
                            </div>
                        </div>

                        {{-- Right Column --}}
                        <div class="space-y-3">
                            <div>
                                <p class="text-xs font-medium text-slate-600 mb-1">Carbs</p>
                                <p class="text-lg font-bold text-[#1f2937]">{{ $meal->carbs ?? 'N/A' }}g</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-600 mb-1">Fat</p>
                                <p class="text-lg font-bold text-[#1f2937]">{{ $meal->fat ?? 'N/A' }}g</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-slate-600 mb-1">Servings</p>
                                <p class="text-lg font-bold text-[#1f2937]">4</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="flex gap-4 pt-2">
                    @auth
                        <button onclick="toggleFavorite({{ $meal->id }}, 'favorite', this)"
                                class="favorite-btn px-4 py-2 rounded-lg bg-[#d4af37] text-white font-semibold hover:bg-[#b7950b] transition-colors shadow-md text-sm {{ auth()->user()->allFavoritedMeals()->where('meal_id', $meal->id)->wherePivot('type', 'favorite')->exists() ? 'favorited' : '' }}">
                            <i class="fas fa-heart mr-2 heart-icon"></i>Like
                        </button>
                        <button onclick="toggleFavorite({{ $meal->id }}, 'saved', this)"
                                class="save-btn px-4 py-2 rounded-lg border border-[#4c1d95] text-[#4c1d95] font-semibold hover:bg-[#4c1d95] hover:text-white transition-all shadow-md text-sm {{ auth()->user()->allFavoritedMeals()->where('meal_id', $meal->id)->wherePivot('type', 'saved')->exists() ? 'saved' : '' }}">
                            <i class="fas fa-bookmark mr-2 save-icon"></i>Save
                        </button>
                    @else
                        <button onclick="window.location.href='{{ route('login') }}'"
                                class="px-4 py-2 rounded-lg bg-[#d4af37] text-white font-semibold hover:bg-[#b7950b] transition-colors shadow-md text-sm">
                            <i class="fas fa-heart mr-2"></i>Like
                        </button>
                        <button onclick="window.location.href='{{ route('login') }}'"
                                class="px-4 py-2 rounded-lg border border-[#4c1d95] text-[#4c1d95] font-semibold hover:bg-[#4c1d95] hover:text-white transition-all shadow-md text-sm">
                            <i class="fas fa-bookmark mr-2"></i>Save
                        </button>
                    @endauth
                </div>
            </div>
        </div>
    </div>
@endsection