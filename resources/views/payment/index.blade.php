@php use App\Services\Payment\Enums\PaymentGateway; @endphp
    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Payment</title>
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


    <!-- Main Content -->
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">

        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">

                <!-- Form Header -->
                <div class="bg-gradient-to-r from-indigo-600 to-violet-600 px-8 py-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Select Product to pay</h2>
                    <p class="text-indigo-100 text-sm">Check rge products, and choose the payment gateway you want to
                        use.
                    </p>
                </div>


                @if (session('success'))
                    <div class="bg-green-50 border-l-4 border-green-500 p-4 m-8 mb-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                          clip-rule="evenodd"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm leading-5 font-medium text-green-800">
                                    {{ session('success') }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 m-8 mb-0">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                          d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                          clip-rule="evenodd"/>
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

                <form action="{{ route('payment.handle') }}" method="GET" class="p-8 space-y-8">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <span
                                    class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">1</span>
                            Product
                        </h3>
                        <div class="pl-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                            @foreach($products as $product)
                                <label
                                    class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                    <input type="radio" name="product" value="{{ $product->id }}"
                                           class="form-radio text-indigo-600 focus:ring-indigo-500">
                                    <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">{{ $product->name }} (${{ $product->price }})</span>
                                </label>
                            @endforeach
                        </div>
                    </div>


                    <hr class="border-gray-100">
                    <div class="space-y-4">
                        <h3 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                                <span
                                    class="flex items-center justify-center w-6 h-6 rounded-full bg-indigo-100 text-indigo-600 text-xs font-bold">2</span>
                            Payment Gatway
                        </h3>
                        <div class="pl-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                            <label
                                class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                <input type="radio" name="gateway" value="{{ PaymentGateway::PAYPAL }}"
                                       class="form-radio text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Paypal</span>
                            </label>

                            <label
                                class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                <input type="radio" name="gateway" value="{{ PaymentGateway::STRIPE }}"
                                       class="form-radio text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Stripe</span>
                            </label>

                            <label
                                class="inline-flex items-center p-3 rounded-lg border border-gray-200 hover:border-indigo-300 hover:bg-indigo-50 cursor-pointer transition-all duration-200 group">
                                <input type="radio" name="gateway" value="{{ PaymentGateway::BANK_TRANSFER }}"
                                       class="form-radio text-indigo-600 focus:ring-indigo-500">
                                <span class="ml-2 text-sm text-gray-700 group-hover:text-indigo-700">Bank transfer</span>
                            </label>
                        </div>
                    </div>

                    <hr class="border-gray-100">
            </div>

            <!-- Action Buttons -->
            <div class="pt-6 flex items-center justify-end gap-4">
                <button type="submit"
                        class="px-8 py-3 rounded-xl bg-indigo-600 text-white font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:shadow-indigo-300 transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-2">
                    Pay
                </button>
            </div>

            </form>
        </div>

        <p class="text-center text-gray-400 text-sm mt-8">&copy; 2025 Analytics Co. All rights reserved.</p>
</div>
</main>
</body>

</html>
