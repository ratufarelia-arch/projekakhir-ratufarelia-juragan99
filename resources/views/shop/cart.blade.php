@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="__('Keranjang')">
    <div class="min-h-screen bg-gradient-to-b from-[#f6f7f2] via-[#fbfdf9] to-[#f3f7ed] text-zinc-900">
        <nav class="sticky top-0 z-30 border-b border-zinc-200/60 bg-white/80 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-0">
                <div class="flex items-center gap-3">
                    <span class="text-emerald-600 text-sm font-semibold uppercase tracking-[0.4em]">rifan market</span>
                    <p class="text-sm text-zinc-700">{{ __('Selamat datang di katalog premium kami') }}</p>
                </div>
                <div class="hidden items-center gap-6 text-xs font-semibold uppercase tracking-[0.3em] text-zinc-500 sm:flex">
                    <a href="{{ route('home') }}" class="transition hover:text-emerald-600">{{ __('Home') }}</a>
                    <a href="#products" class="transition hover:text-emerald-600">{{ __('Produk') }}</a>
                    <a href="mailto:rifanafendi2464@gmail.com" class="transition hover:text-emerald-600">{{ __('Bantuan') }}</a>
                </div>
                <div class="flex items-center gap-3">
                    <a
                        href="{{ route('shop.cart.index') }}"
                        class="flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.3em] text-zinc-600 shadow-sm shadow-zinc-200 transition hover:border-emerald-400 hover:text-emerald-600"
                    >
                        <i class="fa-solid fa-shopping-cart text-emerald-500"></i>
                        <span class="text-[9px] tracking-[0.3em] text-zinc-500">{{ __('Keranjang') }}</span>
                        <span class="inline-flex h-4 w-4 items-center justify-center rounded-full bg-emerald-600 text-[10px] font-semibold text-white">{{ $cartQuantity }}</span>
                    </a>
                    <button
                        data-theme-toggle
                        type="button"
                        class="flex items-center gap-2 rounded-full border border-zinc-200 bg-white px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.3em] text-zinc-600 shadow-sm shadow-zinc-200 transition hover:border-emerald-400 hover:text-emerald-600"
                    >
                        <span data-theme-icon aria-hidden="true">🌙</span>
                        <span data-theme-label class="text-[9px] tracking-[0.3em] text-zinc-500">{{ __('Mode') }}</span>
                        <span class="sr-only">{{ __('Toggle dark and light mode') }}</span>
                    </button>
                    <a href="{{ route('home') }}#products" class="rounded-full border border-emerald-500/60 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500 transition hover:border-emerald-400">{{ __('Lihat katalog') }}</a>
                </div>
            </div>
        </nav>

        <div class="mx-auto flex max-w-6xl flex-col gap-6 px-4 py-10 sm:px-6 lg:px-0">
            <header class="rounded-3xl border border-emerald-100 bg-[radial-gradient(circle_at_top,_#ecf8ed,_#ffffff)] p-6 shadow-lg shadow-emerald-100/50">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-xs uppercase tracking-[0.4em] text-emerald-600">{{ __('Keranjang saya') }}</p>
                        <h1 class="text-3xl font-semibold text-zinc-900">{{ __('Segarkan keranjang Anda') }}</h1>
                        <p class="text-sm text-zinc-600">{{ __('Semua produk ditandai dengan harga terbaru dan bisa dikirim cepat.') }}</p>
                    </div>
                    <div class="text-right space-y-1 text-sm text-zinc-500">
                        <p>{{ __('Item') }}: {{ $cartQuantity }}</p>
                        <p>{{ __('Subtotal') }}: Rp {{ number_format($cartTotal, 2) }}</p>
                    </div>
                </div>
            </header>

            <section class="rounded-3xl border border-zinc-200 bg-white/90 p-6 shadow-lg shadow-zinc-200/50">
                @if($cartItems->isEmpty())
                    <div class="space-y-4 text-center">
                        <p class="text-sm font-semibold uppercase tracking-[0.4em] text-zinc-500">{{ __('Keranjang kosong') }}</p>
                        <p class="text-lg font-semibold text-zinc-900">{{ __('Tambahkan produk favorit Anda terlebih dahulu.') }}</p>
                            <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-500">
                                <i class="fa-solid fa-shopping-cart text-[14px]"></i>
                                {{ __('Kembali ke katalog') }}
                            </a>

                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($cartItems as $item)
                            <article class="flex flex-col gap-4 rounded-3xl border border-zinc-200 bg-zinc-50/80 p-4 shadow-sm shadow-zinc-200">
                                <div class="flex flex-col gap-4 md:flex-row md:items-center">
                                    <div class="h-24 w-24 flex-shrink-0 overflow-hidden rounded-2xl bg-white shadow-inner shadow-zinc-200">
                                        @if($item['product']->image_url)
                                            <img src="{{ $item['product']->image_url }}" alt="{{ $item['product']->name }}" class="h-full w-full object-cover" />
                                        @else
                                            <div class="flex h-full w-full items-center justify-center text-xs uppercase tracking-[0.4em] text-zinc-400">
                                                {{ __('No Image') }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-1 flex-col gap-2">
                                        <p class="text-sm uppercase tracking-[0.4em] text-emerald-600">{{ $item['product']->category ?? __('Uncategorized') }}</p>
                                        <p class="text-lg font-semibold text-zinc-900">{{ $item['product']->name }}</p>
                                        <p class="text-sm text-zinc-500">{{ Str::limit($item['product']->description ?? __('Deskripsi belum tersedia.'), 90) }}</p>
                                        <div class="flex flex-wrap items-center gap-4 text-sm text-zinc-500">
                                            <span>{{ __('Qty') }}: {{ $item['quantity'] }}</span>
                                            <span>{{ __('Harga satuan') }}: Rp {{ number_format($item['product']->price, 2) }}</span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-3 text-sm text-zinc-500">
                                        <p class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ __('Total') }}</p>
                                        <p class="text-xl font-semibold text-zinc-900">Rp {{ number_format($item['product']->price * $item['quantity'], 2) }}</p>
                                        <form method="POST" action="{{ route('shop.cart.remove', $item['product']) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs font-semibold uppercase tracking-[0.4em] text-rose-500">{{ __('Hapus') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                    <div class="mt-6 flex flex-col gap-4 rounded-3xl border border-emerald-200 bg-white/80 p-6 shadow-lg shadow-emerald-200/40 text-sm text-zinc-600">
                        <div class="flex justify-between text-xs uppercase tracking-[0.4em] text-zinc-500">
                            <span>{{ __('Subtotal') }}</span>
                            <span>Rp {{ number_format($cartTotal, 2) }}</span>
                        </div>
                        <p>{{ __('Semua harga sudah termasuk pajak dan ongkos kirim mengikuti tarif area Anda.') }}</p>
                        <div class="flex items-center justify-between gap-3">
                            <a href="{{ route('home') }}#products" class="flex-1 rounded-full border border-zinc-200 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-zinc-600 transition hover:border-emerald-400">{{ __('Lanjutkan belanja') }}</a>
                            <button type="button" class="flex-1 rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-white transition hover:bg-emerald-500">{{ __('Checkout segera') }}</button>
                        </div>
                    </div>
                @endif
            </section>
        </div>
    </div>
</x-layouts.plain>
