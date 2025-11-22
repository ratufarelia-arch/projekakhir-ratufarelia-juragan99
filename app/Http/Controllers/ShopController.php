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
        $minPrice = $request->input('min_price');
        $maxPrice = $request->input('max_price');

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
            ->when(is_numeric($minPrice), function ($query, $value) {
                $query->where('price', '>=', $value);
            })
            ->when(is_numeric($maxPrice), function ($query, $value) {
                $query->where('price', '<=', $value);
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

        $cartItems = $this->loadCartItems($request);
        $cartQuantity = $cartItems->sum('quantity');
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item['product']->price * $item['quantity']);
        }, 0);

        $wishlistItems = $this->loadWishlistItems($request);
        $wishlistCount = $wishlistItems->count();
        $wishlistIds = $wishlistItems->pluck('id')->all();
 
        return view('shop.index', compact(
            'products',
            'categories',
            'cutTypes',
            'cartItems',
            'cartQuantity',
            'cartTotal',
            'wishlistItems',
            'wishlistCount',
            'wishlistIds',
            'search',
            'category',
            'cutType',
            'minPrice',
            'maxPrice'
        ));
    }

    public function showProducts(Request $request): View
    {
        $search = $request->input('search');
        $category = $request->input('category');
        $cutType = $request->input('cut_type');

        $products = Product::query()
            ->where('is_active', true)
            ->when($category, fn ($query) => $query->where('category', $category))
            ->when($cutType, fn ($query) => $query->where('cut_type', $cutType))
            ->when($search, fn ($query) => $query->where(function ($query) use ($search) {
                $term = '%' . str_replace('%', '\\%', $search) . '%';
                $query->where('name', 'like', $term)
                    ->orWhere('description', 'like', $term);
            }))
            ->orderByDesc('created_at')
            ->paginate(18)
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

        $cartItems = $this->loadCartItems($request);
        $cartQuantity = $cartItems->sum('quantity');
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item['product']->price * $item['quantity']);
        }, 0);

        $wishlistItems = $this->loadWishlistItems($request);
        $wishlistCount = $wishlistItems->count();
        $wishlistIds = $wishlistItems->pluck('id')->all();

        return view('shop.products', compact(
            'products',
            'categories',
            'cutTypes',
            'cartItems',
            'cartQuantity',
            'cartTotal',
            'wishlistItems',
            'wishlistCount',
            'wishlistIds',
            'category',
            'cutType',
            'search'
        ));
    }

    public function showCart(Request $request): View
    {
        $cartItems = $this->loadCartItems($request);
        $cartQuantity = $cartItems->sum('quantity');
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            return $carry + ($item['product']->price * $item['quantity']);
        }, 0);

        return view('shop.cart', compact('cartItems', 'cartQuantity', 'cartTotal'));
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

    public function updateCart(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
        ]);

        $cart = $request->session()->get('cart', []);

        if ($data['quantity'] <= 0) {
            unset($cart[$product->id]);
        } else {
            $cart[$product->id] = $data['quantity'];
        }

        $request->session()->put('cart', $cart);
 
        return back()->with('success', __('Updated cart quantities.'));
    }
 
    public function addToWishlist(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
        ]);

        $wishlist = $request->session()->get('wishlist', []);
        $wishlist[$data['product_id']] = true;
        $request->session()->put('wishlist', $wishlist);

        return back()->with('success', __('Added to wishlist.'));
    }

    public function removeFromWishlist(Request $request, Product $product): RedirectResponse
    {
        $wishlist = $request->session()->get('wishlist', []);
        if (isset($wishlist[$product->id])) {
            unset($wishlist[$product->id]);
            $request->session()->put('wishlist', $wishlist);
        }

        return back()->with('success', __('Removed from wishlist.'));
    }

    public function showWishlist(Request $request): View
    {
        $wishlisted = $this->loadWishlistItems($request);

        return view('shop.wishlist', ['wishlistItems' => $wishlisted]);
    }
 
    private function loadCartItems(Request $request)
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

    private function loadWishlistItems(Request $request)
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
