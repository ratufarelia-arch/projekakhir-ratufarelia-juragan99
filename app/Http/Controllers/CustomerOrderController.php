<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CustomerOrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = Order::where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('shop.orders.index', compact('orders'));
    }

    public function show(Request $request, Order $order): View
    {
        $this->authorizeOrder($order, $request);

        $order->load('items');

        return view('shop.orders.show', compact('order'));
    }

    protected function authorizeOrder(Order $order, Request $request): void
    {
        if ($order->user_id !== $request->user()->id) {
            abort(403);
        }
    }
}
