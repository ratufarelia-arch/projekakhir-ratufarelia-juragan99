@php
    use Illuminate\Support\Str;

    // Logika Data (Dipertahankan)
    $featured = $recipes->first();
    $otherRecipes = $recipes->slice(1);
    
    // Placeholder Image (Bisa diganti nanti)
    $placeholderImg = "https://images.unsplash.com/photo-1547592180-85f173990554?q=80&w=2070&auto=format&fit=crop";
@endphp

<x-layouts.plain :title="__('Resep & Inspirasi Masak')">
    <div class="min-h-screen bg-white text-zinc-900 font-sans">

        {{-- ================= NAVBAR (KONSISTEN DENGAN CART) ================= --}}
        <nav class="sticky top-0 z-30 bg-white/80 backdrop-blur-md shadow-sm border-b border-gray-100 transition-all duration-300">
            <div class="mx-auto flex max-w-6xl items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-0">
                
                {{-- Logo --}}
                <div class="flex items-center gap-4">
                    <span class="text-emerald-600 text-xl font-bold tracking-wide">Juragan<span class="text-zinc-900">99</span></span>
                </div>

                {{-- Aksi Kanan --}}
                <div class="flex flex-1 items-center justify-end gap-6">
                    <div class="flex items-center gap-5">
                        <a href="{{ route('shop.cart.index') }}" class="group relative text-gray-500 transition hover:text-emerald-600" aria-label="Keranjang">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5M5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4m7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4m-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2m7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2"/></svg>
                            @if(isset($cartQuantity) && $cartQuantity > 0)
                                <span class="absolute -top-1.5 -right-1.5 flex h-4 w-4 items-center justify-center rounded-full bg-rose-500 text-[10px] font-bold text-white shadow-sm ring-2 ring-white">{{ $cartQuantity > 99 ? '99+' : $cartQuantity }}</span>
                            @endif
                        </a>
                        <a href="{{ route('shop.wishlist.index') }}" class="relative text-gray-500 transition hover:text-emerald-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M8 1.314C12.438-3.248 23.534 4.735 8 15-7.534 4.736 3.562-3.248 8 1.314"/></svg>
                        </a>
                        @auth
                            <a href="{{ route('shop.orders.index') }}" class="text-sm font-semibold text-zinc-500 transition hover:text-emerald-600">{{ __('Pesanan') }}</a>
                        @endauth
                        {{-- Menu Aktif --}}
                        <a href="{{ route('recipes.index') }}" class="text-sm font-bold text-emerald-600">{{ __('Resep') }}</a>
                    </div>

                    <span class="h-5 w-px bg-gray-200 hidden sm:block"></span>

                    @guest
                        <a href="{{ route('login') }}" class="rounded-lg bg-emerald-600 px-5 py-2 text-sm font-semibold text-white shadow-md shadow-emerald-500/20 transition hover:bg-emerald-700 hover:shadow-lg">
                            {{ __('Login') }}
                        </a>
                    @else
                        <form method="POST" action="{{ route('logout') }}" class="m-0">
                            @csrf
                            <button type="submit" class="text-sm font-semibold text-zinc-500 hover:text-rose-600 transition">{{ __('Logout') }}</button>
                        </form>
                    @endguest
                </div>
            </div>
        </nav>

        {{-- ================= HERO SECTION (FEATURED) ================= --}}
        @if($featured)
        <div class="relative bg-zinc-900 pb-16 pt-12 sm:pb-24 lg:pb-32 xl:pb-36 overflow-hidden">
            {{-- Decorative Background Elements --}}
            <div class="absolute inset-0 overflow-hidden">
                <div class="absolute left-[calc(50%-19rem)] top-[calc(50%-36rem)] -z-10 transform-gpu blur-3xl">
                    <div class="aspect-[1097/845] w-[68.5625rem] bg-gradient-to-tr from-[#10b981] to-[#064e3b] opacity-20" style="clip-path: polygon(74.1% 44.1%, 100% 61.6%, 97.5% 26.9%, 85.5% 0.1%, 80.7% 2%, 72.5% 32.5%, 60.2% 62.4%, 52.4% 68.1%, 47.5% 58.3%, 45.2% 34.5%, 27.5% 76.7%, 0.1% 64.9%, 17.9% 100%, 27.6% 76.8%, 76.1% 97.7%, 74.1% 44.1%)"></div>
                </div>
            </div>

            <div class="mx-auto flex max-w-6xl flex-col-reverse gap-12 px-4 sm:px-6 lg:px-0 lg:flex-row lg:items-center">
                {{-- Text Content --}}
                <div class="relative z-10 lg:w-1/2 lg:pr-10">
                    <div class="inline-flex items-center gap-2 rounded-full bg-emerald-500/10 px-3 py-1 text-xs font-semibold uppercase tracking-widest text-emerald-400 ring-1 ring-inset ring-emerald-500/20">
                        <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                        {{ __('Rekomendasi Chef') }}
                    </div>
                    
                    <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:leading-[1.1]">
                        {{ $featured->title ?? __('Steak Ribeye Sempurna dalam 15 Menit') }}
                    </h1>
                    
                    <p class="mt-6 text-lg leading-relaxed text-zinc-400">
                        {{ $featured->excerpt ?? __('Pelajari teknik rahasia restoran bintang lima untuk mendapatkan tekstur daging yang juicy, lembut, dan penuh cita rasa hanya dengan peralatan dapur sederhana.') }}
                    </p>
                    
                    <div class="mt-10 flex flex-wrap items-center gap-4">
                        <a href="#" class="rounded-xl bg-emerald-600 px-6 py-3.5 text-sm font-bold text-white shadow-lg shadow-emerald-900/20 transition hover:bg-emerald-500 hover:-translate-y-0.5">
                            {{ __('Baca Resep Lengkap') }}
                        </a>
                        @if($featured->product_link)
                            <a href="{{ $featured->product_link }}" class="group flex items-center gap-2 rounded-xl bg-white/5 px-6 py-3.5 text-sm font-bold text-white ring-1 ring-white/10 transition hover:bg-white/10">
                                {{ __('Beli Bahan') }}
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="transition group-hover:translate-x-1" viewBox="0 0 16 16"><path fill-rule="evenodd" d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8"/></svg>
                            </a>
                        @endif
                    </div>

                    {{-- Mini Stats --}}
                    <dl class="mt-10 grid grid-cols-3 gap-6 border-t border-white/10 pt-6 text-left">
                        <div>
                            <dt class="text-xs font-medium text-zinc-500">{{ __('Waktu') }}</dt>
                            <dd class="mt-1 text-sm font-semibold text-white">30 Mins</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-zinc-500">{{ __('Kesulitan') }}</dt>
                            <dd class="mt-1 text-sm font-semibold text-white">Medium</dd>
                        </div>
                        <div>
                            <dt class="text-xs font-medium text-zinc-500">{{ __('Porsi') }}</dt>
                            <dd class="mt-1 text-sm font-semibold text-white">2 Orang</dd>
                        </div>
                    </dl>
                </div>

                {{-- Featured Image / Visual --}}
                <div class="relative lg:w-1/2">
                    <div class="relative aspect-[4/3] w-full overflow-hidden rounded-2xl shadow-2xl ring-1 ring-white/10 sm:aspect-[3/2] lg:aspect-[4/3]">
                         {{-- Overlay Gradient untuk teks readability jika ada teks di atas gambar --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-zinc-900/40 via-transparent to-transparent z-10"></div>
                        
                        <img 
                            src="{{ $featured->image_url ?? $placeholderImg }}" 
                            alt="{{ $featured->title }}" 
                            class="h-full w-full object-cover transition duration-700 hover:scale-105"
                        >
                        
                        {{-- Floating Card Effect --}}
                        <div class="absolute bottom-6 left-6 right-6 z-20 hidden sm:block">
                            <div class="rounded-xl bg-white/10 p-4 backdrop-blur-md ring-1 ring-white/20">
                                <div class="flex items-start gap-4">
                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full bg-emerald-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="h-5 w-5 text-white">
                                          <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="font-semibold text-white text-sm">{{ __('Bahan Utama Tersedia') }}</h3>
                                        <p class="text-xs text-zinc-300 mt-1">{{ __('Beli daging segar langsung dari toko kami untuk hasil terbaik.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- ================= LIST RESEP (GRID) ================= --}}
        <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-0">
            
            {{-- Section Header --}}
            <div class="mb-12  flex flex-col justify-between gap-4 border-b border-gray-200 pb-6 sm:flex-row sm:items-end">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-zinc-900">{{ __('Jelajahi Resep') }}</h2>
                    <p class="mt-2 text-zinc-500">{{ __('Inspirasi masakan daging sapi pilihan untuk keluarga Anda.') }}</p>
                </div>
                {{-- Optional: Filter Dropdown (Visual Only) --}}
                <div class="relative">
                    <button type="button" class="inline-flex items-center gap-2 rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-zinc-700 hover:bg-gray-50">
                        <span>{{ __('Terbaru') }}</span>
                        <svg class="h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                </div>
            </div>

            {{-- Grid Cards --}}
            <div class="grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-3">
                @forelse($otherRecipes as $recipe)
                    <article class="group flex flex-col items-start h-full">
                        {{-- Image Wrapper --}}
                        <div class="relative w-full overflow-hidden rounded-2xl bg-gray-100 aspect-[4/3] ring-1 ring-gray-900/5">
                            <a href="#">
                                <img 
                                    src="{{ $placeholderImg }}?recipe={{ $loop->index }}" 
                                    alt="{{ $recipe->title }}" 
                                    class="absolute inset-0 h-full w-full object-cover transition duration-500 group-hover:scale-105"
                                >
                                <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 transition duration-300 group-hover:opacity-100"></div>
                            </a>
                            {{-- Category Badge --}}
                            <div class="absolute left-4 top-4">
                                <span class="inline-flex items-center rounded-md bg-white/90 px-2.5 py-1 text-xs font-bold uppercase tracking-wide text-emerald-700 shadow-sm backdrop-blur-sm">
                                    {{ __('Ide Masak') }}
                                </span>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="mt-6 flex flex-1 flex-col justify-between w-full">
                            <div>
                                <div class="flex items-center gap-3 text-xs text-zinc-500 mb-3">
                                    <time datetime="{{ $recipe->published_at?->format('Y-m-d') }}" class="flex items-center gap-1.5">
                                        <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ $recipe->published_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}
                                    </time>
                                    <span class="h-1 w-1 rounded-full bg-zinc-300"></span>
                                    <span>5 min read</span>
                                </div>

                                <h3 class="text-xl font-bold leading-tight text-zinc-900 transition group-hover:text-emerald-600">
                                    <a href="#">
                                        {{ $recipe->title }}
                                    </a>
                                </h3>
                                
                                <p class="mt-3 line-clamp-3 text-sm leading-relaxed text-zinc-600">
                                    {{ $recipe->excerpt ?? Str::limit(strip_tags($recipe->body), 110) }}
                                </p>
                            </div>

                            {{-- Footer Actions --}}
                            <div class="mt-6 flex items-center justify-between border-t border-gray-100 pt-4 w-full">
                                <a href="#" class="text-sm font-bold text-emerald-600 transition hover:text-emerald-700">
                                    {{ __('Baca Selengkapnya') }} &rarr;
                                </a>
                                
                                @if($recipe->product_link)
                                    <a href="{{ $recipe->product_link }}" class="rounded-lg bg-gray-50 p-2 text-zinc-500 transition hover:bg-emerald-50 hover:text-emerald-600" title="{{ __('Lihat Produk') }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16"><path d="M8 1a2.5 2.5 0 0 1 2.5 2.5V4h-5v-.5A2.5 2.5 0 0 1 8 1zm3.5 3v-.5a3.5 3.5 0 1 0-7 0V4H1v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V4h-3.5zM2 5h12v9a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V5z" /></svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full flex flex-col items-center justify-center py-20 text-center">
                        <div class="rounded-full bg-white p-6">
                            <svg class="h-10 w-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <h3 class="mt-4 text-lg font-bold text-zinc-900">{{ __('Belum Ada Resep') }}</h3>
                        <p class="mt-2 text-zinc-500">{{ __('Kami sedang menyiapkan resep-resep lezat untuk Anda. Cek kembali nanti!') }}</p>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($recipes->hasPages())
                <div class="mt-16 border-t border-gray-100 pt-8">
                    {{ $recipes->links() }}
                </div>
            @endif
        </div>

    </div>
</x-layouts.plain>