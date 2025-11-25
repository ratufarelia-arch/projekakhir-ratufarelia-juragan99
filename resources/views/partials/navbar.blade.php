@php
    $cartQuantityValue = $cartQuantity ?? collect(session('cart', []))->sum('quantity');
    $wishlistCountValue = $wishlistCount ?? count(session('wishlist', []));
@endphp

<nav class="sticky top-0 z-30 bg-white shadow-md border-b border-gray-100">
    <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-0">
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="text-xl font-extrabold text-gray-800 tracking-tight">
            <span class="text-emerald-600 text-xl font-bold tracking-wide">Jurangan99</span>
       </a>
        </div>

        <div class="flex flex-1 items-center justify-end gap-4">
            <div class="flex items-center gap-4">
                <a
                    href="{{ route('shop.cart.index') }}"
                    class="relative text-gray-700 transition hover:text-emerald-600"
                    aria-label="{{ __('Lihat keranjang') }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
                        <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708"/>
                    </svg>
                    @if($cartQuantityValue > 0)
                        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-semibold text-white">
                            {{ $cartQuantityValue > 99 ? '99+' : $cartQuantityValue }}
                        </span>
                    @endif
                </a>

                <a
                    href="{{ route('shop.wishlist.index') }}"
                    class="relative text-gray-700 transition hover:text-emerald-600"
                    aria-label="{{ __('Wishlist') }}"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-heart-fill" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/>
                    </svg>
                    @if($wishlistCountValue > 0)
                        <span class="absolute -top-1 -right-1 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-semibold text-white">
                            {{ $wishlistCountValue > 99 ? '99+' : $wishlistCountValue }}
                        </span>
                    @endif
                </a>

                @auth
                    <a href="{{ route('shop.orders.index') }}" class="text-sm font-semibold text-zinc-600 transition hover:text-emerald-600">{{ __('Pesanan saya') }}</a>
                @endauth
                <a href="{{ route('recipes.index') }}" class="text-sm font-semibold text-zinc-600 transition hover:text-emerald-600">{{ __('Resep') }}</a>
            </div>

            <a href="{{ route('contact.index') }}" class="text-sm font-semibold text-zinc-600 transition hover:text-emerald-600">{{ __('Kontak Kami') }}</a>

            <span class="h-6 w-px bg-gray-200 hidden sm:block"></span>

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
