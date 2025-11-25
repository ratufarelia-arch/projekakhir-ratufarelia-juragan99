@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.plain :title="__('Wishlist Anda')">
    {{-- Menggunakan background putih bersih --}}
    <div class="min-h-screen bg-white text-gray-900"> 
        
        {{-- Navigasi Atas --}}
        @include('partials.navbar')

        <div class="mx-auto max-w-6xl px-4 py-8 sm:px-6 lg:px-0">
            
            {{-- Header/Hero Section yang lebih simple --}}
            <header class="border-b border-gray-200 pb-6 mb-8">
                <div class="flex flex-wrap items-center justify-between gap-4">
                    <div>
                        <p class="text-sm uppercase tracking-[0.2em] text-emerald-600 font-semibold">{{ __('Wishlist') }}</p>
                        <h1 class="text-4xl font-extrabold text-gray-900 mt-1">{{ __('Produk favorit Anda') }}</h1>
                        <p class="text-base text-gray-600 mt-2">{{ __('Simpan produk yang ingin Anda cek kembali atau tambahkan ke keranjang nanti.') }}</p>
                    </div>
                    <div class="text-right space-y-1 text-base text-gray-600">
                        <p class="font-semibold">{{ $wishlistItems->count() }} {{ __('Item Disimpan') }}</p>
                    </div>
                </div>
            </header>

            <div class="mt-6 grid gap-8 lg:grid-cols-[1fr,320px]">
                
                {{-- Daftar Produk --}}
                <div>
                    @if($wishlistItems->isEmpty())
                        <section class="rounded-xl border border-gray-200 bg-gray-50 p-10 shadow-sm text-center">
                            <i class="fas fa-heart-broken text-5xl text-gray-300 mb-4"></i>
                            <p class="text-xl font-semibold text-gray-800">{{ __('Wishlist Anda masih kosong.') }}</p>
                            <p class="text-base text-gray-500 mt-2">{{ __('Tambahkan produk favorit Anda terlebih dahulu.') }}</p>
                            <a href="{{ route('home') }}" class="mt-6 inline-flex items-center justify-center gap-2 rounded-lg bg-emerald-600 px-6 py-3 text-sm font-semibold text-white shadow-lg shadow-emerald-500/30 transition hover:bg-emerald-700">
                                <i class="fas fa-shopping-basket"></i>
                                {{ __('Kembali ke katalog') }}
                            </a>
                        </section>
                    @else
                        <div class="space-y-4" id="products">
                            @foreach($wishlistItems as $product)
                                {{-- Kartu Produk Wishlist yang lebih flat dan minimalis --}}
                                <article class="flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-4 shadow-sm md:flex-row md:items-center transition hover:shadow-md">
                                    <div class="flex w-full gap-4">
                                        {{-- Gambar --}}
                                        <div class="h-20 w-20 flex-shrink-0 overflow-hidden rounded-lg border border-gray-100 bg-gray-50">
                                            @if($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-xs uppercase tracking-widest text-gray-400">
                                                    {{ __('No Image') }}
                                                </div>
                                            @endif
                                        </div>
                                        
                                        {{-- Detail Produk --}}
                                        <div class="flex flex-1 flex-col justify-center">
                                            <p class="text-xs uppercase tracking-widest text-emerald-600 font-medium">{{ $product->category ?? __('Uncategorized') }}</p>
                                            <p class="text-lg font-bold text-gray-900 leading-tight">{{ $product->name }}</p>
                                            
                                            <div class="flex flex-wrap items-center gap-x-4 gap-y-1 text-sm text-gray-500 mt-1">
                                                <span class="font-semibold text-emerald-600">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                                <span class="text-xs">{{ __('Stok') }}: {{ number_format($product->stock) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    {{-- Tombol Aksi (Dibuat minimalis, menggunakan ikon) --}}
                                    <div class="flex flex-none items-center gap-3">
                                        
                                        {{-- Tombol Tambah ke Keranjang (Ikon Cart) --}}
                                        <form action="{{ route('shop.cart.add') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $product->id }}">
                                            <input type="hidden" name="quantity" value="1">
                                            <button 
                                                type="submit" 
                                                title="{{ __('Tambah ke keranjang') }}"
                                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-emerald-50 text-emerald-600 transition hover:bg-emerald-600 hover:text-white disabled:opacity-50"
                                                @if($product->stock == 0) disabled @endif
                                            >
                                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-check-fill" viewBox="0 0 16 16">
  <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0m-1.646-7.646-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L8 8.293l2.646-2.647a.5.5 0 0 1 .708.708"/>
</svg>
                                            </button>
                                        </form>

                                        {{-- Tombol Hapus dari Wishlist (Ikon Trash/X) --}}
                                        <form method="POST" action="{{ route('shop.wishlist.remove', $product) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                title="{{ __('Hapus dari wishlist') }}"
                                                class="w-10 h-10 flex items-center justify-center rounded-lg bg-rose-50 text-rose-600 transition hover:bg-rose-600 hover:text-white"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
  <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5M8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5m3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0"/>
</svg>
                                            </button>
                                        </form>
                                        
                                    </div>
                                </article>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                {{-- Sidebar Ringkasan --}}
                <aside class="flex-shrink-0 w-full lg:sticky lg:top-20">
                    <div class="rounded-xl border border-gray-200 bg-gray-50 p-6 shadow-sm">
                        <p class="text-xs uppercase tracking-widest text-gray-500 font-semibold">{{ __('Ringkasan Wishlist') }}</p>
                        
                        <div class="mt-4 border-b border-gray-200 pb-4">
                            <div class="flex items-center justify-between text-base">
                                <span class="text-gray-700">{{ __('Item tersimpan') }}:</span>
                                <span class="font-bold text-gray-900">{{ $wishlistItems->count() }}</span>
                            </div>
                        </div>
                        
                        <a href="{{ route('shop.cart.index') }}" class="mt-4 block w-full rounded-lg bg-white border border-gray-300 px-4 py-2.5 text-center text-sm font-semibold text-gray-700 transition hover:border-emerald-500 hover:text-emerald-600">
                            {{ __('Lanjutkan ke Keranjang') }}
                        </a>
                        
                        {{-- Blok form 'Tambahkan Semua ke Keranjang' DIHAPUS karena route tidak ada --}}

                    </div>
                </aside>
            </div>
        </div>
    </div>
</x-layouts.plain>