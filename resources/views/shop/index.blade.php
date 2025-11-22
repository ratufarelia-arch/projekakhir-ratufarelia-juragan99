@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="__('Home')">
    <div class="min-h-screen bg-black">
        <nav class="sticky top-0 z-30 bg-zinc-900/80 border-b border-zinc-800 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-0">
                <div class="flex items-center gap-3">
                    <span class="text-emerald-400 text-sm uppercase tracking-[0.3em]">rifan market</span>
                    <p class="text-sm text-white">{{ __('Selamat datang di katalog premium kami') }}</p>
                </div>
                <div class="flex items-center gap-4 text-xs font-semibold uppercase tracking-widest text-zinc-400">
                    <a href="{{ route('home') }}" class="transition hover:text-white">{{ __('Home') }}</a>
                    <a href="#products" class="transition hover:text-white">{{ __('Produk') }}</a>
                    <a href="mailto:rifanafendi2464@gmail.com" class="transition hover:text-white">{{ __('Bantuan') }}</a>
                </div>
                <a href="{{ route('home') }}#products" class="rounded-full border border-emerald-500/60 px-4 py-1 text-xs font-semibold uppercase tracking-widest text-emerald-400 transition hover:border-emerald-400">{{ __('Lihat katalog') }}</a>
            </div>
        </nav>
        <div class="mx-auto flex max-w-6xl flex-col gap-8 px-4 py-8 sm:px-6 lg:px-0">
            <header class="w-full rounded-3xl border border-zinc-800/60 bg-zinc-900/70 p-6 shadow-lg shadow-emerald-500/10 backdrop-blur">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.3em] text-emerald-400">Rifan Market</p>
                        <h1 class="text-3xl font-semibold text-white">{{ __('Fresh curated products') }}</h1>
                        <p class="text-sm text-zinc-300">{{ __('Browse the catalog, filter by type, and find the perfect cut.') }}</p>
                    </div>
                    <div class="space-y-1 text-right">
                        @auth
                            <p class="text-sm text-white">{{ __('Hey, :name', ['name' => auth()->user()->name]) }}</p>
                        @else
                            <p class="text-sm text-white">{{ __('Welcome back!') }}</p>
                        @endauth
                        <p class="text-xs uppercase tracking-widest text-emerald-400">{{ __('Cart') }} • {{ $cartQuantity }} {{ __('items') }}</p>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="rounded-3xl border border-emerald-500/40 bg-emerald-500/10 px-6 py-4 text-sm text-emerald-200">
                    {{ session('success') }}
                </div>
            @endif

            <section class="rounded-3xl border border-zinc-800/80 bg-zinc-950/80 p-6 shadow-lg shadow-black/30">
                <h2 class="text-lg font-semibold text-white">{{ __('Cari produk') }}</h2>
                <p class="text-sm text-zinc-400">{{ __('Gunakan pencarian dan filter di bawah ini untuk menyesuaikan hasil.') }}</p>

                <form method="GET" action="{{ route('home') }}" class="mt-4 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <div class="sm:col-span-2">
                        <label class="sr-only" for="search">{{ __('Search') }}</label>
                        <input
                            id="search"
                            name="search"
                            type="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('Cari nama, deskripsi, atau label potongan') }}"
                            class="w-full rounded-2xl border border-zinc-800 bg-zinc-900/80 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/40"
                        >
                    </div>
                    <div>
                        <label class="sr-only" for="category">{{ __('Kategori') }}</label>
                        <select
                            id="category"
                            name="category"
                            class="w-full rounded-2xl border border-zinc-800 bg-zinc-900/80 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/40"
                        >
                            <option value="">{{ __('Semua kategori') }}</option>
                            @foreach($categories as $value)
                                <option value="{{ $value }}" @selected($category === $value)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="sr-only" for="cut_type">{{ __('Jenis potongan') }}</label>
                        <select
                            id="cut_type"
                            name="cut_type"
                            class="w-full rounded-2xl border border-zinc-800 bg-zinc-900/80 px-4 py-3 text-sm text-white placeholder:text-zinc-500 focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/40"
                        >
                            <option value="">{{ __('Semua potongan') }}</option>
                            @foreach($cutTypes as $value)
                                <option value="{{ $value }}" @selected($cutType === $value)>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-end">
                        <button
                            type="submit"
                            class="w-full rounded-2xl bg-emerald-500 px-4 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400"
                        >
                            {{ __('Terapkan filter') }}
                        </button>
                    </div>
                </form>
            </section>

            <div class="grid gap-6 lg:grid-cols-[3fr_1fr]" id="products">
                <div class="space-y-6">
                    <div class="rounded-3xl border border-zinc-800/60 bg-zinc-900/80 p-6 shadow-lg shadow-black/30">
                        <div class="space-y-4">
                            @if($products->isEmpty())
                                <p class="text-sm text-zinc-400">{{ __('Tidak ada hasil untuk filter ini. Coba kata kunci lain atau hapus filter.') }}</p>
                            @else
                                <div class="grid gap-6 md:grid-cols-2">
                                    @foreach($products as $product)
                                        <article class="flex flex-col gap-4 rounded-2xl border border-zinc-800/80 bg-zinc-950/60 p-4">
                                            <div class="aspect-[4/3] w-full overflow-hidden rounded-2xl bg-zinc-900">
                                                @if($product->image_url)
                                                    <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                                @else
                                                    <div class="flex h-full w-full items-center justify-center text-xs uppercase tracking-widest text-zinc-500">
                                                        {{ __('Tidak ada gambar') }}
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="space-y-2">
                                                <p class="text-xs uppercase tracking-widest text-emerald-400">{{ $product->cut_type ?? __('Standard') }}</p>
                                                <h3 class="text-lg font-semibold text-white">{{ $product->name }}</h3>
                                                <p class="text-sm text-zinc-400">{{ Str::limit($product->description ?? __('Deskripsi belum tersedia.'), 90) }}</p>
                                                <div class="flex items-center justify-between text-sm text-zinc-300">
                                                    <span class="text-white">{{ number_format($product->price, 2) }}</span>
                                                    <span>{{ __('Stok') }}: {{ number_format($product->stock) }}</span>
                                                </div>
                                                <div class="flex flex-wrap items-center gap-2 pt-2">
                                                    <span class="rounded-full border border-emerald-500/40 px-3 py-1 text-[11px] font-semibold uppercase tracking-widest text-emerald-400">{{ $product->category ?? __('Uncategorized') }}</span>
                                                    <span class="rounded-full border border-zinc-600 px-3 py-1 text-[11px] font-semibold uppercase tracking-widest text-zinc-400">{{ $product->weight_variant ?? __('Varian berat tidak tersedia') }}</span>
                                                </div>
                                                <form action="{{ route('shop.cart.add') }}" method="POST" class="mt-3 flex w-full items-center gap-2">
                                                    @csrf
                                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                    <label class="sr-only" for="quantity-{{ $product->id }}">{{ __('Jumlah') }}</label>
                                                    <input
                                                        id="quantity-{{ $product->id }}"
                                                        name="quantity"
                                                        type="number"
                                                        min="1"
                                                        value="1"
                                                        class="w-16 rounded-2xl border border-zinc-800 bg-zinc-900/70 px-3 py-2 text-sm text-white focus:border-emerald-500 focus:outline-none focus:ring-emerald-500/40"
                                                    >
                                                    <button
                                                        type="submit"
                                                        class="flex-1 rounded-2xl bg-emerald-500 px-4 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-400"
                                                    >
                                                        {{ __('Tambah ke keranjang') }}
                                                    </button>
                                                </form>
                                            </div>
                                        </article>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        @if($products->hasPages())
                            <div class="mt-6">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <aside class="space-y-6">
                    <div class="rounded-3xl border border-zinc-800/60 bg-zinc-900/80 p-6 shadow-lg shadow-black/30">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-semibold text-white">{{ __('Keranjang saya') }}</h3>
                            <span class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ $cartQuantity }} {{ __('item') }}</span>
                        </div>

                        <div class="mt-4 space-y-3">
                            @forelse($cartItems as $item)
                                <div class="rounded-2xl border border-zinc-800/80 bg-zinc-950/70 p-4">
                                    <div class="flex items-start justify-between gap-3">
                                        <div>
                                            <p class="text-sm font-semibold text-white">{{ $item['product']->name }}</p>
                                            <p class="text-xs uppercase tracking-wide text-zinc-500">{{ __('Qty') }}: {{ $item['quantity'] }}</p>
                                            <p class="text-xs text-zinc-400">{{ number_format($item['product']->price * $item['quantity'], 2) }}</p>
                                        </div>
                                        <form action="{{ route('shop.cart.remove', $item['product']) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold uppercase tracking-wide text-rose-500">{{ __('Hapus') }}</button>
                                        </form>
                                    </div>
                                </div>
                            @empty
                                <p class="text-sm text-zinc-500">{{ __('Keranjang kosong. Tambahkan produk terlebih dahulu.') }}</p>
                            @endforelse
                        </div>

                        <div class="mt-6 border-t border-zinc-800/60 pt-4 text-sm text-zinc-300">
                            <div class="flex items-center justify-between">
                                <span>{{ __('Subtotal') }}</span>
                                <span class="text-base font-semibold text-white">{{ number_format($cartTotal, 2) }}</span>
                            </div>
                            <p class="text-xs text-zinc-500">{{ __('Semua harga sudah termasuk pajak.') }}</p>
                            <a href="{{ route('home') }}#products" class="mt-4 inline-flex w-full items-center justify-center rounded-2xl bg-emerald-500 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition hover:bg-emerald-400">
                                {{ __('Lihat keranjang') }}
                            </a>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.app>
