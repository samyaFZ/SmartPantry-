@extends('layouts.app')

@section('title', 'Your Collection')

@section('content')
    <div class="max-w-6xl mx-auto space-y-12 pb-12">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Collection.</h1>
                <p class="text-slate-500 text-sm">Your personal library of nutritious recipes.</p>
            </div>
            <div class="flex items-center gap-2 p-1 bg-slate-25 border border-slate-100 rounded-lg">
                <button class="px-4 py-1.5 bg-white border border-slate-100 rounded-md text-[10px] font-bold uppercase tracking-widest text-indigo-600 shadow-sm">All</button>
                <button class="px-4 py-1.5 text-[10px] font-bold uppercase tracking-widest text-slate-400 hover:text-slate-600 transition-colors">Recent</button>
            </div>
        </div>

        {{-- Favorited Meals Section --}}
        @if(auth()->user()->favoriteMeals->count() > 0)
            <div class="space-y-8">
                <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-heart text-red-500/50"></i> Favorited
                    </h2>
                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ auth()->user()->favoriteMeals->count() }} Items</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach(auth()->user()->favoriteMeals as $meal)
                        <x-meal-card :meal="$meal" />
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Saved Meals Section --}}
        @if(auth()->user()->savedMeals->count() > 0)
            <div class="space-y-8 pt-6">
                <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <i class="fas fa-bookmark text-indigo-500/50"></i> Saved for Later
                    </h2>
                    <span class="text-[10px] font-bold text-slate-300 uppercase tracking-widest">{{ auth()->user()->savedMeals->count() }} Items</span>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                    @foreach(auth()->user()->savedMeals as $meal)
                        <x-meal-card :meal="$meal" />
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Empty State --}}
        @if(auth()->user()->favoriteMeals->count() === 0 && auth()->user()->savedMeals->count() === 0)
            <div class="py-24 text-center space-y-6 max-w-sm mx-auto">
                <div class="text-slate-100 text-5xl">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest">Empty Collection</h3>
                <p class="text-xs text-slate-400 leading-relaxed">Save recipes you love to find them easily and plan your weekly meal prep faster.</p>
                <a href="{{ route('home') }}"
                    class="inline-block px-8 py-3 bg-slate-900 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-colors">
                    Find Recipes
                </a>
            </div>
        @endif
    </div>
@endsection