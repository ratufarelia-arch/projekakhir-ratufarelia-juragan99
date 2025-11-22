@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="__('Keranjang')">
    <div class="min-h-screen bg-gradient-to-b from-[#f6f7f2] via-[#fbfdf9] to-[#f3f7ed] text-zinc-900">
        <nav class="sticky top-0 z-30 border-b border-zinc-200/60 bg-white/80 backdrop-blur">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-3 sm:px-6 lg:px-0">
                <div class="flex items-center gap-3">
                    <span class="text-emerald-600 text-sm font-semibold uppercase tracking-[0.4em]">Juranan99</span>
               </div>
                <div class="hidden items-center gap-6 text-xs font-semibold uppercase tracking-[0.3em] text-zinc-500 sm:flex">
                    <a href="{{ route('home') }}" class="transition hover:text-emerald-600">{{ __('Home') }}</a>
                    <a href="#products" class="transition hover:text-emerald-600">{{ __('Produk') }}</a>
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('home') }}#products" class="rounded-full border border-emerald-500/60 px-4 py-1 text-xs font-semibold uppercase tracking-[0.3em] text-emerald-500 transition hover:border-emerald-400">{{ __('Lihat katalog') }}</a>
                </div>
            </div>
        </nav>
 
        <div class="mx-auto max-w-6xl px-4 py-10 sm:px-6 lg:px-0">
           

            <div class="mt-6 flex flex-col gap-8 lg:flex-row">
                <div class="flex-1">
                    @if($cartItems->isEmpty())
                        <section class="rounded-3xl border border-zinc-200 bg-white/90 p-6 shadow-lg shadow-zinc-200/50">
                            <div class="space-y-4 text-center">
                                <p class="text-sm font-semibold uppercase tracking-[0.4em] text-zinc-500">{{ __('Keranjang kosong') }}</p>
                                <p class="text-lg font-semibold text-zinc-900">{{ __('Tambahkan produk favorit Anda terlebih dahulu.') }}</p>
                                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 rounded-full bg-emerald-600 px-4 py-2 text-xs font-semibold uppercase tracking-[0.4em] text-white shadow-lg shadow-emerald-500/40 transition hover:bg-emerald-500">
                                    <i class="fa-solid fa-shopping-cart text-[14px]"></i>
                                    {{ __('Kembali ke katalog') }}
                                </a>
                            </div>
                        </section>
                    @else
                        <section class="space-y-4">
                            @foreach($cartItems as $item)
                                <article class="flex flex-col gap-4 rounded-3xl border border-zinc-200 bg-zinc-50/80 p-4 shadow-sm shadow-zinc-200 md:flex-row md:items-center">
                                    <div class="flex w-full gap-4">
                                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-2xl bg-white shadow-inner shadow-zinc-200">
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
                                            <p class="text-sm text-zinc-500">{{ Str::limit($item['product']->description ?? __('Deskripsi belum tersedia.'), 80) }}</p>
                                            <div class="flex flex-wrap items-center gap-3 text-sm text-zinc-500">
                                                <span>{{ __('Harga') }}: Rp {{ number_format($item['product']->price, 2) }}</span>
                                                <span>{{ __('Subtotal') }}: Rp {{ number_format($item['product']->price * $item['quantity'], 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex flex-none flex-col gap-3 text-sm text-zinc-500">
                                        <div class="flex items-center gap-2">
                                            <form action="{{ route('shop.cart.update', $item['product']) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ max($item['quantity'] - 1, 0) }}">
                                                <button type="submit" class="rounded-full border border-zinc-200 px-2 text-xs font-semibold text-zinc-600 transition hover:border-emerald-400">-</button>
                                            </form>
                                            <span class="text-base font-semibold text-zinc-900">{{ $item['quantity'] }}</span>
                                            <form action="{{ route('shop.cart.update', $item['product']) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item['quantity'] + 1 }}">
                                                <button type="submit" class="rounded-full border border-zinc-200 px-2 text-xs font-semibold text-zinc-600 transition hover:border-emerald-400">+</button>
                                            </form>
                                            <form method="POST" action="{{ route('shop.cart.remove', $item['product']) }}" class="ml-auto">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-xs font-semibold uppercase tracking-[0.4em] text-rose-500">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                        <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                                                        <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                                                    </svg>
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </section>
                    @endif
                </div>

                <div class="flex-shrink-0 w-full max-w-sm">
                    <div class="rounded-3xl border border-zinc-200 bg-white/90 p-6 shadow-lg shadow-zinc-200/50">
                        <p class="text-xs uppercase tracking-[0.4em] text-zinc-500">{{ __('Ringkasan') }}</p>
                        <div class="mt-4 space-y-3">
                            <div class="flex items-center justify-between text-sm text-zinc-500">
                                <span>{{ __('Item') }}</span>
                                <span class="font-semibold text-zinc-900">{{ $cartQuantity }}</span>
                            </div>
                            <div class="flex items-center justify-between text-sm text-emerald-600">
                                <span class="font-semibold">{{ __('Subtotal') }}</span>
                                <span class="text-lg font-semibold text-zinc-900">Rp {{ number_format($cartTotal, 2) }}</span>
                            </div>
                            <p class="text-[13px] text-zinc-500">{{ __('Semua harga termasuk pajak dan biaya penanganan.') }}</p>
                        </div>
                        <a href="{{ url('/checkout') }}" class="mt-6 block w-full rounded-full bg-emerald-600 px-4 py-3 text-center text-xs font-semibold uppercase tracking-[0.4em] text-white transition hover:bg-emerald-500">{{ __('Checkout sekarang') }}</a>
                    </div>
                    <p class="mt-4 text-center text-[13px] text-zinc-500">{{ __('Butuh bantuan? Tim support siap membantu dalam 24 jam.') }}</p>
                </div>
            </div>
        </div>

    </div>
</x-layouts.plain>

