@extends('layouts.app')

@section('content')
    <div class="space-y-10">
        <!-- search header -->
        <section>
            <form action="{{ route('home') }}" method="GET" class="max-w-3xl mx-auto flex gap-2">
                <input type="text" name="q" placeholder="Enter fresh ingredients you have (e.g., organic chicken, brown rice, leafy greens)"
                       class="flex-1 rounded-full border border-slate-300 px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#4c1d95] bg-white shadow-sm" />
                <button type="submit" class="px-6 py-3 rounded-full bg-[#4c1d95] text-white font-semibold hover:bg-[#3730a3] transition-colors shadow-lg">
                    <i class="fas fa-search mr-2"></i>Find Healthy Meals
                </button>
            </form>
        </section>

        {{-- show simple profile summary when logged in --}}
        @auth
            <section class="max-w-3xl mx-auto mt-6">
                <div class="bg-white rounded-lg shadow-lg p-6 flex items-center border border-slate-200">
                    <div class="w-16 h-16 rounded-full bg-gradient-to-r from-[#4c1d95] to-[#d4af37] flex items-center justify-center text-white text-2xl font-bold shadow-md">
                        {{ strtoupper(substr(auth()->user()->name,0,1)) }}
                    </div>
                    <div class="ml-4">
                        <h3 class="text-xl font-semibold text-[#1f2937]">{{ auth()->user()->name }}</h3>
                        <p class="text-sm text-slate-600">{{ auth()->user()->email }}</p>
                        <div class="mt-2 space-x-4">
                            <a href="{{ route('profile') }}" class="text-[#4c1d95] hover:text-[#3730a3] font-medium transition-colors">View Profile</a>
                            <a href="{{ route('meals.add') }}" class="text-[#d4af37] hover:text-[#b7950b] font-medium transition-colors">Add Meal</a>
                        </div>
                    </div>
                </div>
            </section>
        @endauth

        <!-- meals grid (random or search results) -->
        <section>
            @if(!empty($query))
                <h2 class="text-2xl font-bold mb-6 text-[#374151]">Nutrient-Rich Meals with Your Ingredients</h2>
            @else
                <h2 class="text-2xl font-bold mb-6 text-[#374151]">Discover Healthy Meal Inspiration</h2>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($meals as $meal)
                    <x-meal-card :meal="$meal" />
                @empty
                    <div class="col-span-full text-center text-gray-500">
                        @if(!empty($query))
                            <div class="max-w-md mx-auto">
                                <i class="fas fa-leaf text-4xl text-[#4c1d95] mb-4 block"></i>
                                <p class="text-lg font-medium mb-2">No recipes found with those ingredients</p>
                                <p class="text-sm">Try different combinations or add more fresh ingredients to discover nutrient-rich meal options!</p>
                            </div>
                        @else
                            <div class="max-w-md mx-auto">
                                <i class="fas fa-utensils text-4xl text-[#d4af37] mb-4 block"></i>
                                <p class="text-lg font-medium mb-2">Your healthy meal library is empty</p>
                                <p class="text-sm">Start building your collection of nutritious recipes for optimal wellness!</p>
                            </div>
                        @endif
                    </div>
                    {{-- show loading placeholders if we expected random meals but none exist --}}
                    @if(empty($query))
                        @for($i=0;$i<6;$i++)
                            <div class="bg-white rounded-lg shadow animate-pulse h-64"></div>
                        @endfor
                    @endif
                @endforelse
            </div>
        </section>
    </div>
@endsection