<x-layouts.admin>
    <div class="max-w-4xl mx-auto">
        <h2 class="text-3xl font-bold text-gray-900 mb-8">Settings</h2>

        <div class="space-y-6">

            <!-- General Settings -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="font-bold text-gray-900">Application Preferences</h3>
                </div>
                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="font-medium text-gray-900">Email Notifications</h4>
                            <p class="text-sm text-gray-500">Receive emails about new events and ticket sales.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer" checked>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <div>
                            <h4 class="font-medium text-gray-900">Dark Mode</h4>
                            <p class="text-sm text-gray-500">Enable dark theme for the admin panel.</p>
                        </div>
                         <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" class="sr-only peer">
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-primary/20 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Danger Zone (Stub) -->
            <div class="bg-white rounded-2xl shadow-sm border border-red-100 overflow-hidden">
                 <div class="px-6 py-4 border-b border-red-50 bg-red-50/30">
                    <h3 class="font-bold text-red-600">Danger Zone</h3>
                </div>
                <div class="p-6">
                    <p class="text-sm text-gray-600 mb-4">Actions here can have destructive effects.</p>
                    <button class="px-4 py-2 border border-red-200 text-red-600 rounded-lg hover:bg-red-50 transition-colors text-sm font-bold">
                        Delete Account
                    </button>
                </div>
            </div>

        </div>
    </div>
</x-layouts.admin>
