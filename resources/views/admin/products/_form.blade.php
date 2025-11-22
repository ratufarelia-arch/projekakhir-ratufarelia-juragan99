@php
    $product ??= null;
    $editing = isset($product);
    $imageUrl = $product?->image_url;
    $cutTypes ??= collect();
@endphp

<div class="grid gap-6">
    <div>
        <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
            {{ __('Name') }}
            <input
                type="text"
                name="name"
                value="{{ old('name', $product->name ?? '') }}"
                class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                placeholder="{{ __('Fresh white rice') }}"
            >
        </label>
        @error('name')
            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
                {{ __('Kategori') }}
                <input
                    type="text"
                    name="category"
                    value="{{ old('category', $product->category ?? '') }}"
                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                    placeholder="{{ __('Contoh: Beras, Bumbu') }}"
                >
            </label>
            @error('category')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
                {{ __('Slug') }}
                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug', $product->slug ?? '') }}"
                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                    placeholder="{{ __('fresh-white-rice') }}"
                >
            </label>
            @error('slug')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
            {{ __('Jenis potongan') }}
            <select
                name="cut_type"
                class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
            >
                <option value="">{{ __('Pilih jenis potongan') }}</option>
                @foreach($cutTypes as $cut)
                    <option value="{{ $cut->slug }}" @selected(old('cut_type', $product->cut_type ?? '') === $cut->slug)>{{ $cut->name }}</option>
                @endforeach
            </select>
        </label>
        @error('cut_type')
            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
            {{ __('Description') }}
            <textarea
                name="description"
                rows="4"
                class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                placeholder="{{ __('Add notes about the product, size, smell, or suggested pairing.') }}"
            >{{ old('description', $product->description ?? '') }}</textarea>
        </label>
        @error('description')
            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
            {{ __('Cooking tips') }}
            <textarea
                name="cooking_tips"
                rows="3"
                class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-sm text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                placeholder="{{ __('Share how to prepare this product.') }}"
            >{{ old('cooking_tips', $product->cooking_tips ?? '') }}</textarea>
        </label>
        @error('cooking_tips')
            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-4 md:grid-cols-3">
        <div>
            <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
                {{ __('Price') }}
                <input
                    type="number"
                    name="price"
                    step="0.01"
                    min="0"
                    value="{{ old('price', $product->price ?? '') }}"
                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                    placeholder="0.00"
                >
            </label>
            @error('price')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
                {{ __('Potongan') }}
                <input
                    type="number"
                    name="discount"
                    step="0.01"
                    min="0"
                    value="{{ old('discount', $product->discount ?? '') }}"
                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                    placeholder="0.00"
                >
            </label>
            @error('discount')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
                {{ __('Stocks') }}
                <input
                    type="number"
                    name="stock"
                    min="0"
                    value="{{ old('stock', $product->stock ?? '') }}"
                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                >
            </label>
            @error('stock')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
                {{ __('Berat (kg)') }}
                <input
                    type="number"
                    name="weight"
                    step="0.01"
                    min="0"
                    value="{{ old('weight', $product->weight ?? '') }}"
                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                    placeholder="0.00"
                >
            </label>
            @error('weight')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
                {{ __('Varian berat') }}
                <input
                    type="text"
                    name="weight_variant"
                    value="{{ old('weight_variant', $product->weight_variant ?? '') }}"
                    class="mt-1 w-full rounded-xl border border-zinc-200 bg-white px-4 py-2 text-base text-zinc-900 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white"
                    placeholder="{{ __('500 g, 1 kg, 5 kg') }}"
                >
            </label>
            @error('weight_variant')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="grid gap-4 md:grid-cols-2">
        <div>
            <input type="hidden" name="halal_certified" value="0">
            <label class="inline-flex items-center gap-3 rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 shadow-sm focus-within:border-emerald-500 focus-within:outline-none focus-within:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white">
                <input
                    type="checkbox"
                    name="halal_certified"
                    value="1"
                    class="h-5 w-5 rounded border-zinc-300 text-emerald-500 focus:ring-emerald-500/70"
                    @checked(old('halal_certified', $product->halal_certified ?? false))
                >
                {{ __('Sertifikasi Halal') }}
            </label>
            @error('halal_certified')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <input type="hidden" name="is_active" value="0">
            <label class="inline-flex items-center gap-3 rounded-xl border border-zinc-200 bg-white px-4 py-3 text-sm font-semibold text-zinc-700 shadow-sm focus-within:border-emerald-500 focus-within:outline-none focus-within:ring-emerald-500/30 dark:border-zinc-700 dark:bg-zinc-900 dark:text-white">
                <input
                    type="checkbox"
                    name="is_active"
                    value="1"
                    class="h-5 w-5 rounded border-zinc-300 text-emerald-500 focus:ring-emerald-500/70"
                    @checked(old('is_active', $product->is_active ?? true))
                >
                {{ __('Active') }}
            </label>
            @error('is_active')
                <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div>
        <label class="inline-flex w-full flex-col gap-1 text-sm font-semibold text-zinc-700 dark:text-zinc-200">
            {{ __('Product image') }}
            <input
                type="file"
                name="image"
                accept="image/*"
                class="mt-1"
            >
        </label>
        <p class="text-xs text-zinc-500">{{ __('Optional. Uploads are stored to the configured storage disk (S3-compatible or local).') }}</p>
        @error('image')
            <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
        @enderror
    </div>

    @if($imageUrl)
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-zinc-500">{{ __('Current image') }}</p>
            <div class="mt-2 flex items-center gap-3">
                <img src="{{ $imageUrl }}" alt="{{ $product->name }}" class="h-16 w-16 rounded-lg object-cover" />
                <p class="text-sm font-medium text-zinc-700 dark:text-white">{{ $product->name }}</p>
            </div>
        </div>
    @endif
</div>
