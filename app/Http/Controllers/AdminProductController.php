<?php

namespace App\Http\Controllers;

use App\Models\Cut;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminProductController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search'));

        $query = Product::query();

        if ($search !== '') {
            $query->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        $products = $query->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();

        return view('admin.products.index', compact('products', 'search'));
    }

    public function create(): View
    {
        $cutTypes = Cut::orderBy('name')->get();

        return view('admin.products.create', compact('cutTypes'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validateProduct($request);
        $data['slug'] = $this->prepareSlug($data['slug'] ?? null, $data['name']);
        $data['halal_certified'] = $request->boolean('halal_certified', false);
        $data['is_active'] = $request->boolean('is_active', true);
        $data = array_merge($data, $this->handleImageUpload($request));

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): View
    {
        $cutTypes = Cut::orderBy('name')->get();

        return view('admin.products.edit', compact('product', 'cutTypes'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validateProduct($request, $product);
        $data['slug'] = $this->prepareSlug($data['slug'] ?? null, $data['name'], $product);
        $data['halal_certified'] = $request->boolean('halal_certified', $product->halal_certified);
        $data['is_active'] = $request->boolean('is_active', $product->is_active);
        $data = array_merge($data, $this->handleImageUpload($request, $product));

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $this->removeImage($product);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted.');
    }

    protected function validateProduct(Request $request, ?Product $product = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'category' => ['nullable', 'string', 'max:255'],
            'cut_type' => ['nullable', 'string', 'max:255'],
            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('products', 'slug')->ignore($product?->id),
            ],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'discount' => ['nullable', 'numeric', 'min:0'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'weight_variant' => ['nullable', 'string', 'max:255'],
            'cooking_tips' => ['nullable', 'string'],
            'stock' => ['required', 'integer', 'min:0'],
            'is_active' => ['nullable', 'boolean'],
            'halal_certified' => ['nullable', 'boolean'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
    }

    protected function prepareSlug(?string $slug, string $name, ?Product $product = null): string
    {
        $value = trim((string) $slug);

        if ($value === '') {
            return $this->generateSlug($name, $product?->id);
        }

        return $value;
    }

    protected function generateSlug(string $name, ?int $ignoreId = null): string
    {
        $base = Str::slug($name) ?: 'product';
        $query = Product::where('slug', 'like', "{$base}%");

        if ($ignoreId) {
            $query->where('id', '!=', $ignoreId);
        }

        $count = $query->count();

        return $count === 0 ? $base : "{$base}-{$count}";
    }

    protected function handleImageUpload(Request $request, ?Product $product = null): array
    {
        if (! $request->hasFile('image')) {
            return [];
        }

        $this->removeImage($product);

        $disk = $this->imageDisk();
        $path = $request->file('image')->store('products', $disk);

        return [
            'image_path' => $path,
            'image_disk' => $disk,
        ];
    }

    protected function removeImage(?Product $product): void
    {
        if (! $product || ! $product->image_path) {
            return;
        }

        Storage::disk($product->image_disk ?: $this->imageDisk())->delete($product->image_path);
    }

    protected function imageDisk(): string
    {
        return 'public';
    }
}
