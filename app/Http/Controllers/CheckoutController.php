<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\InteractsWithCart;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    use InteractsWithCart;

    public function index(Request $request): View|RedirectResponse
    {
        $cartItems = $this->loadCartItems($request);

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.cart.index')->with('error', __('Keranjang kamu masih kosong.'));
        }

        $cartQuantity = $cartItems->sum('quantity');
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item['product']->price * $item['quantity']);
        }, 0);

        return view('shop.checkout', compact('cartItems', 'cartQuantity', 'cartTotal'));
    }

    public function store(Request $request): RedirectResponse
    {
        $cartItems = $this->loadCartItems($request);

        if ($cartItems->isEmpty()) {
            return redirect()->route('shop.cart.index')->with('error', __('Keranjang kamu masih kosong.'));
        }

        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:40'],
            'customer_address' => ['required', 'string'],
            'notes' => ['nullable', 'string'],
            'payment_proof' => ['nullable', 'file', 'mimes:png,jpg,jpeg,pdf', 'max:2048'],
        ]);

        $total = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item['product']->price * $item['quantity']);
        }, 0);

        $paymentProofPath = $request->file('payment_proof')?->store('payment_proofs', 'public');

        $order = Order::create([
            'user_id' => $request->user()?->id,
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'] ?? null,
            'customer_address' => $validated['customer_address'],
            'notes' => $validated['notes'] ?? null,
            'total' => $total,
            'status' => Order::STATUS_PENDING,
            'payment_status' => 'pending',
            'payment_proof' => $paymentProofPath,
        ]);

        $items = $cartItems->map(function ($item) {
            $product = $item['product'];
            $quantity = $item['quantity'];

            if ($product->stock !== null && $quantity > 0) {
                $decrement = min($product->stock, $quantity);
                if ($decrement > 0) {
                    $product->decrement('stock', $decrement);
                }
            }

            return [
                'product_id' => $product->id,
                'product_name' => $product->name,
                'product_slug' => $product->slug,
                'unit_price' => $product->price,
                'quantity' => $quantity,
                'total' => $product->price * $quantity,
            ];
        });

        $order->items()->createMany($items->all());

        $request->session()->forget('cart');

        return redirect()->route('shop.checkout.index')->with('success', __('Pesanan kamu telah diterima.'));
    }
}