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
                $entry = $this->normalizeCartEntry($product, $cart[$product->id] ?? null);

                $entry['product'] = $product;

                return $entry;
            });
    }

    protected function normalizeCartEntry(Product $product, array|int|null $entry): array
    {
        if (! is_array($entry)) {
            return [
                'quantity' => max(0, (int) $entry),
                'unit_price' => $product->price,
                'weight_in_kg' => $product->weight ?? 0,
                'weight_label' => $this->formatWeightLabel($product->weight ?? 0),
            ];
        }

        return [
            'quantity' => max(0, (int) ($entry['quantity'] ?? 0)),
            'unit_price' => isset($entry['unit_price']) ? (float) $entry['unit_price'] : $product->price,
            'weight_in_kg' => isset($entry['weight_in_kg']) ? (float) $entry['weight_in_kg'] : ($product->weight ?? 0),
            'weight_label' => $entry['weight_label'] ?? $this->formatWeightLabel($product->weight ?? 0),
        ];
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

    protected function formatWeightLabel(float $weight): string
    {
        if ($weight <= 0) {
            return '';
        }

        $formatted = number_format($weight, 2, ',', '.');
        $formatted = rtrim(rtrim($formatted, '0'), ',');

        return "{$formatted} kg";
    }
}
