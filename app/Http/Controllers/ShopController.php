<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShopController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $cutType = $request->input('cut_type');

        $products = Product::query()
            ->when($search, function ($query, $value) {
                $term = '%' . str_replace('%', '\\%', $value) . '%';
                $query->where(function ($query) use ($term) {
                    $query->where('name', 'like', $term)
                        ->orWhere('description', 'like', $term);
                });
            })
            ->when($category, function ($query, $value) {
                $query->where('category', $value);
            })
            ->when($cutType, function ($query, $value) {
                $query->where('cut_type', $value);
            })
            ->where('is_active', true)
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        $categories = Product::query()
            ->whereNotNull('category')
            ->where('category', '<>', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');

        $cutTypes = Product::query()
            ->whereNotNull('cut_type')
            ->where('cut_type', '<>', '')
            ->distinct()
            ->orderBy('cut_type')
            ->pluck('cut_type');

        $cart = $request->session()->get('cart', []);
        $cartIds = array_keys($cart);

        $cartItems = collect();
        if (! empty($cartIds)) {
            $cartItems = Product::whereIn('id', $cartIds)
                ->get()
                ->map(function (Product $product) use ($cart) {
                    return [
                        'product' => $product,
                        'quantity' => $cart[$product->id] ?? 0,
                    ];
                });
        }

        $cartQuantity = $cartItems->sum('quantity');
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item['product']->price * $item['quantity']);
        }, 0);

        return view('shop.index', compact(
            'products',
            'categories',
            'cutTypes',
            'cartItems',
            'cartQuantity',
            'cartTotal',
            'search',
            'category',
            'cutType'
        ));
    }

    public function addToCart(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);

        $quantity = $data['quantity'] ?? 1;
        $cart = $request->session()->get('cart', []);
        $cart[$data['product_id']] = ($cart[$data['product_id']] ?? 0) + $quantity;
        $request->session()->put('cart', $cart);

        return back()->with('success', __('Product added to cart.'));
    }

    public function removeFromCart(Request $request, Product $product): RedirectResponse
    {
        $cart = $request->session()->get('cart', []);
        if (isset($cart[$product->id])) {
            unset($cart[$product->id]);
            $request->session()->put('cart', $cart);
        }

        return back()->with('success', __('Removed from cart.'));
    }
}
