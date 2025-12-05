<?php

declare(strict_types=1);

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Http\Requests\HandlePaymentRequest;
use App\Models\Product;
use App\Services\Payment\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $service
    ){}

    public function index()
    {
        $products = Product::all();
        return view('payment.index', compact('products'));
    }

    public function handle_payment(HandlePaymentRequest $request)
    {
        $validated = $request->validated();
        $product = Product::find($validated['product']);

        $response = $this->service->processPayment($validated, $product->price);

        return redirect('payment')
            ->with('success', $response['message']);
    }
}
