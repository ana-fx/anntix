<x-layouts.app>
    @push('scripts')
        <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
        <script>
            function scannerApp() {
                return {
                    selectedEventId: '',
                    manualCode: '',
                    isScanning: false,
                    html5QrCode: null,
                    scanResult: null,

                    async initScanner() {
                        // Check if HTTPS is being used
                        if (location.protocol !== 'https:' && location.hostname !== 'localhost' && location.hostname !== '127.0.0.1') {
                            alert("Camera access requires HTTPS. Please secure your connection or use 'localhost'.");
                            return;
                        }

                        this.html5QrCode = new Html5Qrcode("reader");
                        const config = { fps: 10, qrbox: { width: 250, height: 250 } };

                        try {
                            await this.html5QrCode.start(
                                { facingMode: "environment" },
                                config,
                                this.onScanSuccess.bind(this),
                                this.onScanFailure.bind(this)
                            );
                            this.isScanning = true;
                        } catch (err) {
                            console.error("Error starting scanner", err);
                            if (err.name === 'NotAllowedError') {
                                alert("Camera permission denied. Please allow camera access in your browser settings.");
                            } else if (err.name === 'NotFoundError') {
                                alert("No camera found associated with this device.");
                            } else {
                                alert("Could not start camera. Ensure you are using HTTPS and permissions are granted.\nError: " + err);
                            }
                        }
                    },

                    async stopScanner() {
                        if (this.html5QrCode && this.isScanning) {
                            await this.html5QrCode.stop();
                            this.isScanning = false;
                        }
                    },

                    toggleScanner() {
                        if (this.isScanning) {
                            this.stopScanner();
                        } else {
                            if (!this.selectedEventId) {
                                alert('Please select an event first.');
                                return;
                            }
                            this.initScanner();
                            this.scanResult = null;
                            this.manualCode = '';
                        }
                    },

                    onScanSuccess(decodedText, decodedResult) {
                        if (this.scanResult) return; // Prevent multiple scans
                        console.log(`Code scanned = ${decodedText}`, decodedResult);
                        this.verifyCode(decodedText);

                        // Optional: Stop scanning after success
                        this.stopScanner();
                    },

                    onScanFailure(error) {
                        // handle scan failure, usually better to ignore and keep scanning.
                        // console.warn(`Code scan error = ${error}`);
                    },

                    async verifyCode(code) {
                        if (!code) return;
                        if (!this.selectedEventId) {
                            alert('Please select an event first.');
                            return;
                        }

                        try {
                            const response = await fetch("{{ route('scanner.verify') }}", {
                                method: "POST",
                                headers: {
                                    "Content-Type": "application/json",
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                                },
                                body: JSON.stringify({
                                    code: code,
                                    event_id: this.selectedEventId
                                })
                            });

                            const result = await response.json();
                            this.scanResult = result;

                        } catch (error) {
                            console.error("Verification error:", error);
                            this.scanResult = {
                                status: 'error',
                                message: 'Network or server error occurred.'
                            };
                        }
                    },

                    resetScan() {
                        this.scanResult = null;
                        this.manualCode = '';
                        // restart scanner if needed
                        this.initScanner();
                    }
                }
            }
        </script>
    @endpush

    <div class="bg-gray-50 min-h-screen pb-20 pt-10" x-data="scannerApp()">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Header Section -->
            <div class="mb-8 md:flex md:items-center md:justify-between">
                <div class="min-w-0 flex-1">
                    <h2 class="text-3xl font-heading font-bold text-dark sm:truncate sm:text-4xl sm:tracking-tight">
                        Scanner Dashboard
                    </h2>
                    <p class="mt-2 text-lg text-secondary">
                        Welcome back, {{ Auth::user()->name }}
                    </p>
                </div>
                <div class="mt-4 flex md:ml-4 md:mt-0">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="inline-flex items-center rounded-xl bg-white px-4 py-2 text-sm font-bold text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            Logout
                        </button>
                    </form>
                </div>
            </div>

            <!-- Event Selection -->
            <div class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 p-8 mb-8 border border-gray-100">
                <label for="event" class="block text-sm font-bold text-secondary uppercase tracking-wider mb-2">Select
                    Active Event</label>
                <div class="relative">
                    <select x-model="selectedEventId" @change="stopScanner()" id="event"
                        class="block w-full rounded-xl border-0 py-4 pl-4 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-lg sm:leading-6 bg-gray-50">
                        <option value="">-- Choose an Event to Scan --</option>
                        @foreach($events as $event)
                            <option value="{{ $event->id }}">{{ $event->name }} ({{ $event->start_date->format('d M Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Scanner Interface -->
            <div x-show="selectedEventId" x-transition class="grid grid-cols-1 lg:grid-cols-2 gap-8">

                <!-- Camera Section -->
                <div class="space-y-6">
                    <div
                        class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 overflow-hidden border border-gray-100">
                        <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                            <h3 class="font-heading font-bold text-xl text-dark">Camera Access</h3>
                            <button @click="toggleScanner()"
                                class="inline-flex items-center gap-2 px-4 py-2 bg-primary text-white text-sm font-bold rounded-xl hover:bg-primary/90 transition shadow-lg shadow-primary/20"
                                :class="isScanning ? 'bg-red-500 hover:bg-red-600 shadow-red-500/20' : ''">
                                <span x-text="isScanning ? 'Stop Camera' : 'Start Camera'"></span>
                            </button>
                        </div>

                        <div class="p-6">
                            <div id="reader" class="rounded-2xl overflow-hidden bg-black w-full shadow-inner"
                                style="min-height: 300px;"></div>

                            <div class="relative mt-8">
                                <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                    <div class="w-full border-t border-gray-200"></div>
                                </div>
                                <div class="relative flex justify-center">
                                    <span
                                        class="bg-white px-3 text-sm font-bold text-gray-400 uppercase tracking-wider">Or</span>
                                </div>
                            </div>

                            <div class="mt-6">
                                <form @submit.prevent="verifyCode(manualCode)" class="flex gap-3">
                                    <input type="text" x-model="manualCode" placeholder="Enter ticket code manually..."
                                        class="block w-full rounded-xl border-0 py-3 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-primary sm:text-sm sm:leading-6">
                                    <button type="submit"
                                        class="px-6 py-3 bg-dark text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg">
                                        Check
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Result Section -->
                <div
                    class="bg-white rounded-3xl shadow-xl shadow-blue-900/5 overflow-hidden border border-gray-100 flex flex-col min-h-[400px]">

                    <!-- Empty State -->
                    <div x-show="!scanResult" class="flex-1 flex flex-col items-center justify-center p-8 text-center">
                        <div class="w-24 h-24 bg-gray-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 17h.01M8 11h16M12 5l7 7-7 7M5 5l-7 7 7 7">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-dark mb-2">Ready to Scan</h3>
                        <p class="text-secondary max-w-xs">Use the camera or enter a code to verify ticket details.</p>
                    </div>

                    <!-- Result Data -->
                    <div x-show="scanResult" style="display: none;" class="flex-1 flex flex-col">

                        <!-- Header -->
                        <div class="p-8 text-center flex-1 flex flex-col items-center justify-center"
                            :class="scanResult?.status === 'success' ? 'bg-green-50/50' : 'bg-red-50/50'">

                            <div class="w-24 h-24 rounded-full flex items-center justify-center mb-6 shadow-sm"
                                :class="scanResult?.status === 'success' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600'">
                                <svg x-show="scanResult?.status === 'success'" class="w-12 h-12" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                                <svg x-show="scanResult?.status === 'error'" class="w-12 h-12" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </div>

                            <h3 class="text-3xl font-heading font-bold mb-2"
                                :class="scanResult?.status === 'success' ? 'text-green-700' : 'text-red-700'"
                                x-text="scanResult?.status === 'success' ? 'Valid Ticket' : 'Scan Failed'">
                            </h3>
                            <p class="font-medium text-lg"
                                :class="scanResult?.status === 'success' ? 'text-green-600' : 'text-red-600'"
                                x-text="scanResult?.message">
                            </p>
                        </div>

                        <!-- Ticket Details (Only on success) -->
                        <div class="p-8 bg-white border-t border-gray-100" x-show="scanResult?.data">
                            <div class="space-y-4">
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-secondary">Owner Name</span>
                                    <span class="font-bold text-dark text-lg" x-text="scanResult?.data?.name"></span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-secondary">Ticket Type</span>
                                    <span class="font-bold text-primary text-lg"
                                        x-text="scanResult?.data?.ticket_type"></span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-50">
                                    <span class="text-secondary">Quantity</span>
                                    <span class="font-bold text-dark text-lg"
                                        x-text="scanResult?.data?.quantity"></span>
                                </div>
                                <div class="flex justify-between items-center py-2">
                                    <span class="text-secondary">Email</span>
                                    <span class="font-medium text-dark" x-text="scanResult?.data?.email"></span>
                                </div>
                            </div>

                            <button @click="resetScan()"
                                class="mt-8 w-full py-4 bg-gray-100 text-dark font-bold rounded-xl hover:bg-gray-200 transition">
                                Scan Next Ticket
                            </button>
                        </div>

                        <!-- Error Reset (Only on error) -->
                        <div class="p-8 bg-white border-t border-gray-100" x-show="scanResult?.status === 'error'">
                            <button @click="resetScan()"
                                class="w-full py-4 bg-dark text-white font-bold rounded-xl hover:bg-gray-800 transition shadow-lg">
                                Try Again
                            </button>
                        </div>

                    </div>
                </div>

            </div>

        </div>
    </div>
</x-layouts.app>