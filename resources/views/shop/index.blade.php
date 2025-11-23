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
        {{-- Mengganti dark nav dengan light nav --}}
       <nav class="sticky top-0 z-30 bg-white shadow-md border-b border-gray-100">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-0">
        
        {{-- Logo/Nama Toko (Kiri) --}}
        <div class="flex items-center gap-4">
            <span class="text-emerald-600 text-xl font-bold tracking-wide">Jurangan99</span>
        </div>

        {{-- Aksi Kanan (Keranjang, Wishlist, Pesanan, dan Lihat Katalog) --}}
        <div class="flex flex-1 items-center justify-end gap-4">
            <div class="flex items-center gap-4">
                {{-- 1. Tautan Keranjang (Ikon) --}}
                <a
                    href="{{ route('shop.cart.index') }}"
                    class="relative text-gray-700 transition hover:text-emerald-600"
                    aria-label="{{ __('Lihat keranjang') }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708"/>
                    </svg>
                    
                    {{-- Badge Kuantitas Keranjang --}}
                    @if(isset($cartQuantity) && $cartQuantity > 0)
                        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-semibold text-white">
                            {{ $cartQuantity > 99 ? '99+' : $cartQuantity }}
                        </span>
                    @endif
                </a>

                {{-- 2. Tautan Wishlist (Ikon) --}}
                <a
                    href="{{ route('shop.wishlist.index') }}"
                    class="relative text-gray-700 transition hover:text-emerald-600"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                    </svg>
                    
                    {{-- Badge Kuantitas Wishlist --}}
                    @if(isset($wishlistCount) && $wishlistCount > 0)
                        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-semibold text-white">
                            {{ $wishlistCount > 99 ? '99+' : $wishlistCount }}
                        </span>
                    @endif
                </a>

                {{-- 3. Tautan Pesanan Saya --}}
                @auth
                    <a href="{{ route('shop.orders.index') }}" class="text-sm font-semibold text-zinc-600 transition hover:text-emerald-600">{{ __('Pesanan saya') }}</a>
                @endauth
                <a href="{{ route('recipes.index') }}" class="text-sm font-semibold text-zinc-600 transition hover:text-emerald-600">{{ __('Resep') }}</a>
            </div>

            <span class="h-6 w-px bg-gray-200 hidden sm:block"></span>

            {{-- 4. Tombol Lihat Katalog/Aksi --}}
            <a href="{{ route('home') }}#products" class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-700">
                <i class="fas fa-shopping-basket mr-2"></i> {{ __('Lihat katalog') }}
            </a>
        </div>
    </div>
</nav>

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
            <p class="text-sm uppercase tracking-[0.2em] text-emerald-300 font-semibold">Jurangan99</p>
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
                        <p class="text-xs font-semibold uppercase tracking-wide text-gray-400">{{ __('Card carousel terus bergerak dari kanan ke kiri.') }}</p>
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
                    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-md">
                        <div class="">
                            @if($products->isEmpty())
                                <p class="text-sm text-gray-500">{{ __('Tidak ada hasil untuk filter ini. Coba kata kunci lain atau hapus filter.') }}</p>
                            @else
                                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                                    @foreach($products as $product)
                                        {{-- Kartu Produk --}}
                                        <article class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-4 transition duration-300 hover:shadow-lg hover:border-emerald-300">
                                            <div class="aspect-[4/3] w-full overflow-hidden rounded-xl bg-gray-100 border border-gray-200">
                                                @if($product->image_url)
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover transition duration-500 hover:scale-105" />
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-sm uppercase tracking-widest text-gray-400">
                                                        {{ __('Tidak ada gambar') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="space-y-2">
                                                <div class="flex items-center justify-between">
                                                    {{-- Tag Kategori & Potongan --}}
                                                    <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-emerald-700">{{ $product->category ?? __('Uncategorized') }}</span>
                                                    <span class="rounded-full border border-gray-300 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-gray-500">{{ $product->cut_type ?? __('Standard') }}</span>
                                                </div>
                                                <h3 class="text-xl font-bold text-gray-900 hover:text-emerald-600 transition">{{ $product->name }}</h3>
                                                <p class="text-sm text-gray-500">{{ Str::limit($product->description ?? __('Deskripsi belum tersedia.'), 90) }}</p>
                                                
                                                <div class="flex items-center justify-between py-2 border-t border-gray-100 mt-2">
                                                    <span class="text-2xl font-bold text-emerald-600">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                                    <span class="text-sm text-gray-500">{{ __('Stok') }}: {{ number_format($product->stock) }}</span>
                                                </div>

                                               <form action="{{ route('shop.cart.add') }}" method="POST" class="mt-3 flex w-full items-center gap-3" data-product-id="{{ $product->id }}">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product->id }}">
    
    {{-- 1. Quantity Stepper Component --}}
    <div class="mt-4 flex w-full items-center justify-between gap-3">
    
    {{-- 1. Quantity Stepper Component --}}
    <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-white shadow-sm h-10 w-32 flex-shrink-0">
        {{-- Kontainer Stepper tetap w-32 dan flex-shrink-0 --}}
        
        {{-- Tombol MINUS --}}
        <button
            type="button"
            class="quantity-minus flex-shrink-0 w-8 h-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition duration-150 text-xl font-bold border-r border-gray-300"
            data-action="minus"
            data-target="#quantity-input-{{ $product->id }}"
        >
            -
        </button>

        {{-- Display Kuantitas (Input yang akan di-submit) --}}
        <input
            id="quantity-input-{{ $product->id }}"
            name="quantity"
            type="number"
            min="1"
            value="1"
            max="{{ $product->stock }}" {{-- Batasan maksimal stok --}}
            readonly {{-- Tambahkan readonly agar hanya bisa diubah via tombol +/- --}}
            class="flex-1 h-full text-center text-sm font-semibold text-gray-800 bg-white focus:outline-none focus:ring-0 focus:border-0 p-0 m-0 appearance-none"
            style="-moz-appearance: textfield; appearance: textfield;" {{-- Menyembunyikan panah default di Firefox/Chrome --}}
        >

        {{-- Tombol PLUS --}}
        <button
            type="button"
            class="quantity-plus flex-shrink-0 w-8 h-full bg-gray-100 text-gray-600 hover:bg-gray-200 transition duration-150 text-xl font-bold border-l border-gray-300"
            data-action="plus"
            data-target="#quantity-input-{{ $product->id }}"
        >
            +
        </button>
    </div>

    
    <form action="{{ route('shop.cart.add') }}" method="POST" class="flex-1">
        @csrf
        <input type="hidden" name="product_id" value="{{ $product->id }}">
        {{-- 2. Tombol Submit (Tambah ke Keranjang) --}}
        {{-- Gunakan flex-1 pada form wrapper, dan w-full pada button untuk mengisi ruang sisa --}}
        <button
            type="submit"
            class="w-full h-10 rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white shadow-md shadow-emerald-500/30 transition hover:bg-emerald-700 flex items-center justify-center gap-2"
        >
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708"/>
            </svg>
            {{ __('Keranjang') }}
        </button>
    </form>

    {{-- 3. Tombol Wishlist --}}
    @if(in_array($product->id, $wishlistIds ?? []))
        <form action="{{ route('shop.wishlist.remove', $product) }}" method="POST" class="flex-shrink-0">
            @csrf
            @method('DELETE')
            <button
                type="submit"
                {{-- Hanya icon, h-10 dan w-10 untuk membuatnya kotak --}}
                class="flex items-center justify-center w-10 h-10 rounded-lg border border-rose-400 bg-rose-100 text-rose-600 transition hover:bg-rose-200"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                </svg>
            </button>
        </form>
    @else
        <form action="{{ route('shop.wishlist.add') }}" method="POST" class="flex-shrink-0">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <button
                type="submit"
                {{-- Hanya icon, h-10 dan w-10 untuk membuatnya kotak --}}
                class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 bg-white text-gray-500 transition hover:border-emerald-500 hover:text-emerald-600"
            >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                    <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15"/>
                </svg>
            </button>
        </form>
    @endif
</div>           </div>
                                        </article>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @if($products->hasPages())
                            {{-- Paginasi --}}
                            <div class="mt-8 border-t border-gray-200 pt-6">
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
</x-layouts.app>
