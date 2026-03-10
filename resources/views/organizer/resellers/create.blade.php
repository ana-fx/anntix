<x-layouts.organizer>
    <div class="max-w-4xl mx-auto">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('organizer.resellers.index') }}"
                class="p-2 bg-white border border-gray-100 rounded-xl text-gray-400 hover:text-primary transition-colors shadow-sm">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path>
                </svg>
            </a>
            <h2 class="text-3xl font-bold text-gray-900">Add New Reseller</h2>
        </div>

        <form action="{{ route('organizer.resellers.store') }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Photo Upload -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-4 italic">Profile Photo</label>
                        <div x-data="{ photoPreview: null }" class="flex items-center gap-6">
                            <div class="relative group">
                                <div
                                    class="w-24 h-24 rounded-2xl bg-gray-50 border-2 border-dashed border-gray-200 flex items-center justify-center overflow-hidden transition-colors group-hover:border-primary">
                                    <template x-if="!photoPreview">
                                        <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </template>
                                    <template x-if="photoPreview">
                                        <img :src="photoPreview" class="w-full h-full object-cover">
                                    </template>
                                </div>
                                <input type="file" name="photo" class="absolute inset-0 opacity-0 cursor-pointer"
                                    @change="const file = $event.target.files[0]; if (file) { photoPreview = URL.createObjectURL(file) }">
                            </div>
                            <div class="text-sm">
                                <p class="text-gray-900 font-bold mb-1 italic">Click or drag photo</p>
                                <p class="text-gray-500">JPG, PNG or WEBP (Max. 1MB)</p>
                            </div>
                        </div>
                        @error('photo') <p class="mt-2 text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Personal Information -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 italic">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" placeholder="Full Name"
                            class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        @error('name') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 italic">Email Address</label>
                        <input type="email" name="email" value="{{ old('email') }}" placeholder="email@example.com"
                            class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        @error('email') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 italic">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" placeholder="+62..."
                            class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        @error('phone') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 italic">Address</label>
                        <input type="text" name="address" value="{{ old('address') }}" placeholder="Current Address"
                            class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        @error('address') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <!-- Password Section -->
                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 italic">Password</label>
                        <input type="password" name="password" placeholder="Min. 8 characters"
                            class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                        @error('password') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>

                    <div class="space-y-2">
                        <label class="block text-sm font-bold text-gray-700 italic">Confirm Password</label>
                        <input type="password" name="password_confirmation" placeholder="Repeat Password"
                            class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium">
                    </div>

                    <div class="md:col-span-2 space-y-2">
                        <label class="block text-sm font-bold text-gray-700 italic">Bio (Optional)</label>
                        <textarea name="bio" rows="3" placeholder="Tell us something about this reseller..."
                            class="w-full px-5 py-3 rounded-xl border border-gray-200 focus:border-primary focus:ring-4 focus:ring-primary/10 outline-none transition-all font-medium resize-none">{{ old('bio') }}</textarea>
                        @error('bio') <p class="text-xs text-red-500 font-medium">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pb-12">
                <a href="{{ route('organizer.resellers.index') }}"
                    class="px-8 py-4 bg-white border border-gray-200 text-gray-600 font-bold rounded-xl hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-lg shadow-primary/25">
                    Register Reseller
                </button>
            </div>
        </form>
    </div>
</x-layouts.organizer>