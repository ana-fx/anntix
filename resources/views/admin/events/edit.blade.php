<x-layouts.admin>
    <div class="max-w-5xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Edit Event: {{ $event->name }}</h2>

        <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
            @csrf
            @method('PUT')

            <!-- 1. Banner & Thumbnail -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-2">Banner & Thumbnail</h3>

                <div class="space-y-6">
                    <!-- Banner -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload Banner</label>
                        @if($event->banner_path)
                            <div class="mb-4">
                                <img src="{{ Storage::url($event->banner_path) }}" class="w-full h-48 object-cover rounded-xl" alt="Current Banner">
                            </div>
                        @endif
                        <input type="file" name="banner" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" accept="image/*">
                        @error('banner') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <!-- Thumbnail -->
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Upload Thumbnail</label>
                         @if($event->thumbnail_path)
                            <div class="mb-4">
                                <img src="{{ Storage::url($event->thumbnail_path) }}" class="w-32 h-32 object-cover rounded-xl" alt="Current Thumbnail">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" accept="image/*">
                         @error('thumbnail') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- 2. Event Detail -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-2">Event Detail</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Event Name</label>
                        <input type="text" name="name" value="{{ old('name', $event->name) }}" placeholder="Enter Event Name" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                        @error('name') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Category</label>
                        <select name="category" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white">
                            <option value="Concert" @selected($event->category == 'Concert')>Concert</option>
                            <option value="Conference" @selected($event->category == 'Conference')>Conference</option>
                            <option value="Exhibition" @selected($event->category == 'Exhibition')>Exhibition</option>
                            <option value="Workshop" @selected($event->category == 'Workshop')>Workshop</option>
                        </select>
                        @error('category') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                        <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all bg-white">
                            <option value="draft" @selected($event->status == 'draft')>Draft</option>
                            <option value="published" @selected($event->status == 'published')>Published</option>
                            <option value="ended" @selected($event->status == 'ended')>Ended</option>
                        </select>
                         @error('status') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Start Date</label>
                        <input type="datetime-local" name="start_date" value="{{ old('start_date', $event->start_date->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                         @error('start_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">End Date</label>
                        <input type="datetime-local" name="end_date" value="{{ old('end_date', $event->end_date->format('Y-m-d\TH:i')) }}" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                         @error('end_date') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="4" placeholder="Enter Description" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">{{ old('description', $event->description) }}</textarea>
                         @error('description') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Term & Condition</label>
                        <textarea name="terms" rows="4" placeholder="Enter Term & Condition" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">{{ old('terms', $event->terms) }}</textarea>
                         @error('terms') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- 3. Event Location -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-2">Event Location</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-bold text-gray-700 mb-2">Location (Venue)</label>
                        <input type="text" name="location" value="{{ old('location', $event->location) }}" placeholder="Enter Location" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                         @error('location') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Province</label>
                        <input type="text" name="province" value="{{ old('province', $event->province) }}" placeholder="Enter Province" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                         @error('province') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">City</label>
                        <input type="text" name="city" value="{{ old('city', $event->city) }}" placeholder="Enter City" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                         @error('city') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">ZIP</label>
                        <input type="text" name="zip" value="{{ old('zip', $event->zip) }}" placeholder="Enter ZIP" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                         @error('zip') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                    </div>


                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Latitude</label>
                        <input type="text" name="latitude" value="{{ old('latitude', $event->latitude) }}" placeholder="Enter Latitude" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Longitude</label>
                        <input type="text" name="longitude" value="{{ old('longitude', $event->longitude) }}" placeholder="Enter Longitude" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                </div>
            </div>

            <!-- 4. Event Meta -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-2">Event Meta</h3>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">SEO Title</label>
                        <input type="text" name="seo_title" value="{{ old('seo_title', $event->seo_title) }}" placeholder="Enter SEO Title" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">SEO Description</label>
                        <textarea name="seo_description" rows="3" placeholder="Enter SEO Description" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">{{ old('seo_description', $event->seo_description) }}</textarea>
                    </div>
                </div>
            </div>

             <!-- 5. Event Organizer -->
             <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                <h3 class="text-lg font-bold text-gray-900 mb-6 border-b border-gray-100 pb-2">Event Organizer</h3>

                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Organizer Name</label>
                        <input type="text" name="organizer_name" value="{{ old('organizer_name', $event->organizer_name) }}" placeholder="Enter Organizer Name" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-primary focus:ring-2 focus:ring-primary/20 outline-none transition-all">
                    </div>
                     <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Organizer Photo</label>
                        @if($event->organizer_photo_path)
                            <div class="mb-4">
                                <img src="{{ Storage::url($event->organizer_photo_path) }}" class="w-16 h-16 rounded-full object-cover" alt="Current Organizer">
                            </div>
                        @endif
                        <input type="file" name="organizer_photo" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-primary/10 file:text-primary hover:file:bg-primary/20" accept="image/*">
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end pt-4 pb-12">
                 <button type="submit" class="px-8 py-4 bg-primary text-white font-bold rounded-xl hover:bg-primary-700 transition-colors shadow-lg shadow-primary/25 text-lg w-full md:w-auto">
                    Update Event
                </button>
            </div>

        </form>
    </div>
</x-layouts.admin>
