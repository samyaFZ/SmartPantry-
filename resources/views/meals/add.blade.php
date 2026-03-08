@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold text-[#1f2937]">Add a New Meal</h1>

        <form action="{{ route('meals.store') }}" method="POST" class="bg-white rounded-lg shadow-lg p-8 space-y-6 border border-slate-200">
            @csrf
            <div>
                <label class="block text-sm font-semibold text-[#1f2937] mb-2">Meal Name</label>
                <input name="name" type="text" placeholder="e.g., Grilled Chicken with Rice" value="{{ old('name') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4c1d95] bg-white shadow-sm" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#1f2937] mb-2">Description</label>
                <textarea name="description" placeholder="Brief description of the meal" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4c1d95] bg-white shadow-sm" rows="3">{{ old('description') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#1f2937] mb-2">Meal Image URL</label>
                <input name="image" type="url" placeholder="https://example.com/image.jpg" value="{{ old('image') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4c1d95] bg-white shadow-sm" />
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#1f2937] mb-2">Ingredients (one per line)</label>
                <textarea name="ingredients" placeholder="Chicken Breast&#10;Rice&#10;Tomato" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4c1d95] bg-white shadow-sm" rows="4">{{ old('ingredients') }}</textarea>
            </div>

            <div>
                <label class="block text-sm font-semibold text-[#1f2937] mb-2">Preparation Steps (one per line)</label>
                <textarea name="steps" placeholder="Heat oil in a pan&#10;Add chicken and cook" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4c1d95] bg-white shadow-sm" rows="4">{{ old('steps') }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-semibold text-[#1f2937] mb-2">Calories</label>
                    <input name="calories" type="number" placeholder="350" value="{{ old('calories') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4c1d95] bg-white shadow-sm" />
                </div>
                <div>
                    <label class="block text-sm font-semibold text-[#1f2937] mb-2">Prep Time (mins)</label>
                    <input name="prep_time" type="number" placeholder="30" value="{{ old('prep_time') }}" class="w-full rounded-lg border border-slate-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#4c1d95] bg-white shadow-sm" />
                </div>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="submit" class="flex-1 px-6 py-3 rounded-lg bg-[#4c1d95] text-white font-semibold hover:bg-[#3730a3] transition-colors shadow-md">
                    <i class="fas fa-check mr-2"></i>Save Meal
                </button>
                <a href="{{ route('home') }}" class="flex-1 px-6 py-3 rounded-lg border border-slate-300 text-[#1f2937] font-semibold hover:bg-slate-50 transition-colors text-center shadow-md">
                    Cancel
                </a>
            </div>
        </form>
    </div>
@endsection