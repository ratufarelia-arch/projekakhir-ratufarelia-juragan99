@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="$product->name">
    <div class="min-h-screen bg-gradient-to-b from-[#f7faf6] to-[#eef3ed] text-zinc-900">
        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-4 py-10 md:px-6">
            <div class="rounded-[2rem] border border-zinc-200 bg-white p-6 shadow-lg shadow-emerald-100">
                <div class="flex flex-col gap-6 lg:flex-row">
                    <div class="relative aspect-square w-full overflow-hidden rounded-[1.5rem] bg-zinc-100 lg:w-1/2">
                        @if($product->image_url)
                            <img
                                src="{{ $product->image_url }}"
                                alt="{{ $product->name }}"
                                class="h-full w-full object-cover object-center"
                            >
                        @else
                            <div class="flex h-full w-full items-center justify-center text-xs uppercase tracking-[0.4em] text-zinc-400">
                                {{ __('No Image') }}
                            </div>
                        @endif
                        <span class="absolute left-4 top-4 rounded-full bg-emerald-600 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-white">
                            {{ $product->category ?? __('Uncategorized') }}
                        </span>
                        <span class="absolute right-4 top-4 rounded-full bg-emerald-50 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.2em] text-emerald-700">
                            {{ $product->cut_type ?? __('Standar') }}
                        </span>
                    </div>

                    <div class="flex flex-1 flex-col gap-5">
                        <div class="space-y-1">
                            <p class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ __('Product') }}</p>
                            <h1 class="text-3xl font-semibold text-zinc-900">{{ $product->name }}</h1>
                            <p class="text-sm text-zinc-500">
                                {{ $product->description ? Str::limit($product->description, 300) : __('Deskripsi belum tersedia.') }}
                            </p>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 text-sm">
                            <span data-price-display class="text-2xl font-bold text-emerald-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <span class="text-xs font-semibold uppercase tracking-[0.4em] text-zinc-500">
                                <span data-selected-weight-label>{{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}</span>
                                &nbsp;·&nbsp;{{ __('Stok') }} {{ number_format($product->stock) }}
                            </span>
                            @if($product->halal_certified)
                                <span class="rounded-full bg-emerald-600/10 px-3 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-600">{{ __('Halal') }}</span>
                            @endif
                        </div>

                        <div class="space-y-3 rounded-2xl border border-zinc-200 bg-zinc-50/80 p-4 text-sm text-zinc-600">
                            <p class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ __('Varian berat') }}</p>
                            <div class="flex flex-wrap items-center gap-3 text-[13px]">
                                {{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}
                                @foreach($product->weight_variant_options as $variant)
                                    <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold text-zinc-600">{{ $variant['label'] }}</span>
                                @endforeach
                            </div>
                            @if($product->cooking_tips)
                                <p class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ __('Cooking Tips') }}</p>
                                <p class="text-sm text-zinc-600">{{ $product->cooking_tips }}</p>
                            @endif
                        </div>

                        <form
                            action="{{ route('shop.cart.add') }}"
                            method="POST"
                            class="space-y-4"
                            data-product-variant-form
                            data-base-price="{{ $product->price }}"
                            data-base-weight="{{ $product->weight > 0 ? $product->weight : 1 }}"
                            data-default-weight-label="{{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}"
                        >
                            @csrf
                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                            <input type="hidden" name="quantity" value="1">
                            <input type="hidden" name="unit_price" value="{{ number_format($product->price, 2, '.', '') }}">
                            <input type="hidden" name="selected_weight" value="{{ $product->weight > 0 ? $product->weight : 1 }}">
                            <input type="hidden" name="selected_weight_label" value="{{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}">

                            <div class="space-y-2">
                                <label class="block text-xs font-semibold uppercase tracking-[0.3em] text-zinc-500">
                                    {{ __('Varian berat') }}
                                </label>
                                <select
                                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 focus:border-emerald-500 focus:outline-none"
                                    data-variant-select
                                >
                                    <option
                                        value="{{ number_format($product->weight > 0 ? $product->weight : 1, 4, '.', '') }}"
                                        data-variant-weight="{{ number_format($product->weight > 0 ? $product->weight : 1, 6, '.', '') }}"
                                        data-variant-label="{{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }}"
                                    >
                                        {{ __('Standar') }} ({{ $product->weight > 0 ? number_format($product->weight, 2, ',', '.') . ' kg' : __('Standar') }})
                                    </option>
                                    @foreach($product->weight_variant_options as $variant)
                                        <option
                                            value="{{ number_format($variant['kilograms'], 6, '.', '') }}"
                                            data-variant-weight="{{ number_format($variant['kilograms'], 6, '.', '') }}"
                                            data-variant-label="{{ $variant['label'] }}"
                                        >
                                            {{ $variant['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-xs font-semibold uppercase tracking-[0.3em] text-zinc-500">
                                    {{ __('Berat khusus (kg)') }}
                                </label>
                                <input
                                    type="number"
                                    step="0.01"
                                    min="0.01"
                                    placeholder="{{ number_format($product->weight > 0 ? $product->weight : 1, 2, ',', '.') }}"
                                    data-custom-weight
                                    class="w-full rounded-2xl border border-zinc-200 bg-white px-4 py-3 text-sm text-zinc-900 focus:border-emerald-500 focus:outline-none"
                                >
                            </div>

                            <button type="submit" class="w-full rounded-2xl border border-emerald-600 bg-emerald-600 px-4 py-3 text-xs font-semibold uppercase tracking-[0.4em] text-white transition hover:bg-emerald-500">
                                {{ __('Tambah ke keranjang') }}
                            </button>
                        </form>

                        <div class="flex items-center gap-4 text-sm text-zinc-600">
                            <form action="{{ in_array($product->id, $wishlistIds ?? []) ? route('shop.wishlist.remove', $product) : route('shop.wishlist.add') }}" method="POST">
                                @csrf
                                @if(in_array($product->id, $wishlistIds ?? []))
                                    @method('DELETE')
                                @endif
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <button type="submit" class="flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-zinc-600 transition hover:border-emerald-300 hover:text-emerald-600">
                                    @if(in_array($product->id, $wishlistIds ?? []))
                                        {{ __('Hapus dari favorit') }}
                                    @else
                                        {{ __('Tambah favorit') }}
                                    @endif
                                </button>
                            </form>
                            <a href="{{ route('shop.products.index') }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">{{ __('Kembali ke katalog') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const currencyFormatter = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });

            const priceDisplay = document.querySelector('[data-price-display]');
            const weightDisplay = document.querySelector('[data-selected-weight-label]');
            document.querySelectorAll('[data-product-variant-form]').forEach((form) => {
                const variantSelect = form.querySelector('[data-variant-select]');
                const customInput = form.querySelector('[data-custom-weight]');
                const hiddenUnitPrice = form.querySelector('input[name="unit_price"]');
                const hiddenWeight = form.querySelector('input[name="selected_weight"]');
                const hiddenWeightLabel = form.querySelector('input[name="selected_weight_label"]');
                const basePrice = Number(form.dataset.basePrice) || 0;
                const baseWeight = Number(form.dataset.baseWeight) || 1;
                const defaultLabel = (form.dataset.defaultWeightLabel || '').trim();

                const formatCurrency = (value) => `Rp ${currencyFormatter.format(value)}`;

                const refresh = () => {
                    let weight = baseWeight;
                    let label = defaultLabel || '';

                    if (customInput && customInput.value) {
                        const customValue = Number(customInput.value);

                        if (customValue > 0) {
                            weight = customValue;
                            label = `${customValue.toLocaleString('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2,
                            })} kg`;
                        }
                    }

                    if ((!customInput || !customInput.value) && variantSelect) {
                        const selectedOption = variantSelect.selectedOptions[0];

                        if (selectedOption) {
                            const variantWeight = Number(selectedOption.dataset.variantWeight) || 0;

                            if (variantWeight > 0) {
                                weight = variantWeight;
                                label = selectedOption.dataset.variantLabel || label;
                            }
                        }
                    }

                    const normalizedBaseWeight = baseWeight > 0 ? baseWeight : 1;
                    const normalizedWeight = weight > 0 ? weight : normalizedBaseWeight;
                    const price = normalizedBaseWeight > 0 ? (basePrice * (normalizedWeight / normalizedBaseWeight)) : basePrice;
                    const finalPrice = Number.isFinite(price) ? price : basePrice;

                    if (priceDisplay) {
                        priceDisplay.textContent = formatCurrency(finalPrice);
                    }

                    if (weightDisplay && label) {
                        weightDisplay.textContent = label;
                    }

                    if (hiddenUnitPrice) {
                        hiddenUnitPrice.value = finalPrice.toFixed(2);
                    }

                    if (hiddenWeight) {
                        hiddenWeight.value = normalizedWeight;
                    }

                    if (hiddenWeightLabel) {
                        hiddenWeightLabel.value = label;
                    }
                };

                const handleVariantChange = () => {
                    if (customInput) {
                        customInput.value = '';
                    }

                    refresh();
                };

                const handleCustomChange = () => {
                    if (variantSelect) {
                        variantSelect.selectedIndex = 0;
                    }

                    refresh();
                };

                variantSelect?.addEventListener('change', handleVariantChange);
                customInput?.addEventListener('input', handleCustomChange);

                refresh();
            });
        });
    </script>
</x-layouts.plain>
