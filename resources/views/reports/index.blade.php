<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Report Generation</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 antialiased">

    <div class="min-h-screen flex flex-col">
        <!-- Header -->
        <header class="bg-white shadow-sm z-10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="bg-indigo-600 p-2 rounded-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h1 class="text-xl font-bold text-gray-900 tracking-tight">Analytics Reports</h1>
                </div>
                <div class="flex items-center gap-2">

                    <div
                        class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold border border-indigo-200 ml-2">
                        A</div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">

            <div class="max-w-4xl mx-auto">
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

                    <!-- Form Header -->
                    <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-6">
                        <h2 class="text-2xl font-bold text-white mb-2">Generate New Report</h2>
                        <p class="text-indigo-100 text-sm">Customize your data export by selecting the parameters below.
                        </p>
                    </div>



                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 m-8 mb-0">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm leading-5 font-medium text-red-800">
                                        There were errors with your submission
                                    </h3>
                                    <div class="mt-2 text-sm leading-5 text-red-700">
                                        <ul class="list-disc pl-5 space-y-1">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('reports.generate') }}" method="GET" class="p-8 space-y-8">

                        <!-- Section 0: Report Type -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <span
                                    class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">1</span>
                                Report Type
                            </h3>
                            <div class="pl-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                                <label
                                    class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                    <input type="radio" name="report_type" value="sales"
                                        class="form-radio text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Sales
                                        Report</span>
                                </label>
                                <label
                                    class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                    <input type="radio" name="report_type" value="marketing"
                                        class="form-radio text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Marketing
                                        Report</span>
                                </label>
                                <label
                                    class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                    <input type="radio" name="report_type" value="analytics"
                                        class="form-radio text-indigo-600 focus:ring-indigo-500" checked>
                                    <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Analytics
                                        Report</span>
                                </label>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Section 1: Date Range -->
                        <div class="space-y-4">
                            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <span
                                        class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">2</span>
                                    Date Range
                                </h3>
                                <!-- Quick Select Chips -->
                                <div class="flex flex-wrap gap-2">
                                    <button type="button" onclick="setDateRange('today')"
                                        class="px-3 py-1 text-xs font-medium rounded-full border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 cursor-pointer transition-colors">Today</button>
                                    <button type="button" onclick="setDateRange('yesterday')"
                                        class="px-3 py-1 text-xs font-medium rounded-full border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 cursor-pointer transition-colors">Yesterday</button>
                                    <button type="button" onclick="setDateRange('last7')"
                                        class="px-3 py-1 text-xs font-medium rounded-full border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 cursor-pointer transition-colors">Last
                                        7 Days</button>
                                    <button type="button" onclick="setDateRange('last30')"
                                        class="px-3 py-1 text-xs font-medium rounded-full border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 cursor-pointer transition-colors">Last
                                        30 Days</button>
                                    <button type="button" onclick="setDateRange('thisMonth')"
                                        class="px-3 py-1 text-xs font-medium rounded-full border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 cursor-pointer transition-colors">This
                                        Month</button>
                                    <button type="button" onclick="setDateRange('lastMonth')"
                                        class="px-3 py-1 text-xs font-medium rounded-full border border-gray-200 text-gray-600 hover:border-indigo-300 hover:text-indigo-600 hover:bg-indigo-50 cursor-pointer transition-colors">Last
                                        Month</button>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pl-8">
                                <div>
                                    <label for="start_date" class="block text-sm font-medium text-gray-700 mb-1">Start
                                        Date</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="date" name="start_date" id="start_date"
                                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                                    </div>
                                </div>
                                <div>
                                    <label for="end_date" class="block text-sm font-medium text-gray-700 mb-1">End
                                        Date</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="date" name="end_date" id="end_date"
                                            class="w-full pl-10 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 transition-all duration-200 bg-gray-50 hover:bg-white">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Section 2: Columns -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <span
                                    class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">3</span>
                                Select Columns
                            </h3>
                            <div class="pl-8 grid grid-cols-2 md:grid-cols-4 gap-4">
                                <label
                                    class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                    <input type="checkbox" name="columns[]" value="event_type"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Event
                                        Type</span>
                                </label>
                                <label
                                    class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                    <input type="checkbox" name="columns[]" value="value"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Value</span>
                                </label>
                                <label
                                    class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                    <input type="checkbox" name="columns[]" value="created_at"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Date</span>
                                </label>
                                <label
                                    class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                    <input type="checkbox" name="columns[]" value="metadata"
                                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                    <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Metadata</span>
                                </label>
                            </div>
                        </div>

                        <hr class="border-gray-100">

                        <!-- Section 3: Filters & Format -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Filters -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <span
                                        class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">4</span>
                                    Filters
                                </h3>
                                <div class="pl-8 space-y-3">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Value</label>
                                        <input type="number" name="filters[min_value]" placeholder="e.g. 100"
                                            class="w-full rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 bg-gray-50">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Event Type</label>
                                        <div class="grid grid-cols-2 gap-3">
                                            <label
                                                class="inline-flex items-center p-2 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                                <input type="radio" name="filters[event_type]" value=""
                                                    class="form-radio text-indigo-600 focus:ring-indigo-500" checked>
                                                <span
                                                    class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">All</span>
                                            </label>
                                            <label
                                                class="inline-flex items-center p-2 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                                <input type="radio" name="filters[event_type]" value="purchase"
                                                    class="form-radio text-indigo-600 focus:ring-indigo-500">
                                                <span
                                                    class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Purchase</span>
                                            </label>
                                            <label
                                                class="inline-flex items-center p-2 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                                <input type="radio" name="filters[event_type]" value="signup"
                                                    class="form-radio text-indigo-600 focus:ring-indigo-500">
                                                <span
                                                    class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Sign
                                                    Up</span>
                                            </label>
                                            <label
                                                class="inline-flex items-center p-2 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                                <input type="radio" name="filters[event_type]" value="view"
                                                    class="form-radio text-indigo-600 focus:ring-indigo-500">
                                                <span
                                                    class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">View</span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Format & Save -->
                            <div class="space-y-4">
                                <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                    <span
                                        class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">5</span>
                                    Output Format
                                </h3>

                                <div class="pt-4 border-t border-gray-100">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Format</label>
                                    <div class="grid grid-cols-3 gap-3">
                                        <label
                                            class="inline-flex items-center justify-center p-2 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                            <input type="radio" name="format" value="csv"
                                                class="form-radio text-indigo-600 focus:ring-indigo-500" checked>
                                            <span
                                                class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">CSV</span>
                                        </label>
                                        <label
                                            class="inline-flex items-center justify-center p-2 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                            <input type="radio" name="format" value="xlsx"
                                                class="form-radio text-indigo-600 focus:ring-indigo-500">
                                            <span
                                                class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Excel</span>
                                        </label>
                                        <label
                                            class="inline-flex items-center justify-center p-2 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                            <input type="radio" name="format" value="pdf"
                                                class="form-radio text-indigo-600 focus:ring-indigo-500">
                                            <span
                                                class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">PDF</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="pt-4 border-t border-gray-100">
                                    <label
                                        class="flex items-center gap-3 p-3 rounded-lg border border-dashed border-gray-300 hover:border-indigo-400 hover:bg-indigo-50 cursor-pointer transition-all">
                                        <input type="checkbox" name="save_template"
                                            class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                        <span class="text-sm font-medium text-gray-700">Save as Template</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                </div>

                <!-- Action Buttons -->
                <div class="pt-6 flex items-center justify-end gap-4">
                    <button type="button" onclick="openModal('recent')"
                        class="px-4 py-3 rounded-xl text-gray-600 font-medium hover:bg-gray-100 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Recent Exports
                    </button>
                    <button type="button" onclick="openModal('templates')"
                        class="px-4 py-3 rounded-xl text-gray-600 font-medium hover:bg-gray-100 transition-colors flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                            </path>
                        </svg>
                        Templates
                    </button>

                    <button type="submit"
                        class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Generate Report
                    </button>
                </div>

                </form>
            </div>

            <p class="text-center text-gray-400 text-sm mt-8">&copy; 2025 Analytics Co. All rights reserved.</p>
    </div>
    </main>



    <!-- New Modal -->
    <div id="modal" class="fixed inset-0 z-50 hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop -->
        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-[2px] transition-opacity opacity-0" id="modal-backdrop"
            onclick="closeModal()"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-center justify-center p-4 text-center">
                <div class="relative transform overflow-hidden rounded-xl bg-white text-left shadow-xl transition-all w-full max-w-md opacity-0 scale-95"
                    id="modal-panel">

                    <!-- Header -->
                    <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                        <h3 class="text-base font-semibold text-gray-900" id="modal-title">
                            Modal Title
                        </h3>
                        <button type="button"
                            class="text-gray-400 hover:text-gray-500 focus:outline-none transition-colors"
                            onclick="closeModal()">
                            <span class="sr-only">Close</span>
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>

                    <!-- Content -->
                    <div class="px-5 py-4 max-h-[60vh] overflow-y-auto" id="modal-content">
                        <!-- Dynamic Content -->
                    </div>

                    <!-- Footer -->
                    <div class="px-5 py-3 bg-gray-50/50 flex flex-row-reverse border-t border-gray-100">
                        <button type="button"
                            class="inline-flex w-full justify-center rounded-lg bg-white px-3 py-2 text-sm font-medium text-gray-700 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 sm:w-auto transition-all"
                            onclick="closeModal()">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(type) {
            const modal = document.getElementById('modal');
            const backdrop = document.getElementById('modal-backdrop');
            const panel = document.getElementById('modal-panel');
            const title = document.getElementById('modal-title');
            const content = document.getElementById('modal-content');

            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';

            // Animation in
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'scale-95');
                panel.classList.add('opacity-100', 'scale-100');
            });

            if (type === 'recent') {
                title.textContent = 'Recent Exports';
                fetchRecentExports(content);
            } else if (type === 'templates') {
                title.textContent = 'Saved Templates';
                fetchTemplates(1, content);
            }
        }


        @if(session('success'))
            document.addEventListener('DOMContentLoaded', () => {
                setTimeout(() => openModal('recent'), 500);
            });
        @endif

            function closeModal() {
                const modal = document.getElementById('modal');
                const backdrop = document.getElementById('modal-backdrop');
                const panel = document.getElementById('modal-panel');

                // Animation out
                backdrop.classList.add('opacity-0');
                panel.classList.remove('opacity-100', 'scale-100');
                panel.classList.add('opacity-0', 'scale-95');

                setTimeout(() => {
                    modal.classList.add('hidden');
                    document.body.style.overflow = '';
                }, 200); // Faster transition
            }

        function fetchRecentExports(container) {
            container.innerHTML = '<div class="text-center py-4 text-gray-500">Loading...</div>';

            fetch('{{ route("reports.recent") }}')
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = '';
                    if (data.length === 0) {
                        container.innerHTML = '<div class="text-center py-4 text-gray-500">No recent exports found.</div>';
                        return;
                    }

                    const list = document.createElement('div');
                    list.className = 'space-y-3';

                    data.forEach(report => {
                        const el = document.createElement('div');
                        el.className = 'p-3 border rounded-lg flex justify-between items-center';

                        let statusColor = 'text-yellow-600';
                        if (report.status === 'completed') statusColor = 'text-green-600';
                        if (report.status === 'failed') statusColor = 'text-red-600';

                        el.innerHTML = `
                            <div>
                                <div class="font-medium text-gray-900 uppercase">${report.format} Report</div>
                                <div class="text-xs text-gray-500">${new Date(report.created_at).toLocaleString()}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-xs font-bold uppercase ${statusColor}">${report.status}</span>
                                ${report.status === 'completed' ? `<a href="/reports/download/${report.id}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">Download</a>` : ''}
                            </div>
                        `;
                        list.appendChild(el);
                    });
                    container.appendChild(list);
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.innerHTML = '<div class="text-center py-4 text-red-500">Error loading exports.</div>';
                });
        }

        function fetchTemplates(page, container) {
            container.innerHTML = '<div class="text-center py-4 text-gray-500">Loading...</div>';

            fetch(`{{ route('reports.templates') }}?page=${page}`)
                .then(response => response.json())
                .then(data => {
                    container.innerHTML = '';
                    if (data.data.length === 0) {
                        container.innerHTML = '<div class="text-center py-4 text-gray-500">No templates found.</div>';
                        return;
                    }

                    const list = document.createElement('div');
                    list.className = 'space-y-3';

                    data.data.forEach(template => {
                        const el = document.createElement('div');
                        el.className = 'p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition-colors flex justify-between items-center group';
                        el.onclick = () => loadTemplate(template);
                        el.innerHTML = `
                            <div>
                                <div class="font-medium text-gray-900">${template.name}</div>
                                <div class="text-xs text-gray-500">${template.report_type} - ${new Date(template.created_at).toLocaleDateString()}</div>
                            </div>
                            <div class="text-indigo-600 opacity-0 group-hover:opacity-100 text-sm font-medium">Apply &rarr;</div>
                        `;
                        list.appendChild(el);
                    });
                    container.appendChild(list);

                    // Pagination
                    const pagination = document.createElement('div');
                    pagination.className = 'mt-4 flex justify-between items-center text-sm text-gray-600';

                    let paginationHtml = '';
                    if (data.prev_page_url) {
                        paginationHtml += `<button onclick="fetchTemplates(${page - 1})" class="text-indigo-600 hover:text-indigo-800">Previous</button>`;
                    } else {
                        paginationHtml += `<span class="text-gray-400">Previous</span>`;
                    }

                    paginationHtml += `<span class="mx-2">Page ${data.current_page} of ${data.last_page}</span>`;

                    if (data.next_page_url) {
                        paginationHtml += `<button onclick="fetchTemplates(${page + 1})" class="text-indigo-600 hover:text-indigo-800">Next</button>`;
                    } else {
                        paginationHtml += `<span class="text-gray-400">Next</span>`;
                    }
                    pagination.innerHTML = paginationHtml;
                    container.appendChild(pagination);
                })
                .catch(error => {
                    console.error('Error:', error);
                    container.innerHTML = '<div class="text-center py-4 text-red-500">Error loading templates.</div>';
                });
        }

        function loadTemplate(template) {
            const config = template.configuration;

            // 1. Report Type
            if (template.report_type) {
                const radio = document.querySelector(`input[name="report_type"][value="${template.report_type}"]`);
                if (radio) radio.checked = true;
            }

            // 2. Date Range
            if (config.start_date) document.getElementById('start_date').value = config.start_date;
            if (config.end_date) document.getElementById('end_date').value = config.end_date;

            // 3. Columns
            document.querySelectorAll('input[name="columns[]"]').forEach(cb => cb.checked = false);
            if (config.columns && Array.isArray(config.columns)) {
                config.columns.forEach(col => {
                    const cb = document.querySelector(`input[name="columns[]"][value="${col}"]`);
                    if (cb) cb.checked = true;
                });
            }

            // 4. Filters
            if (config.filters) {
                if (config.filters.min_value) {
                    document.querySelector('input[name="filters[min_value]"]').value = config.filters.min_value;
                }
                if (config.filters.event_type) {
                    const radio = document.querySelector(`input[name="filters[event_type]"][value="${config.filters.event_type}"]`);
                    if (radio) radio.checked = true;
                }
            }

            closeModal();
        }

        function setDateRange(range) {
            const today = new Date();
            let start = new Date();
            let end = new Date();

            switch (range) {
                case 'today':
                    break;
                case 'yesterday':
                    start.setDate(today.getDate() - 1);
                    end.setDate(today.getDate() - 1);
                    break;
                case 'last7':
                    start.setDate(today.getDate() - 6);
                    break;
                case 'last30':
                    start.setDate(today.getDate() - 29);
                    break;
                case 'thisMonth':
                    start = new Date(today.getFullYear(), today.getMonth(), 1);
                    break;
                case 'lastMonth':
                    start = new Date(today.getFullYear(), today.getMonth() - 1, 1);
                    end = new Date(today.getFullYear(), today.getMonth(), 0);
                    break;
            }

            // Format dates as YYYY-MM-DD
            const formatDate = (date) => {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            };

            document.getElementById('start_date').value = formatDate(start);
            document.getElementById('end_date').value = formatDate(end);
        }

        @if(session('report_id'))
            document.addEventListener('DOMContentLoaded', () => {
                const reportId = "{{ session('report_id') }}";
                let attempts = 0;
                const maxAttempts = 60; // Stop after 5 minutes (5s * 60)

                const pollInterval = setInterval(() => {
                    attempts++;
                    if (attempts > maxAttempts) {
                        clearInterval(pollInterval);
                        return;
                    }

                    fetch('{{ route("reports.recent") }}')
                        .then(response => response.json())
                        .then(reports => {
                            const report = reports.find(r => r.id === reportId);
                            if (report && report.status === 'completed') {
                                clearInterval(pollInterval);
                                window.location.href = '/reports/download/' + reportId;
                            } else if (report && report.status === 'failed') {
                                clearInterval(pollInterval);
                                alert('Report generation failed.');
                            }
                        });
                }, 5000);
            });
        @endif
    </script>

</body>

</html>