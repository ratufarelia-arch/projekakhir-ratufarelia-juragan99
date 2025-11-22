@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="__('Wishlist Anda')">
    <div class="min-h-screen bg-gradient-to-b from-[#f6f7f2] via-[#fbfdf9] to-[#f3f7ed] text-zinc-900">
        <nav class="sticky top-0 z-30 border-b border-zinc-200/60 bg-white/80 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-0">
                <div class="flex items-center gap-3">
                    <span class="text-emerald-600 text-sm font-semibold uppercase tracking-[0.4em]">rifan market</span>
                    <p class="text-sm text-zinc-700">{{ __('Wishlist saya') }}</p>
                </div>
                <div class="hidden items-center gap-6 text-xs font-semibold uppercase tracking-[0.3em] text-zinc-500 sm:flex">
                    <a href="{{ route('home') }}" class="transition hover:text-emerald-600">{{ __('Home') }}</a>
                    <a href="#products" class="transition hover:text-emerald-600">{{ __('Produk') }}</a>
                    <a href="{{ route('shop.cart.index') }}" class="transition hover:text-emerald-600">{{ __('Keranjang') }}</a>
                    <a href="{{ route('shop.wishlist.index') }}" class="text-emerald-500">{{ __('Wishlist') }}</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}#products" class="rounded-full border border-emerald-500/60 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500 transition hover:border-emerald-400">{{ __('Lihat katalog') }}</a>
                </div>
            </div>
        </nav>

        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-0">
            <header class="rounded-3xl border border-emerald-100 bg-white/80 p-6 shadow-lg shadow-emerald-100/50">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-emerald-600">{{ __('Wishlist') }}</p>
                        <h1 class="text-3xl font-semibold text-zinc-900">{{ __('Produk favorit Anda') }}</h1>
                        <p class="text-sm text-zinc-600">{{ __('Simpan produk yang ingin Anda cek kembali atau tambahkan ke keranjang nanti.') }}</p>
                    </div>
                    <div class="text-right space-y-1 text-sm text-zinc-500">
                        <p>{{ __('Item disimpan') }}: {{ $wishlistItems->count() }}</p>
                    </div>
                </div>
            </header>

            <div class="mt-6 grid gap-8 lg:grid-cols-[1fr,320px]">
                <div>
                    @if($wishlistItems->isEmpty())
                        <section class="rounded-3xl border border-zinc-200 bg-white/90 p-6 shadow-lg shadow-zinc-200/50 text-center">
                            <p class="text-sm font-semibold uppercase tracking-[0.4em] text-zinc-500">{{ __('Wishlist kosong') }}</p>
                            <p class="text-lg font-semibold text-zinc-900">{{ __('Tambahkan produk favorit Anda terlebih dahulu.') }}</p>
                            <a href="{{ route('home') }}" class="mt-4 inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-500">
                                <i class="fa-solid fa-shopping-cart text-[14px]"></i>
                                {{ __('Kembali ke katalog') }}
                            </a>
                        </section>
                    @else
                        <div class="space-y-4" id="products">
                            @foreach($wishlistItems as $product)
                                <article class="flex flex-col gap-4 rounded-3xl border border-zinc-200 bg-zinc-50/80 p-4 shadow-sm shadow-zinc-200 md:flex-row md:items-center">
                                    <div class="flex w-full gap-4">
                                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl bg-white shadow-inner shadow-zinc-200">
                                            @if($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-xs uppercase tracking-[0.4em] text-zinc-400">
                                                    {{ __('No Image') }}
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex flex-1 flex-col gap-2">
                                            <p class="text-sm uppercase tracking-[0.4em] text-emerald-600">{{ $product->category ?? __('Uncategorized') }}</p>
                                            <p class="text-lg font-semibold text-zinc-900">{{ $product->name }}</p>
                                            <p class="text-sm text-zinc-500">{{ Str::limit($product->description ?? __('Deskripsi belum tersedia.'), 80) }}</p>
                                            <div class="flex flex-wrap items-center gap-3 text-sm text-zinc-500">
                                                <span>{{ __('Harga') }}: Rp {{ number_format($product->price, 2) }}</span>
                                                <span>{{ __('Stok') }}: {{ number_format($product->stock) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-none flex-col gap-3 text-sm text-zinc-500">
                                        <form action="{{ route('shop.cart.add') }}" method="POST" class="flex w-full gap-2">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="flex-1 rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-white transition hover:bg-emerald-500">
                                                {{ __('Tambah ke keranjang') }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('shop.wishlist.remove', $product) }}" class="flex w-full">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex-1 rounded-full border border-rose-200 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-rose-600 transition hover:border-rose-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heartbreak" viewBox="0 0 16 16">
                                                    <path d="M8.982 1.566C8.332.714 7.42.333 6.5.333c-.96 0-1.873.285-2.513.968-.862.93-.86 2.27.045 3.33l2.168 2.399-1.985.79c-.501.2-.71.764-.482 1.22l2.084 3.695c.385.68 1.317.638 1.693-.058l1.68-2.913 1.68 2.913c.376.696 1.308.738 1.693.058l2.084-3.695c.228-.456.019-1.02-.482-1.22l-1.985-.79 2.168-2.399c.905-1.06.907-2.4.045-3.33-.64-.683-1.553-.968-2.513-.968-.92 0-1.832.381-2.482 1.233-.312.418-.481.908-.481 1.418h-.01c0-.51-.17-1-.482-1.418Z"/>
                                                </svg>
                                                {{ __('Hapus dari wishlist') }}
                                            </button>
                                        </form>
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
                <aside class="flex-shrink-0 w-full max-w-sm">
                    <div class="rounded-3xl border border-zinc-200 bg-white/90 p-6 shadow-lg shadow-zinc-200/50">
                        <p class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ __('Ringkasan wishlist') }}</p>
                        <div class="mt-4 space-y-3 text-sm text-zinc-600">
                            <p>{{ __('Item tersimpan') }}: <span class="font-semibold text-zinc-900">{{ $wishlistItems->count() }}</span></p>
                            <p class="text-[13px] text-zinc-500">{{ __('Anda bisa menambahkan produk ini ke keranjang kapan saja.') }}</p>
                        </div>
                        <a href="{{ route('shop.cart.index') }}" class="mt-6 block w-full rounded-full border border-zinc-200 px-4 py-3 text-center text-xs font-semibold uppercase tracking-[0.4em] text-zinc-600 transition hover:border-emerald-400">{{ __('Lihat keranjang') }}</a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.plain>
