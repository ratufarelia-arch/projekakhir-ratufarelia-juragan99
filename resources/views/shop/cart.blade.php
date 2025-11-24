@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="__('Keranjang')">
    <div class="min-h-screen bg-gradient-to-b from-[#f6f7f2] via-[#fbfdf9] to-[#f3f7ed] text-zinc-900">
        <nav class="sticky top-0 z-30 bg-white shadow-md border-b border-gray-100">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-0">
        
        {{-- Logo/Nama Toko (Kiri) --}}
        <div class="flex items-center gap-4">
            <span class="text-emerald-600 text-xl font-bold tracking-wide">Jurangan99</span>
        </div>

        {{-- Aksi Kanan (Keranjang, Wishlist, Pesanan, dan Login/Logout) --}}
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

            {{-- 4. Tombol Aksi Login/Logout --}}
            @guest
                <a href="{{ route('login') }}" class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-700 inline-flex items-center justify-center gap-2">
                    <i class="fas fa-right-to-bracket"></i> {{ __('Login') }}
                </a>
            @else
                <form method="POST" action="{{ route('logout') }}" class="m-0">
                    @csrf
                    <button type="submit" class="w-full rounded-lg bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-700 inline-flex items-center justify-center gap-2">
                        <i class="fas fa-sign-out-alt"></i> {{ __('Logout') }}
                    </button>
                </form>
            @endguest
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
                                        <div class="flex items-center gap-2" data-quantity-control>
                                            <button type="button" data-action="decrement" class="rounded-full border border-zinc-200 px-2 text-xs font-semibold text-zinc-600 transition hover:border-emerald-400">-</button>
                                            <span class="text-base font-semibold text-zinc-900" data-quantity-display>{{ $item['quantity'] }}</span>
                                            <button type="button" data-action="increment" class="rounded-full border border-zinc-200 px-2 text-xs font-semibold text-zinc-600 transition hover:border-emerald-400">+</button>
                                            <form action="{{ route('shop.cart.update', $item['product']) }}" method="POST" class="sr-only" data-quantity-form>
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
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

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-quantity-control]').forEach(control => {
                const display = control.querySelector('[data-quantity-display]');
                const form = control.querySelector('[data-quantity-form]');
                const input = form?.querySelector('input[name="quantity"]');
                const decrement = control.querySelector('[data-action="decrement"]');
                const increment = control.querySelector('[data-action="increment"]');

                const adjustButtons = (current) => {
                    if (!decrement) {
                        return;
                    }
                    const isDisabled = current <= 1;
                    decrement.disabled = isDisabled;
                    decrement.classList.toggle('opacity-60', isDisabled);
                    decrement.classList.toggle('cursor-not-allowed', isDisabled);
                };

                const updateQuantity = (delta) => {
                    if (!display || !input || !form) {
                        return;
                    }
                    const current = Number(display.textContent) || 0;
                    const next = Math.max(0, current + delta);
                    if (next === current) {
                        return;
                    }
                    display.textContent = next;
                    input.value = next;
                    adjustButtons(next);
                    form.submit();
                };

                const initialQuantity = Number(display?.textContent) || 0;
                adjustButtons(initialQuantity);

                decrement?.addEventListener('click', () => updateQuantity(-1));
                increment?.addEventListener('click', () => updateQuantity(1));
            });
        });
    </script>
</x-layouts.plain>

