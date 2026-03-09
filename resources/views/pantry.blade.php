@extends('layouts.app')

@section('title', 'Pantry Inventory')

@section('content')
    <div class="space-y-12 pb-12">
        <!-- Modern Header -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
            <div>
                <h1 class="text-3xl font-bold text-slate-900 tracking-tight">Pantry Inventory.</h1>
                <p class="text-slate-500 text-sm mt-1">Manage your fresh ingredients and reduce household waste.</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative group">
                    <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary-500 transition-colors"></i>
                    <input type="text" placeholder="Search ingredients..."
                        class="pl-11 pr-4 py-2.5 bg-white border border-slate-100 rounded-xl text-xs w-64 focus:ring-2 focus:ring-primary-100 focus:border-primary-500 transition-all outline-none shadow-sm">
                </div>
                <button
                    class="px-5 py-2.5 bg-slate-900 text-white rounded-xl text-[11px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-all flex items-center gap-2 shadow-lg shadow-slate-900/10 active:scale-95">
                    <i class="fas fa-plus text-[10px]"></i>
                    <span>Add Ingredient</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            <!-- Ingredients List -->
            <div class="lg:col-span-8 space-y-6">
                <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-white">
                        <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em]">Current Stock</h2>
                        <div class="flex items-center gap-4 text-[10px] font-bold text-slate-400 uppercase tracking-widest">
                            <span>Showing all {{ count($ingredients) }} items</span>
                        </div>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($ingredients as $ing)
                            <div class="flex items-center justify-between px-8 py-5 hover:bg-slate-25/50 transition-all group">
                                <div class="flex items-center gap-5">
                                    <div class="w-12 h-12 bg-slate-50 rounded-2xl flex items-center justify-center text-slate-400 group-hover:bg-primary-50 group-hover:text-primary-600 transition-all">
                                        <i class="{{ $ing['icon'] }} text-lg"></i>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 group-hover:text-primary-600 transition-colors">{{ $ing['name'] }}</p>
                                        <div class="flex items-center gap-3 mt-1">
                                            <span class="text-[10px] text-slate-400 font-medium px-2 py-0.5 bg-slate-50 rounded-md">{{ $ing['category'] }}</span>
                                            <span class="text-[10px] text-slate-300">•</span>
                                            <span class="text-[10px] text-slate-400">Added {{ $ing['added_at'] }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center gap-8">
                                    <div class="text-right">
                                        @if($ing['days_left'] <= 3)
                                            <span class="px-3 py-1 bg-rose-50 text-rose-600 text-[10px] font-bold uppercase tracking-widest rounded-full">
                                                Expiring: {{ $ing['days_left'] }} Days
                                            </span>
                                        @elseif($ing['days_left'] <= 7)
                                            <span class="px-3 py-1 bg-amber-50 text-amber-600 text-[10px] font-bold uppercase tracking-widest rounded-full">
                                                {{ $ing['days_left'] }} Days left
                                            </span>
                                        @else
                                            <span class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-bold uppercase tracking-widest rounded-full">
                                                Fresh
                                            </span>
                                        @endif
                                    </div>
                                    <button class="w-8 h-8 flex items-center justify-center text-slate-300 hover:text-rose-500 hover:bg-rose-50 rounded-lg transition-all">
                                        <i class="fas fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </div>
                        @empty
                            <div class="py-20 text-center space-y-4">
                                <div class="w-16 h-16 bg-slate-50 rounded-full flex items-center justify-center mx-auto transition-transform hover:rotate-12">
                                    <i class="fas fa-boxes-stacked text-slate-200 text-2xl"></i>
                                </div>
                                <div class="space-y-1">
                                    <h3 class="text-sm font-bold text-slate-900 tracking-tight">Your pantry is empty</h3>
                                    <p class="text-xs text-slate-400 max-w-xs mx-auto">Start adding fresh ingredients to get recipe recommendations.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Insights Section -->
            <div class="lg:col-span-4 space-y-8">
                <div class="space-y-4">
                    <h2 class="text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] px-1">Quick Insights</h2>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="p-6 bg-white border border-slate-100 rounded-3xl shadow-sm group hover:border-primary-100 transition-all">
                            <div class="w-10 h-10 rounded-xl bg-primary-50 text-primary-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-chart-pie text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total Items</p>
                            <p class="text-3xl font-bold text-slate-900 tracking-tight">{{ $stats['total_items'] }}</p>
                        </div>
                        <div class="p-6 bg-white border border-slate-100 rounded-3xl shadow-sm group hover:border-primary-100 transition-all">
                            <div class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                                <i class="fas fa-utensils text-sm"></i>
                            </div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Possible Meals</p>
                            <p class="text-3xl font-bold text-slate-900 tracking-tight">{{ $stats['possible_meals'] }}</p>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection