@extends('layouts.app')

@section('content')
    <div class="space-y-8">
        <div class="flex items-center justify-between">
            <h1 class="text-3xl font-bold text-[#374151]">Fresh Ingredient Inventory</h1>
            <button class="px-4 py-2 bg-[#4c1d95] text-white rounded-lg hover:bg-[#3b0d7a] transition shadow-lg">
                <i class="fas fa-plus mr-2"></i>Add Fresh Ingredient
            </button>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- ingredients list -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold mb-4 text-[#374151]">Current Fresh Ingredients</h2>
                    <div class="space-y-2">
                        @php $ingredients = ['Organic Chicken Breast', 'Brown Rice', 'Cherry Tomatoes', 'Baby Spinach', 'Extra Virgin Olive Oil', 'Himalayan Sea Salt']; @endphp
                        @foreach($ingredients as $ing)
                            <div class="flex items-center justify-between p-3 bg-[#f9fafb] rounded-lg hover:bg-[#f3f4f6] transition border border-gray-100">
                                <span class="text-[#374151]">{{ $ing }}</span>
                                <button class="text-red-500 hover:text-red-600 transition">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        @endforeach
                    </div>
                    @if(empty($ingredients))
                        <p class="text-slate-600 text-center py-8">No ingredients yet. Add some to get started!</p>
                    @endif
                </div>
            </div>

            <!-- suggestions -->
            <div>
                <div class="bg-white rounded-lg shadow-lg p-6 border border-gray-200">
                    <h2 class="text-xl font-semibold mb-4 text-[#374151]">Quick Stats</h2>
                    <div class="space-y-3">
                        <div class="p-3 bg-[#f9fafb] rounded-lg border border-gray-100">
                            <p class="text-xs text-slate-600">Total Ingredients</p>
                            <p class="text-2xl font-bold text-[#4c1d95]">{{ count($ingredients) }}</p>
                        </div>
                        <div class="p-3 bg-[#fef3c7] rounded-lg border border-[#d4af37]/20">
                            <p class="text-xs text-slate-600">Possible Meals</p>
                            <p class="text-2xl font-bold text-[#d4af37]">12</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection