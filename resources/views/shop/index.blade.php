@php
    use Illuminate\Support\Str;
@endphp

{{-- Asumsi menggunakan layout 'plain' atau 'app' yang ada --}}
<x-layouts.plain :title="__('Home')">
    <!-- animasi card bergerak dari kanan ke kiri efek marquee-->
    <style>
        .marquee-track {
            display: inline-flex;
            gap: 1rem;
            animation: marquee 24s linear infinite;
            width: max-content;
        }

        .marquee-track-secondary {
            animation-delay: -12s;
        }

        @keyframes marquee {
            0% {
                transform: translateX(0);
            }
            100% {
                transform: translateX(-50%);
            }
        }

        .review-card {
            min-width: 280px;
        }
    </style>
    {{-- Mengganti bg-black dengan bg-gray-50 atau bg-white --}}
    <div class="min-h-screen bg-gray-50">

        {{-- Navigasi Atas (Header) --}}
        @include('partials.navbar')

        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-4 py-8 sm:px-6 lg:px-0">
            
            {{-- Header/Hero Section (Disarankan untuk diubah total agar mirip Grocee, tapi ini versi sederhana) --}}
            <header class="w-full rounded-2xl overflow-hidden relative shadow-lg">
    <div class="absolute inset-0 bg-gradient-to-r from-black/60 to-transparent z-10 rounded-2xl"></div> {{-- Overlay gradasi untuk teks --}}
    
    {{-- Gambar Daging/Produk --}}
    <img 
        src="https://media.istockphoto.com/id/1403665879/id/foto/potongan-daging-sapi-mentah-dan-shashlik-dengan-rempah-rempah.jpg?s=612x612&w=0&k=20&c=q7wOfGgU3f4m8JN7zSUD1dkpDyroATUJrl73aZBW_gE=" 
        alt="Freshly curated meat products" 
        class="w-full h-80 md:h-96 object-cover object-center rounded-2xl"
    >

    <div class="absolute inset-0 z-20 flex flex-col justify-center p-8 text-white rounded-2xl">
        <div class="max-w-xl">
            <p class="text-sm uppercase tracking-[0.2em] text-emerald-300 font-semibold">Juragan99</p>
            <h1 class="text-5xl md:text-6xl font-extrabold mt-2 leading-tight">{{ __('Fresh curated products') }}</h1>
            <p class="text-lg mt-3 max-w-md">{{ __('Browse our premium catalog, filter by type, and find the perfect cut for your culinary needs.') }}</p>
            
            {{-- Tombol atau informasi tambahan --}}
            <div class="mt-6 flex items-center gap-4">
                <a href="product" class="rounded-full bg-emerald-600 px-7 py-3 text-base font-semibold text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-700">
                    {{ __('Lihat Produk Sekarang') }}
                </a>
                <a href="mailto:jurangan99@example.com" class="text-white hover:text-emerald-300 transition flex items-center gap-2">
                    <i class="fas fa-question-circle"></i> {{ __('Bantuan') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Info Keranjang di pojok, dipindahkan ke sini atau di Navigasi atas --}}
    {{-- Saya pindahkan info keranjang ini ke dalam navigasi atau di dekatnya untuk design yang lebih bersih --}}
    {{-- Tapi jika tetap ingin di header: --}}
    <div class="absolute bottom-6 right-6 z-20 text-right text-white hidden md:block">
        @auth
            <p class="text-base font-semibold">{{ __('Hey, :name', ['name' => auth()->user()->name]) }}</p>
        @else
            <p class="text-base font-semibold">{{ __('Welcome back!') }}</p>
        @endauth
        
    </div>
</header>

            @if($reviews->isNotEmpty())
                <section class="rounded-2xl border border-gray-200 bg-white p-6 shadow-md">
                    <div class="mb-4 flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                        <div>
                            <p class="text-sm text-gray-500">{{ __('Ulasan pelanggan') }}</p>
                            <h2 class="text-2xl font-semibold text-gray-900">{{ __('Rating kualitas daging') }}</h2>
                        </div>
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __('') }}</p>
                    </div>
                    <div class="overflow-hidden">
                        <!-- marquee-track di ambil dari style  -->
                        <div class="marquee-track"> 
                            @foreach(range(1, 2) as $copy)
                                @foreach($reviews as $review)
                                    <article class="review-card flex h-full flex-col gap-3 rounded-2xl border border-gray-100 bg-gradient-to-b from-white to-gray-50 p-4 shadow-sm shadow-emerald-200/40">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $review->user->name ?? __('Pembeli') }}</p>
                                                <p class="text-xs text-gray-500">{{ $review->created_at->format('d F Y') }}</p>
                                            </div>
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700">{{ $review->rating }}/5</span>
                                        </div>
                                        <div class="flex gap-0.5 text-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'text-amber-500' : 'text-gray-300' }}">★</span>
                                            @endfor
                                        </div>
                                        <p class="text-sm text-gray-600">{{ Str::limit($review->comment, 150) }}</p>
                                    </article>
                                @endforeach
                            @endforeach
                        </div>
                        <div class="mt-4 marquee-track marquee-track-secondary" aria-hidden="true">
                            @foreach(range(1, 2) as $copy)
                                @foreach($reviews as $review)
                                    <article class="review-card flex h-full flex-col gap-3 rounded-2xl border border-gray-100 bg-gradient-to-b from-white to-gray-50 p-4 shadow-sm shadow-emerald-200/40">
                                        <div class="flex items-center justify-between">
                                            <div>
                                                <p class="text-sm font-semibold text-gray-900">{{ $review->user->name ?? __('Pembeli') }}</p>
                                                <p class="text-xs text-gray-500">{{ $review->created_at->format('d F Y') }}</p>
                                            </div>
                                            <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-emerald-700">{{ $review->rating }}/5</span>
                                        </div>
                                        <div class="flex gap-0.5 text-sm">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $review->rating ? 'text-amber-500' : 'text-gray-300' }}">★</span>
                                            @endfor
                                        </div>
                                        <p class="text-sm text-gray-600">{{ Str::limit($review->comment, 150) }}</p>
                                    </article>
                                @endforeach
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif

            @if(session('success'))
                {{-- Notifikasi Sukses --}}
                <div class="rounded-xl border border-emerald-500/60 bg-emerald-50/70 px-6 py-4 text-sm text-emerald-800 font-medium">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                </div>
            @endif

            {{-- Filter/Pencarian Produk --}}
            <section class="rounded-xl border border-gray-200 bg-white p-6 shadow-md">
                <h2 class="text-xl font-bold text-gray-800">{{ __('Cari produk') }}</h2>
                <p class="text-sm text-gray-500">{{ __('Gunakan pencarian dan filter di bawah ini untuk menyesuaikan hasil.') }}</p>

                <form method="GET" action="{{ route('home') }}" class="mt-5 grid gap-4 sm:grid-cols-2 lg:grid-cols-5">
                    <div class="lg:col-span-2">
                        <label class="sr-only" for="search">{{ __('Search') }}</label>
                        <div class="relative">
                            <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400"></i>
                            <input
                                id="search"
                                name="search"
                                type="search"
                                value="{{ $search ?? '' }}"
                                placeholder="{{ __('Cari nama, deskripsi, atau label potongan') }}"
                                {{-- Mengganti warna input dark ke light --}}
                                class="w-full rounded-xl border border-gray-300 bg-white pl-11 pr-4 py-3 text-sm text-gray-800 placeholder:text-gray-400 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                            >
                        </div>
                    </div>
                    <div>
                        <label class="sr-only" for="category">{{ __('Kategori') }}</label>
                        {{-- Mengganti warna select dark ke light --}}
                        <select
                            id="category"
                            name="category"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                        >
                            <option value="">{{ __('Semua kategori') }}</option>
                            @foreach($categories as $value)
                                <option value="{{ $value }}" @selected($category === $value)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="sr-only" for="cut_type">{{ __('Jenis potongan') }}</label>
                        {{-- Mengganti warna select dark ke light --}}
                        <select
                            id="cut_type"
                            name="cut_type"
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 text-sm text-gray-800 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 focus:outline-none"
                        >
                            <option value="">{{ __('Semua potongan') }}</option>
                            @foreach($cutTypes as $cut)
                                <option value="{{ $cut->slug }}" @selected($cutType === $cut->slug)>{{ $cut->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        {{-- Tombol dengan warna primer (emerald) --}}
                        <button
                            type="submit"
                            class="w-full rounded-xl bg-emerald-600 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-700"
                        >
                            <i class="fas fa-filter mr-1"></i> {{ __('Terapkan filter') }}
                        </button>
                    </div>
                </form>
            </section>

            <div class="grid gap-6 " id="products">
                
                {{-- Daftar Produk --}}
                <div class="">
    <div class="rounded-2xl border border-gray-100 bg-gray-50/50 p-6">
        <div class="">
            @if($products->isEmpty())
                <div class="flex flex-col items-center justify-center py-12 text-center">
                    <div class="rounded-full bg-gray-100 p-4 mb-3">
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 font-medium">{{ __('Tidak ada hasil untuk filter ini.') }}</p>
                    <p class="text-sm text-gray-400">{{ __('Coba kata kunci lain atau hapus filter.') }}</p>
                </div>
            @else
                <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3">
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

                        {{-- Card Start --}}
                        <article class="group relative flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-gray-200 transition-all duration-300 hover:-translate-y-1 hover:shadow-lg hover:ring-emerald-400/50" data-product-card>
                            
                            {{-- Image Section --}}
                            <div class="relative aspect-[4/3] w-full overflow-hidden bg-gray-100">
                                @if($product->image_url)
                                    <a href="{{ route('shop.products.show', $product) }}" class="absolute inset-0 block">
                                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-700 group-hover:scale-110" />
                                    </a>
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-gray-50 text-xs font-medium uppercase tracking-widest text-gray-400">
                                        {{ __('No Image') }}
                                    </div>
                                @endif
                                
                                {{-- Badges (Overlay) --}}
                                <div class="absolute left-3 top-3 flex flex-wrap gap-2">
                                    <span class="inline-flex items-center rounded-md bg-white/90 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-emerald-700 shadow-sm backdrop-blur-sm">
                                        {{ $product->category ?? 'Item' }}
                                    </span>
                                    @if($product->cut_type)
                                    <span class="inline-flex items-center rounded-md bg-gray-900/80 px-2 py-1 text-[10px] font-bold uppercase tracking-wider text-white shadow-sm backdrop-blur-sm">
                                        {{ $product->cut_type }}
                                    </span>
                                    @endif
                                </div>
                            </div>

                            {{-- Content Section --}}
                            <div class="flex flex-1 flex-col p-5">
                                <div class="mb-4">
                                    <h3 class="line-clamp-1 text-lg font-bold text-gray-800 transition group-hover:text-emerald-600" title="{{ $product->name }}">
                                        {{ $product->name }}
                                    </h3>
                                    <p class="mt-1 line-clamp-2 text-xs leading-relaxed text-gray-500">
                                        {{ Str::limit($product->description ?? __('Deskripsi belum tersedia.'), 90) }}
                                    </p>
                                </div>

                                <div class="mt-auto space-y-4">
                                    {{-- Price & Stock Row --}}
                                    <div class="flex items-end justify-between border-b border-gray-100 pb-3">
                                        <div>
                                            <p class="text-xs font-medium text-gray-400 mb-0.5">{{ __('Harga per item') }}</p>
                                            <div class="text-xl font-bold text-emerald-600" data-price-display>
                                                Rp{{ number_format($product->price, 0, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="text-right">
                                            <p class="text-[10px] font-bold uppercase tracking-wider text-gray-400">{{ __('Tersedia') }}</p>
                                            <p class="text-sm font-semibold text-gray-700">{{ number_format($product->stock) }}</p>
                                        </div>
                                    </div>

                                    {{-- Form Area --}}
                                    <form
                                        action="{{ route('shop.cart.add') }}"
                                        method="POST"
                                        data-product-variant-form
                                        data-base-price="{{ $product->price }}"
                                        data-base-weight="{{ $baseWeightValue }}"
                                        data-default-weight-label="{{ $weightLabel }}"
                                    >
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                                        <input type="hidden" name="unit_price" value="{{ number_format($product->price, 2, '.', '') }}">
                                        <input type="hidden" name="selected_weight" value="{{ $baseWeightValue }}">
                                        <input type="hidden" name="selected_weight_label" value="{{ $weightLabel }}">

                                        {{-- Options Grid --}}
                                        <div class="mb-4 grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="mb-1.5 block text-[10px] font-bold uppercase text-gray-500">{{ __('Pilih Varian') }}</label>
                                                <select
                                                    data-variant-select
                                                    class="w-full rounded-lg border-gray-200 bg-gray-50 py-2 pl-3 pr-8 text-xs font-medium text-gray-700 focus:border-emerald-500 focus:bg-white focus:ring-emerald-500"
                                                >
                                                    <option
                                                        value="{{ number_format($baseWeightValue, 6, '.', '') }}"
                                                        data-variant-weight="{{ number_format($baseWeightValue, 6, '.', '') }}"
                                                        data-variant-label="{{ $weightLabel }}"
                                                    >
                                                        Standar ({{ $weightLabel }})
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
                                            </div>
                                            <div>
                                                <label class="mb-1.5 block text-[10px] font-bold uppercase text-gray-500">{{ __('Custom (Kg)') }}</label>
                                                <input
                                                    type="number"
                                                    step="0.01"
                                                    min="0.01"
                                                    placeholder="{{ number_format($baseWeightValue, 2, ',', '.') }}"
                                                    data-custom-weight
                                                    class="w-full rounded-lg border-gray-200 bg-white py-2 px-3 text-xs font-medium text-gray-700 placeholder-gray-300 focus:border-emerald-500 focus:ring-emerald-500"
                                                >
                                            </div>
                                        </div>

                                        {{-- Action Buttons Row --}}
                                        <div class="flex items-center gap-2">
                                            {{-- Quantity --}}
                                            <div class="flex h-10 w-24 flex-shrink-0 items-center overflow-hidden rounded-lg border border-gray-200 bg-gray-50">
                                                <button type="button" class="quantity-minus flex h-full w-8 items-center justify-center text-gray-500 transition hover:bg-gray-200 hover:text-emerald-600" data-action="minus" data-target="#quantity-input-home-{{ $product->id }}">-</button>
                                                <input
                                                    id="quantity-input-home-{{ $product->id }}"
                                                    name="quantity"
                                                    type="number"
                                                    min="1"
                                                    value="1"
                                                    max="{{ $product->stock }}"
                                                    readonly
                                                    class="h-full w-full border-0 bg-transparent p-0 text-center text-sm font-bold text-gray-800 focus:ring-0"
                                                >
                                                <button type="button" class="quantity-plus flex h-full w-8 items-center justify-center text-gray-500 transition hover:bg-gray-200 hover:text-emerald-600" data-action="plus" data-target="#quantity-input-home-{{ $product->id }}">+</button>
                                            </div>

                                            {{-- Add to Cart --}}
                                            <button
                                                type="submit"
                                                class="flex h-10 flex-1 items-center justify-center rounded-lg bg-emerald-600 px-4 text-sm font-bold text-white shadow-md shadow-emerald-200 transition-all hover:bg-emerald-700 hover:shadow-lg focus:ring-2 focus:ring-emerald-500 focus:ring-offset-1"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-plus mr-2" viewBox="0 0 16 16">
                                                    <path d="M9 5.5a.5.5 0 0 0-1 0V7H6.5a.5.5 0 0 0 0 1H8v1.5a.5.5 0 0 0 1 0V8h1.5a.5.5 0 0 0 0-1H9z"/>
                                                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7h-8.17zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0"/>
                                                </svg>
                                                {{ __('Beli') }}
                                            </button>
                                        </div>
                                    </form>

                                    {{-- Wishlist Button (Separated for logic, but positioned via Flex if needed, here stacked or integrated) --}}
                                    {{-- Note: In the design above I prioritized the Add to Cart. To keep Wishlist accessible without breaking the layout: --}}
                                    
                                    <div class="absolute right-3 top-3 z-10">
                                        @if(in_array($product->id, $wishlistIds ?? []))
                                            <form action="{{ route('shop.wishlist.remove', $product) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-full bg-white text-rose-500 shadow-md ring-1 ring-gray-100 transition hover:bg-rose-50">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/></svg>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('shop.wishlist.add') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                <button type="submit" class="flex h-8 w-8 items-center justify-center rounded-full bg-white/80 text-gray-400 shadow-sm backdrop-blur-sm transition hover:bg-white hover:text-rose-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16"><path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            @endif
        </div>
        
        @if($products->hasPages())
            <div class="mt-10 border-t border-gray-100 pt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>

                
            </div>
        </div>
        
        {{-- Footer Sederhana --}}
        <footer class="mt-12 border-t border-gray-200 bg-white">
            <div class="mx-auto max-w-6xl px-4 py-6 sm:px-6 lg:px-0 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Jurangan99. {{ __('All rights reserved.') }}
            </div>
        </footer>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-action="minus"], [data-action="plus"]').forEach(button => {
                const target = button.getAttribute('data-target');
                if (!target) {
                    return;
                }

                const input = document.querySelector(target);
                if (!input) {
                    return;
                }

                button.addEventListener('click', () => {
                    const min = Number(input.getAttribute('min')) || 1;
                    const maxValue = input.getAttribute('max');
                    const max = maxValue ? Number(maxValue) : Number.POSITIVE_INFINITY;
                    const current = Number(input.value) || min;
                    const delta = button.getAttribute('data-action') === 'plus' ? 1 : -1;
                    const next = Math.max(min, Math.min(max, current + delta));

                    input.value = next;
                });
            });
        });
    </script>
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
</x-layouts.app>
