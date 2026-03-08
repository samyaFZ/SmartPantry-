@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-[#374151]">My Favorites</h1>
            <span class="text-sm text-slate-500">{{ auth()->user()->favoriteMeals->count() + auth()->user()->savedMeals->count() }} meals saved</span>
        </div>

        {{-- Favorited Meals Section --}}
        @if(auth()->user()->favoriteMeals->count() > 0)
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-[#374151] flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.41 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.41 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    Favorited Meals
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(auth()->user()->favoriteMeals as $meal)
                        <x-meal-card :meal="$meal" />
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Saved Meals Section --}}
        @if(auth()->user()->savedMeals->count() > 0)
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-[#374151] flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
                    </svg>
                    Saved Meals
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach(auth()->user()->savedMeals as $meal)
                        <x-meal-card :meal="$meal" />
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Empty State --}}
        @if(auth()->user()->favoriteMeals->count() === 0 && auth()->user()->savedMeals->count() === 0)
            <div class="text-center py-12 bg-[#f9fafb] rounded-lg border border-gray-100">
                <i class="fas fa-heart text-4xl text-slate-300 mb-4 block"></i>
                <p class="text-slate-600">No favorites yet. Start saving meals!</p>
            </div>
        @endif
    </div>
@endsection