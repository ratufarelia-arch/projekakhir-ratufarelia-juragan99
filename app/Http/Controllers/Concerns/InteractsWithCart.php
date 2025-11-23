<?php

namespace App\Http\Controllers\Concerns;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

trait InteractsWithCart
{
    protected function loadCartItems(Request $request): Collection
    {
        $cart = $request->session()->get('cart', []);
        $cartIds = array_keys($cart);

        if (empty($cartIds)) {
            return collect();
        }

        return Product::whereIn('id', $cartIds)
            ->get()
            ->map(function (Product $product) use ($cart) {
                return [
                    'product' => $product,
                    'quantity' => $cart[$product->id] ?? 0,
                ];
            });
    }

    protected function loadWishlistItems(Request $request): Collection
    {
        $wishlist = $request->session()->get('wishlist', []);
        $ids = array_keys($wishlist);

        if (empty($ids)) {
            return collect();
        }

        return Product::whereIn('id', $ids)
            ->orderByDesc('created_at')
            ->get();
    }
}
