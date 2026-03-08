@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto space-y-8">
        <h1 class="text-3xl font-bold text-[#374151]">Your Nutrition Profile</h1>

        <!-- Flash Messages -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- profile card -->
            <div class="bg-white rounded-lg shadow-lg p-8 border border-slate-200">
                <div class="text-center">
                    <div class="w-24 h-24 rounded-full bg-gradient-to-r from-[#4c1d95] to-[#d4af37] mx-auto mb-4 flex items-center justify-center shadow-md">
                        <span class="text-2xl font-bold text-white">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
                    </div>
                    <h2 class="text-2xl font-bold text-[#374151]">{{ auth()->user()->name }}</h2>
                    <p class="text-slate-600 text-sm">{{ auth()->user()->email }}</p>
                    <p class="text-xs text-slate-500 mt-1">Member since {{ auth()->user()->created_at->format('M Y') }}</p>
                    <button type="button" onclick="openEditModal()" class="mt-4 px-4 py-2 bg-[#d4af37] text-white rounded-lg hover:bg-[#b7950b] transition-colors shadow-md">
                        <i class="fas fa-edit mr-1"></i>Edit Profile
                    </button>
                </div>
            </div>

            <!-- stats and settings -->
            <div class="lg:col-span-2 space-y-6">
                <!-- stats -->
                <div class="bg-white rounded-lg shadow-lg p-6 border border-slate-200">
                    <h3 class="text-xl font-semibold mb-4 text-[#374151]">Your Wellness Journey</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-[#f9fafb] rounded-lg border border-slate-200">
                            <p class="text-xs text-slate-600">Healthy Recipes Saved</p>
                            <p class="text-3xl font-bold text-[#4c1d95]">{{ auth()->user()->favoriteMeals()->count() }}</p>
                        </div>
                        <div class="p-4 bg-[#fef3c7] rounded-lg border border-[#d4af37]/20">
                            <p class="text-xs text-slate-600">Meals You've Created</p>
                            <p class="text-3xl font-bold text-[#d4af37]">{{ auth()->user()->meals()->count() }}</p>
                        </div>
                        <div class="p-4 bg-[#f9fafb] rounded-lg border border-slate-200">
                            <p class="text-xs text-slate-600">Ingredients Tracked</p>
                            <p class="text-3xl font-bold text-[#4c1d95]">{{ \App\Models\Ingredient::count() }}</p>
                        </div>
                        <div class="p-4 bg-[#fef3c7] rounded-lg border border-[#d4af37]/20">
                            <p class="text-xs text-slate-600">Health Journey Started</p>
                            <p class="text-sm font-bold text-[#d4af37]">{{ auth()->user()->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <!-- settings -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h3 class="text-xl font-semibold mb-4 text-[#374151]">Nutrition Preferences</h3>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between p-3 hover:bg-[#f9fafb] rounded-lg cursor-pointer transition-colors">
                            <span class="text-[#374151]">Email Notifications</span>
                            <input type="checkbox" checked class="w-4 h-4 text-[#4c1d95] focus:ring-[#4c1d95]" />
                        </div>
                        <div class="flex items-center justify-between p-3 hover:bg-[#f9fafb] rounded-lg cursor-pointer transition-colors">
                            <span class="text-[#374151]">Dark Mode</span>
                            <input type="checkbox" class="w-4 h-4 text-[#4c1d95] focus:ring-[#4c1d95]" />
                        </div>
                        <div class="flex items-center justify-between p-3 hover:bg-[#f9fafb] rounded-lg cursor-pointer transition-colors">
                            <span class="text-[#374151]">Two-Factor Authentication</span>
                            <input type="checkbox" class="w-4 h-4 text-[#4c1d95] focus:ring-[#4c1d95]" />
                        </div>
                    </div>
                </div>

                <!-- danger zone -->
                <div class="bg-red-50 border border-red-200 rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-red-700 mb-4">Danger Zone</h3>
                    <p class="text-sm text-red-600 mb-4">Once you delete your account, there is no going back. This action cannot be undone.</p>

                    <!-- Delete Account Form -->
                    <form method="POST" action="{{ route('account.delete') }}" onsubmit="return confirm('Are you sure you want to permanently delete your account? This action cannot be undone.')" class="inline">
                        @csrf
                        @method('DELETE')
                        <div class="mb-4">
                            <label for="password" class="block text-sm font-medium text-red-700 mb-2">Confirm your password to delete your account</label>
                            <input type="password" id="password" name="password" required
                                   class="w-full px-3 py-2 border border-red-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500">
                        </div>
                        <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors shadow-md">
                            <i class="fas fa-trash mr-2"></i>Delete Account Permanently
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Profile Modal -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-xl max-w-md w-full mx-4">
            <div class="p-6">
                <h3 class="text-lg font-semibold text-[#374151] mb-4">Edit Profile</h3>
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                        <input type="text" id="edit_name" name="name" value="{{ auth()->user()->name }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4c1d95] focus:border-[#4c1d95]">
                    </div>
                    <div class="mb-6">
                        <label for="edit_email" class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                        <input type="email" id="edit_email" name="email" value="{{ auth()->user()->email }}" required
                               class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#4c1d95] focus:border-[#4c1d95]">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#4c1d95] text-white rounded-lg hover:bg-[#3b0d7a] transition-colors">
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

        // Close modal when clicking outside
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeEditModal();
            }
        });
    </script>
@endsection