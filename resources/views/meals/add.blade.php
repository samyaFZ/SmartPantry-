@extends('layouts.app')

@section('title', 'Add a New Recipe')

@section('content')
    <div class="space-y-10 pb-12">
        <!-- Header -->
        <div class="space-y-2">
            <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Create Recipe.</h1>
            <p class="text-slate-500 text-sm">Draft a new nutritious meal for your collection.</p>
        </div>

        <form action="{{ route('meals.store') }}" method="POST"
            class="bg-white rounded-[2.5rem] border border-slate-300 shadow-sm p-10 lg:p-12 space-y-10">
            @csrf

            <!-- Basic Information Section -->
            <div class="space-y-8">
                <div class="flex items-center gap-3 border-b border-slate-50 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-primary-50 text-primary-600 flex items-center justify-center text-xs">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <h2 class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em]">General Information</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fas fa-heading text-slate-500"></i> Meal Name
                        </label>
                        <input name="name" type="text" placeholder="e.g., Grilled Chicken with Quinoa"
                            value="{{ old('name') }}" required
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 focus:bg-white transition-all placeholder-slate-300 shadow-sm" />
                        <p class="text-[10px] text-slate-400 font-medium italic">* Use a descriptive name for better
                            searchability.</p>
                    </div>

                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fas fa-image text-slate-500"></i> Cover Image URL
                        </label>
                        <input name="image" type="url" placeholder="https://images.unsplash.com/..."
                            value="{{ old('image') }}"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 focus:bg-white transition-all placeholder-slate-300 shadow-sm" />
                        <p class="text-[10px] text-slate-400 font-medium italic">* Optional. Leave empty for a high-quality
                            auto-image.</p>
                    </div>
                </div>

                <div class="space-y-3">
                    <label class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] flex items-center gap-2">
                        <i class="fas fa-align-left text-slate-500"></i> Description
                    </label>
                    <textarea name="description" placeholder="A brief summary of this delicious meal..."
                        class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 focus:bg-white transition-all placeholder-slate-300 shadow-sm"
                        rows="3">{{ old('description') }}</textarea>
                </div>
            </div>

            <!-- Details Section -->
            <div class="space-y-8">
                <div class="flex items-center gap-3 border-b border-slate-50 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-xs">
                        <i class="fas fa-list-check"></i>
                    </div>
                    <h2 class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em]">Ingredients & Steps</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fas fa-carrot text-slate-500"></i> Ingredients
                        </label>
                        <textarea name="ingredients"
                            placeholder="One ingredient per line...&#10;Chicken Breast&#10;2 Garlic Cloves&#10;Olive Oil"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 focus:bg-white transition-all placeholder-slate-300 shadow-sm"
                            rows="5">{{ old('ingredients') }}</textarea>
                        <p class="text-[10px] text-slate-400 font-medium italic">* Tip: Use clear units (g, ml, cloves).</p>
                    </div>

                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fas fa-list-ol text-slate-500"></i> Preparation Steps
                        </label>
                        <textarea name="steps"
                            placeholder="One step per line...&#10;Preheat the oven to 200°C&#10;Season the chicken..."
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 focus:bg-white transition-all placeholder-slate-300 shadow-sm"
                            rows="5">{{ old('steps') }}</textarea>
                        <p class="text-[10px] text-slate-400 font-medium italic">* Guide: Break it down into simple,
                            actionable steps.</p>
                    </div>
                </div>
            </div>

            <!-- Performance Section -->
            <div class="space-y-8">
                <div class="flex items-center gap-3 border-b border-slate-50 pb-4">
                    <div class="w-8 h-8 rounded-lg bg-rose-50 text-rose-600 flex items-center justify-center text-xs">
                        <i class="fas fa-bolt"></i>
                    </div>
                    <h2 class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em]">Nutrition & Timing</h2>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fas fa-fire text-slate-500"></i> Calories (kcal)
                        </label>
                        <input name="calories" type="number" placeholder="e.g., 450" value="{{ old('calories') }}"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 focus:bg-white transition-all placeholder-slate-300 shadow-sm" />
                    </div>

                    <div class="space-y-3">
                        <label
                            class="text-[10px] font-bold text-slate-600 uppercase tracking-[0.2em] flex items-center gap-2">
                            <i class="fas fa-clock text-slate-500"></i> Prep Time (minutes)
                        </label>
                        <input name="prep_time" type="number" placeholder="e.g., 25" value="{{ old('prep_time') }}"
                            class="w-full rounded-xl border border-slate-300 bg-slate-50/50 px-5 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-primary-100 focus:border-primary-500 focus:bg-white transition-all placeholder-slate-300 shadow-sm" />
                    </div>
                </div>
            </div>

            <div class="flex items-center gap-6 pt-6 border-t border-slate-50">
                <button type="submit"
                    class="flex-1 px-8 py-4 rounded-xl bg-primary-600 text-white text-[11px] font-bold uppercase tracking-widest hover:bg-primary-700 transition-all shadow-lg shadow-primary-600/20 active:scale-95 flex items-center justify-center gap-2">
                    <i class="fas fa-plus"></i> Save Recipe
                </button>
                <a href="{{ route('home') }}"
                    class="flex-1 px-8 py-4 rounded-xl border bg-slate-200 border-slate-300 text-slate-600 text-[11px] font-bold uppercase tracking-widest hover:bg-slate-300 hover:text-slate-600 transition-all text-center">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection