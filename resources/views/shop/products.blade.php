@php
    use Illuminate\Support\Arr;
    use Illuminate\Support\Str;
    $filters = request()->except('page');
@endphp

<x-layouts.plain :title="__('Product Catalog')">
    {{-- Alpine.js diperlukan untuk menangani state sidebar/drawer --}}
    <div x-data="{ sidebarOpen: false }" class="min-h-screen bg-gradient-to-b from-[#f6f7f2] via-[#fbfdf9] to-[#f3f7ed] text-zinc-900">
        {{-- Navbar Tetap (Sama seperti sebelumnya) --}}
       {{-- Asumsi Anda memiliki variabel $cartQuantity dan $wishlistCount di view atau layout --}}
 
        @include('partials.navbar')
 
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-0">

            {{-- Header/Jumbotron (Sama seperti sebelumnya) --}}
            <header class="relative overflow-hidden rounded-3xl border border-emerald-100 bg-black p-6 shadow-lg shadow-emerald-100/50">
                <img
                    src="https://images.unsplash.com/photo-1690983322025-aab4f95a0269?ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxzZWFyY2h8M3x8ZGFnaW5nJTIwc2FwaXxlbnwwfHwwfHx8MA%3D%3D&fm=jpg&q=60&w=3000"
                    alt="Groceries spread"
                    class="pointer-events-none absolute inset-0 h-full w-full object-cover opacity-30"
                >
                <div class="relative space-y-2 text-white">
                    <p class="text-xs uppercase tracking-[0.4em] text-white">{{ __('Product') }}</p>
                    <h1 class="text-3xl font-semibold text-white">{{ __('Semua produk tersedia') }}</h1>
                    <p class="text-sm text-white">{{ __('Telusuri katalog lengkap kami dengan detail harga, stok, dan simpanan favorit.') }}</p>
                    <div class="flex flex-wrap items-center gap-4 text-xs uppercase tracking-[0.3em] text-emerald-50">
                        <span class="rounded-full border border-white/30 px-3 py-1">{{ __('Premium cuts') }}</span>
                        <span class="rounded-full border border-white/30 px-3 py-1">{{ __('Fresh delivery') }}</span>
                        <span class="rounded-full border border-white/30 px-3 py-1">{{ __('Wishlist') }}</span>
                    </div>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-white">
                        <div>
                            <p class="text-xs uppercase tracking-[0.4em]">{{ __('Items di keranjang') }}</p>
                            <p class="text-2xl font-bold">{{ $cartQuantity }}</p>
                        </div>
                        <div>
                            <p class="text-xs uppercase tracking-[0.4em]">{{ __('Wishlist') }}</p>
                            <p class="text-2xl font-bold">{{ $wishlistCount }}</p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Struktur Konten Utama: Drawer Sidebar (Mobile) + Filter Statis (Desktop) + Main Content --}}
            <div class="mt-10 flex gap-6">

                {{-- A. Filter Sidebar/Drawer (Hanya Terlihat di Mobile/Kecil) --}}
                <div
                    x-cloak
                    x-show="sidebarOpen"
                    @click="sidebarOpen = false"
                    class="fixed inset-0 z-40 bg-black/50 lg:hidden"
                ></div>
                <div
                    x-cloak
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="-translate-x-full"
                    x-transition:enter-end="translate-x-0"
                    x-transition:leave="transition ease-in duration-200"
                    x-transition:leave-start="translate-x-0"
                    x-transition:leave-end="-translate-x-full"
                    x-show="sidebarOpen"
                    class="fixed inset-y-0 left-0 z-50 w-64 space-y-6 overflow-y-auto border-r border-zinc-200 bg-white p-6 shadow-2xl lg:relative lg:translate-x-0 lg:hidden"
                >
                    <button type="button" @click="sidebarOpen = false" class="absolute right-4 top-4 text-zinc-500 transition hover:text-zinc-700">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                    <h2 class="text-lg font-semibold text-zinc-900 pt-2">{{ __('Filter Produk') }}</h2>
                    <div class="space-y-6">
                        {{-- Isi Filter: Kategori --}}
                        <div class="space-y-4">
                            <h3 class="text-base font-semibold text-zinc-900">{{ __('Kategori') }}</h3>
                            <ul class="space-y-2 text-sm">
                                <li>
                                    <a
                                        href="{{ route('shop.products.index', Arr::except($filters, ['category'])) }}"
                                        class="flex items-center justify-between rounded-xl px-3 py-2 transition {{ empty($category) ? 'bg-emerald-600 text-white' : 'bg-zinc-50 text-zinc-600' }}"
                                    >
                                        {{ __('Semua kategori') }}
                                        <span class="text-xs">{{ $products->total() }}</span>
                                    </a>
                                </li>
                                @foreach($categories as $value)
                                    <li>
                                        <a
                                            href="{{ route('shop.products.index', array_merge($filters, ['category' => $value])) }}"
                                            class="flex items-center justify-between rounded-xl px-3 py-2 transition {{ $category === $value ? 'bg-emerald-600 text-white' : 'bg-zinc-50 text-zinc-600' }}"
                                        >
                                            {{ $value }}
                                            @if($category === $value)
                                                <i class="fas fa-check text-xs"></i>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        {{-- Isi Filter: Jenis Potongan --}}
                        <div class="space-y-4">
                            <h3 class="text-base font-semibold text-zinc-900">{{ __('Jenis potongan') }}</h3>
                            <ul class="space-y-2 text-sm">
                                <li>
                                    <a
                                        href="{{ route('shop.products.index', Arr::except($filters, ['cut_type'])) }}"
                                        class="flex items-center justify-between rounded-xl px-3 py-2 transition {{ empty($cutType) ? 'bg-emerald-600 text-white' : 'bg-zinc-50 text-zinc-600' }}"
                                    >
                                        {{ __('Semua potongan') }}
                                        <span class="text-xs">{{ $products->total() }}</span>
                                    </a>
                                </li>
                                @foreach($cutTypes as $cut)
                                    <li>
                                        <a
                                            href="{{ route('shop.products.index', array_merge($filters, ['cut_type' => $cut->slug])) }}"
                                            class="flex items-center justify-between rounded-xl px-3 py-2 transition {{ $cutType === $cut->slug ? 'bg-emerald-600 text-white' : 'bg-zinc-50 text-zinc-600' }}"
                                        >
                                            {{ $cut->name }}
                                            @if($cutType === $cut->slug)
                                                <i class="fas fa-check text-xs"></i>
                                            @endif
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- B. Filter Sidebar Statis (Hanya Terlihat di Desktop/Besar) --}}
                <aside class="hidden w-[280px] shrink-0 space-y-6 lg:block">
                    <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ __('Filter') }}</p>
                                <h2 class="text-lg font-semibold text-zinc-900">{{ __('Kategori') }}</h2>
                            </div>
                            <a href="{{ route('shop.products.index', Arr::except($filters, ['category'])) }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">{{ __('Reset') }}</a>
                        </div>
                        <ul class="mt-4 space-y-2 text-sm">
                            {{-- Isi Filter: Kategori (Sama seperti di Drawer) --}}
                            <li>
                                <a
                                    href="{{ route('shop.products.index', Arr::except($filters, ['category'])) }}"
                                    class="flex items-center justify-between rounded-2xl px-3 py-2 transition {{ empty($category) ? 'bg-emerald-600 text-white' : 'bg-zinc-50 text-zinc-600' }}"
                                >
                                    {{ __('Semua kategori') }}
                                    <span class="text-xs">{{ $products->total() }}</span>
                                </a>
                            </li>
                            @foreach($categories as $value)
                                <li>
                                    <a
                                        href="{{ route('shop.products.index', array_merge($filters, ['category' => $value])) }}"
                                        class="flex items-center justify-between rounded-2xl px-3 py-2 transition {{ $category === $value ? 'bg-emerald-600 text-white' : 'bg-zinc-50 text-zinc-600' }}"
                                    >
                                        {{ $value }}
                                        @if($category === $value)
                                            <i class="fas fa-check text-xs"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ __('Filter') }}</p>
                                <h2 class="text-lg font-semibold text-zinc-900">{{ __('Jenis potongan') }}</h2>
                            </div>
                            <a href="{{ route('shop.products.index', Arr::except($filters, ['cut_type'])) }}" class="text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500">{{ __('Reset') }}</a>
                        </div>
                        <ul class="mt-4 space-y-2 text-sm">
                            {{-- Isi Filter: Jenis Potongan (Sama seperti di Drawer) --}}
                            <li>
                                <a
                                    href="{{ route('shop.products.index', Arr::except($filters, ['cut_type'])) }}"
                                    class="flex items-center justify-between rounded-2xl px-3 py-2 transition {{ empty($cutType) ? 'bg-emerald-600 text-white' : 'bg-zinc-50 text-zinc-600' }}"
                                >
                                    {{ __('Semua potongan') }}
                                    <span class="text-xs">{{ $products->total() }}</span>
                                </a>
                            </li>
                            @foreach($cutTypes as $cut)
                                <li>
                                    <a
                                        href="{{ route('shop.products.index', array_merge($filters, ['cut_type' => $cut->slug])) }}"
                                        class="flex items-center justify-between rounded-2xl px-3 py-2 transition {{ $cutType === $cut->slug ? 'bg-emerald-600 text-white' : 'bg-zinc-50 text-zinc-600' }}"
                                    >
                                        {{ $cut->name }}
                                        @if($cutType === $cut->slug)
                                            <i class="fas fa-check text-xs"></i>
                                        @endif
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </aside>

                {{-- C. Konten Utama (Daftar Produk) --}}
                <main class="flex-1">
                    <div class="flex items-center justify-between">
                        <h2 class="text-2xl font-semibold text-zinc-900">{{ __('Shop all products') }}</h2>
                        {{-- Tombol Filter untuk Mobile/Tablet --}}
                        <button type="button" @click="sidebarOpen = true" class="flex items-center gap-2 rounded-full border border-zinc-300 px-4 py-2 text-sm font-semibold text-zinc-700 transition hover:bg-zinc-100 lg:hidden">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414A1 1 0 0011 17v2a1 1 0 01-2 0v-2a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" /></svg>
                            {{ __('Filter') }}
                        </button>
                        {{-- Tampilan Item di Desktop --}}
                        <p class="hidden text-xs uppercase tracking-[0.3em] text-zinc-500 lg:block">{{ __('Showing') }} {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }}</p>
                    </div>

                    <form method="GET" action="{{ route('shop.products.index') }}" class="mt-4 flex flex-col gap-3 rounded-2xl border border-zinc-200 bg-white/70 p-3 text-sm shadow-sm md:flex-row md:items-center md:gap-4">
                        <input type="hidden" name="category" value="{{ $category ?? '' }}">
                        <input type="hidden" name="cut_type" value="{{ $cutType ?? '' }}">
                        <input
                            name="search"
                            type="search"
                            placeholder="{{ __('Cari produk...') }}"
                            value="{{ $search ?? '' }}"
                            class="flex-1 rounded-2xl border border-transparent bg-zinc-50 px-4 py-2 text-sm text-zinc-800 focus:border-emerald-500 focus:outline-none focus:ring-0"
                        >
                        <button type="submit" class="rounded-2xl bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-white transition hover:bg-emerald-500">
                            {{ __('Search') }}
                        </button>
                    </form>

                    @if($products->isEmpty())
                        <div class="mt-8 rounded-3xl border border-zinc-200 bg-white p-6 text-center text-sm text-zinc-600 shadow-lg">
                            {{ __('Tidak ada produk yang sesuai filter saat ini. Coba kategori lain.') }}
                        </div>
                    @else
                        {{-- Daftar Produk (Sama seperti sebelumnya) --}}
                        <div class="mt-8 grid gap-6 md:grid-cols-2">
                            @foreach($products as $product)
                                @php
                                    $baseWeightValue = $product->weight > 0 ? $product->weight : 1;

                                    if ($product->weight > 0) {
                                        $formattedWeight = number_format($product->weight, 2, ',', '.');
                                        $formattedWeight = rtrim(rtrim($formattedWeight, '0'), ',');
                                        $weightLabel = "{$formattedWeight} kg";
                                    } else {
                                        $weightLabel = __('Standar');
                                    }

                                    $variantOptions = $product->weight_variant_options ?? [];
                                @endphp
                                <article class="group flex flex-col rounded-[1.5rem] border border-zinc-200 bg-white p-6 shadow-lg transition hover:border-emerald-300 hover:shadow-emerald-100" data-product-card>
                                    <div class="relative mb-4 aspect-[4/3] w-full overflow-hidden rounded-2xl bg-zinc-100">
                                        @if($product->image_url)
                                            <a href="{{ route('shop.products.show', $product) }}" class="absolute inset-0 block">
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
                                            </a>
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-xs uppercase tracking-[0.4em] text-zinc-400">
                                                {{ __('No Image') }}
                                            </div>
                                        @endif
                                        <form action="{{ in_array($product->id, $wishlistIds ?? []) ? route('shop.wishlist.remove', $product) : route('shop.wishlist.add') }}" method="POST" class="absolute right-4 top-4 z-10">
                                            @csrf
                                            @if(in_array($product->id, $wishlistIds ?? []))
                                                @method('DELETE')
                                            @endif
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <button type="submit" class="flex h-11 w-11 items-center justify-center rounded-2xl border border-white/70 bg-white/70 text-zinc-500 transition hover:border-emerald-300 hover:text-rose-500">
                                                @if(in_array($product->id, $wishlistIds ?? []))
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill text-rose-500" viewBox="0 0 16 16">
                                                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                                                    </svg>
                                                @else
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                                        <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                                                    </svg>
                                                @endif
                                            </button>
                                        </form>
                                    </div>
                                    <div class="flex flex-1 flex-col gap-3">
                                        <div class="flex items-center justify-between text-xs uppercase tracking-[0.4em] text-zinc-500">
                                            <span>{{ $product->category ?? __('Uncategorized') }}</span>
                                            <span>{{ $product->cut_type ?? __('Standard') }}</span>
                                        </div>
                                        <h3 class="text-xl font-semibold text-zinc-900">{{ $product->name }}</h3>
                                        <p class="text-sm text-zinc-500">{{ Str::limit($product->description ?? __('Deskripsi belum tersedia.'), 100) }}</p>
                                        <div class="flex items-center justify-between">
                                            <span data-price-display class="text-2xl font-bold text-emerald-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                            <span class="text-xs font-semibold uppercase tracking-[0.4em] text-zinc-400">{{ __('Stok') }} {{ number_format($product->stock) }}</span>
                                        </div>
                                        <p class="text-xs font-semibold uppercase tracking-[0.4em] text-zinc-500">
                                            <span data-selected-weight-label>{{ $weightLabel }}</span>
                                        </p>
                                        
                                    </div>
                                    <form
                                        action="{{ route('shop.cart.add') }}"
                                        method="POST"
                                        class="mt-6 flex flex-col gap-3"
                                        data-product-variant-form
                                        data-base-price="{{ $product->price }}"
                                        data-base-weight="{{ $baseWeightValue }}"
                                        data-default-weight-label="{{ $weightLabel }}"
                                    >
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <input type="hidden" name="unit_price" value="{{ number_format($product->price, 2, '.', '') }}">
                                        <input type="hidden" name="selected_weight" value="{{ $baseWeightValue }}">
                                        <input type="hidden" name="selected_weight_label" value="{{ $weightLabel }}">

                                        <div class="space-y-3">
                                            <label class="block text-xs font-semibold text-zinc-500">
                                                {{ __('Varian berat') }}
                                                <select
                                                    data-variant-select
                                                    class="mt-2 w-full rounded-2xl border border-zinc-200 bg-zinc-50 px-3 py-2 text-sm text-zinc-900 focus:border-emerald-500 focus:outline-none"
                                                >
                                                    <option
                                                        value="{{ number_format($baseWeightValue, 4, '.', '') }}"
                                                        data-variant-weight="{{ number_format($baseWeightValue, 6, '.', '') }}"
                                                        data-variant-label="{{ $weightLabel }}"
                                                    >
                                                        {{ __('Standar') }} ({{ $weightLabel }})
                                                    </option>
                                                    @foreach($variantOptions as $variant)
                                                        <option
                                                            value="{{ number_format($variant['kilograms'], 6, '.', '') }}"
                                                            data-variant-weight="{{ number_format($variant['kilograms'], 6, '.', '') }}"
                                                            data-variant-label="{{ $variant['label'] }}"
                                                        >
                                                            {{ $variant['label'] }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </label>
                                            <label class="block text-xs font-semibold text-zinc-500">
                                                {{ __('Berat khusus (kg)') }}
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0.01"
                                                    placeholder="{{ number_format($baseWeightValue, 2, ',', '.') }}"
                                                    data-custom-weight
                                                    class="mt-2 w-full rounded-2xl border border-zinc-200 bg-white px-3 py-2 text-sm text-zinc-900 focus:border-emerald-500 focus:outline-none"
                                                >
                                            </label>
                                        </div>

                                        <button type="submit" class="w-full rounded-2xl bg-emerald-600 px-4 py-3 text-xs font-semibold uppercase tracking-[0.4em] text-white transition hover:bg-emerald-500">
                                            {{ __('Tambah ke keranjang') }}
                                        </button>
                                    </form>
                                </article>
                            @endforeach
                        </div>
                    @endif

                    {{-- Pagination (Sama seperti sebelumnya) --}}
                    <div class="mt-10 flex items-center justify-center">
                        {{ $products->links('pagination::tailwind') }}
                    </div>
                </main>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const currencyFormatter = new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 0,
            });

            document.querySelectorAll('[data-product-variant-form]').forEach((form) => {
                const card = form.closest('[data-product-card]');
                const priceDisplay = card?.querySelector('[data-price-display]');
                const weightDisplay = card?.querySelector('[data-selected-weight-label]');
                const variantSelect = form.querySelector('[data-variant-select]');
                const customInput = form.querySelector('[data-custom-weight]');
                const hiddenUnitPrice = form.querySelector('input[name="unit_price"]');
                const hiddenWeight = form.querySelector('input[name="selected_weight"]');
                const hiddenWeightLabel = form.querySelector('input[name="selected_weight_label"]');
                const basePrice = Number(form.dataset.basePrice) || 0;
                const baseWeight = Number(form.dataset.baseWeight) || 1;
                const defaultLabel = (form.dataset.defaultWeightLabel || '').trim();

                const formatCurrency = (value) => `Rp ${currencyFormatter.format(value)}`;
                const formatCustomWeightLabel = (value) => {
                    const normalized = Number(value);

                    if (!Number.isFinite(normalized) || normalized <= 0) {
                        return defaultLabel || '';
                    }

                    const formatted = normalized.toLocaleString('id-ID', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2,
                    });

                    return `${formatted} kg`;
                };

                const refresh = () => {
                    let weight = baseWeight;
                    let label = defaultLabel || formatCustomWeightLabel(baseWeight);

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
