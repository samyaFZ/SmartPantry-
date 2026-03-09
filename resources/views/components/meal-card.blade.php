<div
    class="group bg-white rounded-xl border border-slate-100 overflow-hidden flex flex-col transition-all hover:border-primary-100 hover:shadow-xl hover:shadow-slate-100/50">
    <div class="relative h-48 overflow-hidden bg-slate-50">
        <img src="{{ $meal->imageUrl(400, 240) }}" alt="{{ $meal->name ?? 'Meal' }}"
            class="w-full h-full object-cover opacity-90 group-hover:opacity-100 group-hover:scale-105 transition-all duration-700"
            onerror="this.src='https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=400&h=240&auto=format&fit=crop'">

        @auth
            <div
                class="absolute top-3 right-3 flex flex-col gap-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                <button onclick="toggleFavorite({{ $meal->id }}, 'favorite', this)"
                    class="h-9 w-9 bg-white/90 backdrop-blur-sm border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-red-500 transition-all shadow-sm {{ auth()->user()->allFavoritedMeals()->where('meal_id', $meal->id)->wherePivot('type', 'favorite')->exists() ? 'text-red-500' : '' }}">
                    <i class="fas fa-heart text-xs"></i>
                </button>
                <button onclick="toggleFavorite({{ $meal->id }}, 'saved', this)"
                    class="h-9 w-9 bg-white/90 backdrop-blur-sm border border-slate-100 rounded-xl flex items-center justify-center text-slate-400 hover:text-primary-600 transition-all shadow-sm {{ auth()->user()->allFavoritedMeals()->where('meal_id', $meal->id)->wherePivot('type', 'saved')->exists() ? 'text-primary-600' : '' }}">
                    <i class="fas fa-bookmark text-xs"></i>
                </button>
            </div>
        @endauth

        <div class="absolute bottom-3 left-3">
            <span
                class="px-2.5 py-1 bg-white/90 backdrop-blur-sm text-slate-900 text-[10px] font-bold uppercase tracking-wider rounded-lg border border-slate-100 shadow-sm">
                {{ $meal->category ?? 'Recipe' }}
            </span>
        </div>
    </div>

    <div class="p-5 flex-1 flex flex-col">
        <h3
            class="text-base font-bold text-slate-900 mb-1.5 tracking-tight group-hover:text-primary-600 transition-colors">
            {{ $meal->name ?? 'Unknown Meal' }}
        </h3>
        <p class="text-xs text-slate-500 line-clamp-2 mb-5 leading-relaxed">
            {{ $meal->description ?? 'A balanced recipe for your healthy lifestyle.' }}
        </p>

        <div class="flex items-center gap-2 mb-5 flex-wrap">
            @php $ings = $meal->ingredients?->pluck('name')->toArray() ?? ['balanced', 'fresh']; @endphp
            @foreach(array_slice($ings, 0, 3) as $ing)
                <span
                    class="text-[10px] text-slate-400 font-bold uppercase tracking-wider px-2 py-0.5 bg-slate-50 rounded-md">#{{ strtolower($ing) }}</span>
            @endforeach
        </div>

        <div class="mt-auto pt-4 border-t border-slate-50 flex items-center justify-between">
            <div class="flex items-center gap-1.5 text-slate-400">
                <i class="far fa-clock text-[10px]"></i>
                <span class="text-[10px] font-bold uppercase tracking-wider">15-30 min</span>
            </div>
            <a href="{{ route('meals.show', ['id' => $meal->id ?? 1]) }}"
                class="text-[11px] font-bold text-primary-600 hover:text-primary-700 transition-colors uppercase tracking-widest flex items-center gap-1 group/btn">
                View <i
                    class="fas fa-chevron-right text-[8px] group-hover/btn:translate-x-0.5 transition-transform"></i>
            </a>
        </div>
    </div>
</div>