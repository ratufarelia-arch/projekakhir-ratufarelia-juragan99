<?php

namespace App\Http\Controllers;

use App\Models\Cut;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Concerns\InteractsWithCart;

class ShopController extends Controller
{
    use InteractsWithCart;
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

        $cutTypes = Cut::orderBy('name')->get();

        $reviews = Review::with('user')
            ->whereHas('order', fn ($query) => $query->where('status', Order::STATUS_COMPLETED))
            ->latest()
            ->take(12)
            ->get();

        $cartItems = $this->loadCartItems($request);
        $cartQuantity = $cartItems->sum('quantity');
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            $unitPrice = $item['unit_price'] ?? $item['product']->price;
            return $carry + ($unitPrice * $item['quantity']);
        }, 0);

        $wishlistItems = $this->loadWishlistItems($request);
        $wishlistCount = $wishlistItems->count();
        $wishlistIds = $wishlistItems->pluck('id')->all();
 
        return view('shop.index', compact(
            'products',
            'reviews',
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

        $cutTypes = Cut::orderBy('name')->get();

        $cartItems = $this->loadCartItems($request);
        $cartQuantity = $cartItems->sum('quantity');
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            $unitPrice = $item['unit_price'] ?? $item['product']->price;
            return $carry + ($unitPrice * $item['quantity']);
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
            $unitPrice = $item['unit_price'] ?? $item['product']->price;
            return $carry + ($unitPrice * $item['quantity']);
        }, 0);
 
        $wishlistItems = $this->loadWishlistItems($request);
        $wishlistCount = $wishlistItems->count();
        $wishlistIds = $wishlistItems->pluck('id')->all();
 
        return view('shop.cart', compact(
            'cartItems',
            'cartQuantity',
            'cartTotal',
            'wishlistItems',
            'wishlistCount',
            'wishlistIds'
        ));
    }
 
    public function addToCart(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'unit_price' => ['nullable', 'numeric', 'min:0'],
            'selected_weight' => ['nullable', 'numeric', 'min:0'],
            'selected_weight_label' => ['nullable', 'string', 'max:255'],
        ]);
 
        $product = Product::findOrFail($data['product_id']);
        $quantity = $data['quantity'] ?? 1;
        $cart = $request->session()->get('cart', []);
 
        $unitPrice = isset($data['unit_price']) && $data['unit_price'] > 0 ? (float) $data['unit_price'] : (float) $product->price;
        $weight = (float) ($data['selected_weight'] ?? ($product->weight ?? 0));
        if ($weight <= 0) {
            $weight = $product->weight ?? 0;
        }
 
        $label = trim((string) ($data['selected_weight_label'] ?? $this->formatWeightLabel($weight ?: ($product->weight ?? 0))));
        $label = $label === '' ? $this->formatWeightLabel($weight ?: ($product->weight ?? 0)) : $label;
 
        $entryKey = $this->generateCartEntryKey($product, $label, $unitPrice);
        $existingQuantity = isset($cart[$entryKey]) ? (int) ($cart[$entryKey]['quantity'] ?? 0) : 0;
 
        $cart[$entryKey] = [
            'product_id' => $product->id,
            'quantity' => $existingQuantity + $quantity,
            'unit_price' => round($unitPrice, 2),
            'weight_in_kg' => $weight,
            'weight_label' => $label,
        ];
 
        $request->session()->put('cart', $cart);
 
        return back()->with('success', __('Product added to cart.'));
    }
 
    public function removeFromCart(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'entry_key' => ['required', 'string'],
        ]);
 
        $cart = $request->session()->get('cart', []);
        $entryKey = $data['entry_key'];
 
        if (isset($cart[$entryKey])) {
            unset($cart[$entryKey]);
            $request->session()->put('cart', $cart);
        }
 
        return back()->with('success', __('Removed from cart.'));
    }
 
    public function updateCart(Request $request, Product $product): RedirectResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0'],
            'entry_key' => ['required', 'string'],
        ]);
 
        $cart = $request->session()->get('cart', []);
        $entryKey = $data['entry_key'];
 
        if (! isset($cart[$entryKey])) {
            return back()->with('success', __('Updated cart quantities.'));
        }
 
        if ($data['quantity'] <= 0) {
            unset($cart[$entryKey]);
        } else {
            $cart[$entryKey]['quantity'] = $data['quantity'];
        }
 
        $request->session()->put('cart', $cart);
  
        return back()->with('success', __('Updated cart quantities.'));
    }
 
    protected function generateCartEntryKey(Product $product, string $weightLabel, float $unitPrice): string
    {
        $normalizedLabel = trim(strtolower($weightLabel));
        $normalizedPrice = number_format($unitPrice, 2, '.', '');
 
        return sha1("{$product->id}|{$normalizedLabel}|{$normalizedPrice}");
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
        $cartItems = $this->loadCartItems($request);
        $cartQuantity = $cartItems->sum('quantity');
        $cartTotal = $cartItems->reduce(function ($carry, $item) {
            $unitPrice = $item['unit_price'] ?? $item['product']->price;
            return $carry + ($unitPrice * $item['quantity']);
        }, 0);

        $wishlistItems = $this->loadWishlistItems($request);
        $wishlistCount = $wishlistItems->count();
        $wishlistIds = $wishlistItems->pluck('id')->all();

        return view('shop.wishlist', compact(
            'cartItems',
            'cartQuantity',
            'cartTotal',
            'wishlistItems',
            'wishlistCount',
            'wishlistIds'
        ));
    }
 
}

