@extends('layouts.app')

@section('title', 'Wellness Profile')

@section('content')
    <div class="max-w-6xl mx-auto space-y-12 pb-24">
        <!-- Flash Messages -->
        @if(session('success'))
            <div class="p-4 mb-4 text-xs font-bold text-green-700 bg-green-25 border border-green-100 rounded-lg flex items-center gap-3 uppercase tracking-widest"
                role="alert">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left Column: User Card -->
            <div class="lg:col-span-4 space-y-8">
                <div class="bg-white rounded-xl border border-slate-100 p-8 text-center space-y-6">
                    <div
                        class="w-20 h-20 rounded-xl bg-slate-25 border border-slate-100 mx-auto flex items-center justify-center text-2xl font-bold text-slate-900">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-lg font-bold text-slate-900">{{ auth()->user()->name }}</h2>
                        <p class="text-xs text-slate-400 font-medium">{{ auth()->user()->email }}</p>
                    </div>
                    <div class="pt-4">
                        <button type="button" onclick="openEditModal()"
                            class="w-full py-2.5 bg-slate-900 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-colors">
                            Edit Profile
                        </button>
                    </div>
                    <p class="text-[9px] text-slate-300 font-bold uppercase tracking-widest">Joined
                        {{ auth()->user()->created_at->format('M Y') }}
                    </p>
                </div>

                <!-- Wellness Widget -->
                <div class="bg-slate-25 rounded-xl border border-slate-100 p-8 space-y-4">
                    <h3 class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Wellness Score</h3>
                    <div class="flex items-baseline gap-1">
                        <span class="text-4xl font-bold text-slate-900 leading-none">84</span>
                        <span class="text-xs text-slate-300 font-bold">/ 100</span>
                    </div>
                    <div class="w-full bg-slate-100 h-1.5 rounded-full">
                        <div class="bg-indigo-600 h-full rounded-full w-[84%]"></div>
                    </div>
                    <p class="text-[10px] text-slate-500 leading-relaxed font-medium mt-4">Your collection is highly
                        balanced this week. Keep it up.</p>
                </div>
            </div>

            <!-- Right Column: Settings -->
            <div class="lg:col-span-8 flex flex-col gap-12">
                <!-- Stats -->
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-6">
                    <div class="p-6 border border-slate-100 rounded-xl bg-white">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Favorited</p>
                        <p class="text-2xl font-bold text-slate-900 leading-none">
                            {{ auth()->user()->favoriteMeals()->count() }}
                        </p>
                    </div>
                    <div class="p-6 border border-slate-100 rounded-xl bg-white">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Created</p>
                        <p class="text-2xl font-bold text-slate-900 leading-none">{{ auth()->user()->meals()->count() }}</p>
                    </div>
                    <div class="p-6 border border-slate-100 rounded-xl bg-white">
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Stock</p>
                        <p class="text-2xl font-bold text-slate-900 leading-none">12 items</p>
                    </div>
                </div>

                <!-- Preferences -->
                <div class="space-y-6">
                    <h3
                        class="text-[10px] font-bold text-slate-400 uppercase tracking-widest border-b border-slate-50 pb-4">
                        Settings & Preferences</h3>
                    <div class="space-y-3">
                        <label
                            class="flex items-center justify-between p-4 rounded-lg border border-slate-50 hover:bg-slate-25 transition-colors cursor-pointer group">
                            <span
                                class="text-xs font-bold text-slate-700 group-hover:text-slate-900 transition-colors">Daily
                                Meal Reminders</span>
                            <input type="checkbox" checked
                                class="w-4 h-4 text-slate-900 rounded border-slate-300 focus:ring-slate-900" />
                        </label>
                        <label
                            class="flex items-center justify-between p-4 rounded-lg border border-slate-50 hover:bg-slate-25 transition-colors cursor-pointer group">
                            <span
                                class="text-xs font-bold text-slate-700 group-hover:text-slate-900 transition-colors">Vegan
                                Recommendations</span>
                            <input type="checkbox"
                                class="w-4 h-4 text-slate-900 rounded border-slate-300 focus:ring-slate-900" />
                        </label>
                    </div>
                </div>

                <!-- Delete -->
                <div class="pt-8 border-t border-slate-50 space-y-6">
                    <div>
                        <h3 class="text-[10px] font-bold text-red-500 uppercase tracking-widest mb-1">Danger Zone</h3>
                        <p class="text-xs text-slate-400">Permanently delete your account and all associated data.</p>
                    </div>
                    <form method="POST" action="{{ route('account.delete') }}"
                        class="flex flex-col sm:flex-row gap-4 items-end">
                        @csrf
                        @method('DELETE')
                        <div class="w-full sm:flex-1">
                            <input type="password" name="password" required placeholder="Verify Password"
                                class="w-full px-4 py-2 bg-slate-50 border border-slate-100 rounded-lg text-xs focus:ring-1 focus:ring-red-200">
                        </div>
                        <button type="submit"
                            class="px-6 py-2 bg-red-50 text-red-600 rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-red-100 transition-colors">
                            Delete Account
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editModal"
        class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm hidden z-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-xl shadow-xl max-w-sm w-full overflow-hidden border border-slate-100">
            <div class="p-8 space-y-6">
                <div class="flex items-center justify-between">
                    <h3 class="text-sm font-bold text-slate-900 uppercase tracking-widest">Edit Profile</h3>
                    <button onclick="closeEditModal()" class="text-slate-300 hover:text-slate-600 transition-colors">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
                <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
                    @csrf
                    @method('PUT')
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Name</label>
                        <input type="text" name="name" value="{{ auth()->user()->name }}" required
                            class="w-full px-4 py-2 bg-slate-25 border border-slate-100 rounded-lg text-xs focus:ring-1 focus:ring-slate-200">
                    </div>
                    <div class="space-y-1">
                        <label class="text-[10px] font-bold text-slate-400 uppercase tracking-widest px-1">Email</label>
                        <input type="email" name="email" value="{{ auth()->user()->email }}" required
                            class="w-full px-4 py-2 bg-slate-25 border border-slate-100 rounded-lg text-xs focus:ring-1 focus:ring-slate-200">
                    </div>
                    <div class="pt-4">
                        <button type="submit"
                            class="w-full py-3 bg-slate-900 text-white rounded-lg text-[10px] font-bold uppercase tracking-widest hover:bg-slate-800 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
        }
        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
        window.onclick = function (event) {
            if (event.target == document.getElementById('editModal')) {
                closeEditModal();
            }
        }
    </script>
@endsection