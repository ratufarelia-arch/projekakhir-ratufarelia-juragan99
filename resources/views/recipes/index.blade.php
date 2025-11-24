@php
    use Illuminate\Support\Str;

    // Mengambil resep pertama sebagai featured, dan sisanya untuk list
    $featured = $recipes->first();
    $otherRecipes = $recipes->slice(1);
    
    // Placeholder image untuk visualisasi desain (Ganti dengan URL gambar asli dari database Anda nanti)
    $placeholderImg = "https://images.unsplash.com/photo-1546039973-12360303a765?q=80&w=2070&auto=format&fit=crop";
@endphp

<x-layouts.plain :title="__('Resep & Inspirasi Masak')">
    
    {{-- Hapus padding default container agar hero section bisa full width --}}
    <div class="-mx-4 sm:-mx-6 lg:-mx-8 -my-8">

        {{-- ===================== HERO SECTION (Featured Recipe) ===================== --}}
        <section class="relative overflow-hidden bg-zinc-900 py-16 sm:py-24">
            {{-- Background Image Overlay (Opsional: bisa diganti dengan gambar resep spesifik) --}}
            <div class="absolute inset-0">
                <img src="{{ $placeholderImg }}" alt="Background cooking" class="h-full w-full object-cover object-center opacity-20 blur-sm scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-zinc-900 via-zinc-900/80"></div>
            </div>

            <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="grid gap-12 lg:grid-cols-2 lg:items-center">
                    {{-- Text Content --}}
                    <div>
                        <div class="inline-flex items-center rounded-full bg-emerald-400/10 px-3 py-1 text-sm font-medium text-emerald-400 ring-1 ring-inset ring-emerald-400/20">
                            {{ __('Resep Unggulan Minggu Ini') }}
                        </div>
                        
                        <h1 class="mt-6 text-4xl font-extrabold tracking-tight text-white sm:text-5xl">
                            {{ $featured->title ?? __('Cara Membuat Steak Sempurna ala Restoran') }}
                        </h1>
                        
                        <p class="mt-6 text-lg leading-8 text-zinc-300">
                            {{ $featured->excerpt ?? __('Panduan lengkap memilih potongan daging terbaik, teknik memanggang dengan suhu yang tepat, hingga cara mengistirahatkan daging untuk hasil yang juicy dan lezat.') }}
                        </p>
                        
                        <div class="mt-10 flex flex-wrap items-center gap-y-4 gap-x-6">
                            <a
                                href="{{ $featured->product_link ?? route('shop.products.index') }}"
                                class="rounded-full bg-emerald-600 px-8 py-3.5 text-base font-semibold text-white shadow-sm hover:bg-emerald-500  focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-emerald-600 transition"
                            >
                                {{ $featured->product_link_text ?? __('Lihat Bahan Utamanya') }}
                            </a>
                            <div class="text-sm leading-6 text-zinc-400">
                                Dipublikasikan pada <span class="font-medium text-white">{{ $featured?->published_at?->translatedFormat('d F Y') ?? now()->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Steps Card (Visual Element) --}}
                    <div class="relative lg:ml-auto">
                         <div class="rounded-3xl bg-white/5 p-2 ring-1 ring-white/10 backdrop-blur-xl">
                            <div class="rounded-2xl bg-zinc-900/90 p-6 sm:p-8">
                                <div class="flex items-center gap-3 border-b border-zinc-800 pb-4">
                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-emerald-500/10">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-5 w-5 text-emerald-400">
                                          <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12zm14.024-.983a1.125 1.125 0 010 1.966l-5.603 3.113A1.125 1.125 0 019 15.113V8.887c0-.857.921-1.4 1.671-.983l5.603 3.113z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-white">{{ __('Tahapan Singkat') }}</h3>
                                </div>
                                <ol class="mt-6 space-y-4 text-sm text-zinc-300">
                                    <li class="flex gap-3">
                                        <span class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-zinc-800 text-xs font-medium text-white">1</span>
                                        <span>{{ __('Marinasi daging dengan garam laut, lada hitam tumbuk, dan sedikit minyak zaitun selama minimal 1 jam di suhu ruang.') }}</span>
                                    </li>
                                    <li class="flex gap-3">
                                        <span class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-zinc-800 text-xs font-medium text-white">2</span>
                                        <span>{{ __('Panaskan wajan besi cor (cast iron) hingga berasap. Masak daging 3-4 menit per sisi untuk tingkat kematangan medium-rare.') }}</span>
                                    </li>
                                    <li class="flex gap-3">
                                        <span class="flex h-6 w-6 flex-shrink-0 items-center justify-center rounded-full bg-zinc-800 text-xs font-medium text-white">3</span>
                                        <span>{{ __('Sangat Penting: Istirahatkan daging di atas talenan selama 5-7 menit sebelum dipotong agar sarinya tidak keluar.') }}</span>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- ===================== RECIPE GRID SECTION ===================== --}}
        <section class="bg-white py-16 sm:py-24">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="max-w-2xl">
                    <h2 class="text-3xl font-bold tracking-tight text-zinc-900 sm:text-4xl">{{ __('Inspirasi Masakan Terbaru') }}</h2>
                    <p class="mt-4 text-lg text-zinc-500">{{ __('Temukan berbagai ide olahan daging sapi segar untuk menu harian maupun spesial keluarga Anda.') }}</p>
                </div>

                <div class="mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-12 sm:mt-20 lg:max-w-none lg:grid-cols-3">
                    @forelse($otherRecipes as $recipe)
                        <article class="flex flex-col items-start justify-between group">
                            {{-- Image Container --}}
                            <div class="relative w-full overflow-hidden rounded-2xl bg-zinc-100 aspect-[16/10]">
                                {{-- Ganti src di bawah dengan $recipe->image_url jika sudah ada --}}
                                <img src="{{ $placeholderImg }}?recipe={{ $loop->index }}" alt="{{ $recipe->title }}" class="absolute inset-0 h-full w-full object-cover transition duration-300 group-hover:scale-105">
                                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-zinc-900/10"></div>
                            </div>

                            <div class="max-w-xl">
                                <div class="mt-8 flex items-center gap-x-4 text-xs">
                                    <time datetime="{{ $recipe->published_at?->format('Y-m-d') }}" class="text-zinc-500">
                                        {{ $recipe->published_at?->translatedFormat('d F Y') }}
                                    </time>
                                    {{-- Contoh Kategori Tag --}}
                                    <span class="relative z-10 rounded-full bg-zinc-100 px-3 py-1.5 font-medium text-zinc-600 hover:bg-zinc-200">
                                        Ide Masakan
                                    </span>
                                </div>
                                <div class="group relative">
                                    <h3 class="mt-3 text-xl font-semibold leading-7 text-zinc-900 group-hover:text-emerald-600 transition">
                                        <a href="#">
                                            <span class="absolute inset-0"></span>
                                            {{ $recipe->title }}
                                        </a>
                                    </h3>
                                    <p class="mt-5 line-clamp-3 text-sm leading-6 text-zinc-600">
                                        {{ $recipe->excerpt ?? Str::limit(strip_tags($recipe->body), 120) }}
                                    </p>
                                </div>
                                
                                {{-- Product Link CTA --}}
                                @if($recipe->product_link)
                                    <div class="mt-6 flex items-center gap-3 border-t border-zinc-100 pt-6">
                                        <a href="{{ $recipe->product_link }}" class="flex items-center text-sm font-bold text-emerald-600 transition hover:text-emerald-700">
                                            {{ $recipe->product_link_text ?? __('Lihat Daging yang Digunakan') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="ml-2 h-4 w-4">
                                                <path fill-rule="evenodd" d="M3 10a.75.75 0 01.75-.75h10.638L10.23 5.29a.75.75 0 111.04-1.08l5.5 5.25a.75.75 0 010 1.08l-5.5 5.25a.75.75 0 11-1.04-1.08l4.158-3.96H3.75A.75.75 0 013 10z" clip-rule="evenodd" />
                                            </svg>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full py-12 text-center text-zinc-500">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="mx-auto h-12 w-12 text-zinc-300">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                            </svg>
                            <p class="mt-4">{{ __('Belum ada resep tambahan yang dipublikasikan saat ini.') }}</p>
                        </div>
                    @endforelse
                </div>

                <div class="mt-16">
                    {{ $recipes->links() }}
                </div>
            </div>
        </section>

    </div>
</x-layouts.plain>