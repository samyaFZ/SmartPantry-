@extends('layouts.app')

@section('title', 'Welcome back, ' . auth()->user()->name)

@section('content')
    <div class="space-y-12">
        <!-- Dashboard Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div
                class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-primary-100 transition-all">
                <div
                    class="w-12 h-12 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-boxes-stacked"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Pantry Items</p>
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">{{ $stats['pantry_count'] }}</h3>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-primary-100 transition-all">
                <div
                    class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-hourglass-half"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Expiring Soon</p>
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">{{ $stats['expiring_count'] }}</h3>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-primary-100 transition-all">
                <div
                    class="w-12 h-12 rounded-xl bg-rose-50 text-rose-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-heart"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Favorites</p>
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">{{ $stats['favorites_count'] }}</h3>
                </div>
            </div>
            <div
                class="bg-white p-6 rounded-2xl border border-slate-100 shadow-sm flex items-center gap-5 group hover:border-primary-100 transition-all">
                <div
                    class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl group-hover:scale-110 transition-transform">
                    <i class="fas fa-bookmark"></i>
                </div>
                <div>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Saved Items</p>
                    <h3 class="text-xl font-bold text-slate-900 tracking-tight">{{ $stats['saved_count'] }}</h3>
                </div>
            </div>
        </div>

        <!-- Simplified Search Header -->
        <section class="max-w-3xl mx-auto py-2 lg:py-4 text-center space-y-6">
            <div class="space-y-3">
                <h1 class="text-3xl lg:text-4xl font-bold text-slate-900 tracking-tight text-balance">Discover your next
                    meal.</h1>
                <p class="text-slate-500 text-sm max-w-sm mx-auto leading-relaxed font-medium">Search ingredients to
                    discover recipes that make sense for your stock.</p>
            </div>

            <form action="{{ route('home') }}" method="GET" class="relative max-w-2xl mx-auto">
                <i class="fas fa-search absolute left-6 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="q" value="{{ $query ?? '' }}" placeholder="Salmon, spinach, quinoa..."
                    class="w-full pl-14 pr-36 py-4 rounded-2xl border border-slate-100 bg-slate-50 text-slate-900 text-sm focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 focus:bg-white transition-all shadow-sm shadow-slate-100/50" />
                <button type="submit"
                    class="absolute right-2 top-2 bottom-2 px-6 rounded-xl bg-primary-600 text-white text-[11px] font-bold uppercase tracking-widest hover:bg-primary-700 transition-all active:scale-95 shadow-lg shadow-primary-600/10">
                    Discover
                </button>
            </form>

            <div
                class="flex items-center justify-center flex-wrap gap-3 text-[10px] font-bold text-slate-400 uppercase tracking-[0.15em]">
                <span class="mr-2">Popular:</span>
                <a href="?q=avocado" class="hover:text-primary-600 transition-colors">#avocado</a>
                <a href="?q=chicken" class="hover:text-primary-600 transition-colors">#chicken</a>
                <a href="?q=keto" class="hover:text-primary-600 transition-colors">#keto</a>
                <a href="?q=vegan" class="hover:text-primary-600 transition-colors">#vegan</a>
            </div>
        </section>

        <!-- Meals Grid -->
        <section class="space-y-8 pb-12">
            <div class="flex items-center justify-between border-b border-slate-100 pb-6">
                <div class="flex items-center gap-3">
                    <h2 class="text-lg font-bold text-slate-900 tracking-tight">
                        {{ !empty($query) ? 'Search Results' : 'Recommended for you' }}
                    </h2>
                    <span
                        class="px-2 py-0.5 bg-slate-100 text-slate-500 text-[10px] font-bold rounded-md">{{ count($meals) }}
                        Recipes</span>
                </div>
                <div class="flex items-center gap-3">
                    <select
                        class="bg-white border border-slate-200 rounded-xl text-[10px] font-bold uppercase tracking-widest px-4 py-2 focus:ring-2 focus:ring-primary-100 focus:border-primary-500 outline-none transition-all">
                        <option>Recommended</option>
                        <option>Newest First</option>
                        <option>Ready Under 30m</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 gap-8">
                @forelse($meals as $meal)
                    <x-meal-card :meal="$meal" />
                @empty
                    <div class="col-span-full py-24 text-center space-y-6">
                        <div
                            class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto transition-transform hover:rotate-12">
                            <i class="fas fa-search text-slate-200 text-2xl"></i>
                        </div>
                        <div class="space-y-2">
                            <h3 class="text-base font-bold text-slate-900 tracking-tight">No recipes found</h3>
                            <p class="text-xs text-slate-500 max-w-xs mx-auto leading-relaxed">Try adjusting your search terms
                                or exploring our recommendations below.</p>
                        </div>
                        <a href="{{ route('home') }}"
                            class="inline-flex items-center gap-2 px-6 py-3 bg-primary-600 text-white text-[11px] font-bold uppercase tracking-widest rounded-xl hover:bg-primary-500 transition-all shadow-lg shadow-primary-600/20 active:scale-95">
                            Clear Filters <i class="fas fa-times text-[10px]"></i>
                        </a>
                    </div>
                @endforelse
            </div>
        </section>
    </div>
@endsection