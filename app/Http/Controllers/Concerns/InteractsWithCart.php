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

        if (empty($cart)) {
            return collect();
        }

        $products = Product::whereIn('id', collect($cart)
                ->pluck('product_id')
                ->filter()
                ->unique()
                ->all()
            )
            ->get()
            ->keyBy('id');

        return collect($cart)
            ->map(function (array $entry, string $entryKey) use ($products) {
                $product = $products->get($entry['product_id'] ?? null);

                if (! $product) {
                    return null;
                }

                return [
                    'entry_key' => $entryKey,
                    'product' => $product,
                    'quantity' => max(0, (int) ($entry['quantity'] ?? 0)),
                    'unit_price' => isset($entry['unit_price']) ? (float) $entry['unit_price'] : $product->price,
                    'weight_in_kg' => isset($entry['weight_in_kg']) ? (float) $entry['weight_in_kg'] : ($product->weight ?? 0),
                    'weight_label' => $entry['weight_label'] ?? $this->formatWeightLabel($product->weight ?? 0),
                ];
            })
            ->filter()
            ->values();
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
