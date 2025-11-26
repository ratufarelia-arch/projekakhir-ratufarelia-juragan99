<div class="grid grid-cols-1 gap-8 lg:grid-cols-3 items-start rounded-2xl">
    
    {{-- KOLOM KIRI (UTAMA): Konten Artikel --}}
    <div class="lg:col-span-2 space-y-8">
        
        {{-- Card 1: Editor Konten --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h3 class="mb-6 text-base font-bold text-zinc-900">{{ __('Konten Resep') }}</h3>
            
            <div class="space-y-6">
                {{-- Title --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Judul Resep') }}</label>
                    <input
                        type="text"
                        name="title"
                        id="titleInput"
                        value="{{ old('title', $recipe->title) }}"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition font-medium text-lg"
                        placeholder="Contoh: Cara Membuat Steak Ribeye Sempurna"
                        oninput="generateRecipeSlug()"
                    />
                    @error('title')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>

                {{-- Slug --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Slug URL') }}</label>
                    <div class="relative">
                        <input
                            type="text"
                            name="slug"
                            id="slugInput"
                            value="{{ old('slug', $recipe->slug) }}"
                            class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition text-sm font-mono "
                            placeholder="cara-membuat-steak-ribeye-sempurna"
                        />
                         <button type="button" onclick="generateRecipeSlug()" class="absolute right-3 top-2.5 text-xs font-semibold text-emerald-600 hover:text-emerald-700">
                            {{ __('Generate') }}
                        </button>
                    </div>
                    @error('slug')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>

                {{-- Excerpt --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Kutipan Singkat (Excerpt)') }}</label>
                    <textarea
                        name="excerpt"
                        rows="3"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition resize-none leading-relaxed"
                        placeholder="Tulis ringkasan singkat yang akan muncul di daftar resep..."
                    >{{ old('excerpt', $recipe->excerpt) }}</textarea>
                    <p class="text-[11px] text-zinc-400 text-right">{{ __('Disarankan maksimal 160 karakter.') }}</p>
                    @error('excerpt')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>

                {{-- Body --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Isi Artikel') }}</label>
                    <textarea
                        name="body"
                        rows="15"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-4 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition leading-relaxed font-serif"
                        placeholder="Mulai tulis resep lengkap di sini..."
                    >{{ old('body', $recipe->body) }}</textarea>
                    @error('body')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>

    {{-- KOLOM KANAN (SIDEBAR): Publikasi & Link Produk --}}
    <div class="space-y-8">
        
        {{-- Card 2: Status Publikasi --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-base font-bold text-zinc-900">{{ __('Publikasi') }}</h3>
            
            <div class="space-y-4">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Tanggal Terbit') }}</label>
                    <input
                        type="datetime-local"
                        name="published_at"
                        value="{{ old('published_at', optional($recipe->published_at)->format('Y-m-d\TH:i')) }}"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                    />
                    <p class="text-xs text-zinc-500">{{ __('Kosongkan jika ingin menyimpannya sebagai Draft.') }}</p>
                    @error('published_at')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Card 3: Promosi Produk --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-base font-bold text-zinc-900">{{ __('Produk Terkait') }}</h3>
            
            <div class="space-y-5">
                <div class="p-3 rounded-xl bg-emerald-50 border border-emerald-100 text-xs text-emerald-800 leading-relaxed">
                    {{ __('Hubungkan resep ini dengan produk di toko Anda untuk meningkatkan konversi penjualan.') }}
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Link Produk') }}</label>
                    <div class="relative">
                         <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3 text-zinc-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M4.715 6.542 3.343 7.914a3 3 0 1 0 4.243 4.243l1.828-1.829A3 3 0 0 0 8.586 5.5L8 6.086a1.002 1.002 0 0 0-.154.199 2 2 0 0 1 .861 3.337L6.88 11.45a2 2 0 1 1-2.83-2.83l.793-.792a4.018 4.018 0 0 1-.128-1.287z"/><path d="M6.586 4.672A3 3 0 0 0 7.414 9.5l.775-.776a2 2 0 0 1-.896-3.346L9.12 3.55a2 2 0 1 1 2.83 2.83l-.793.792c.112.42.155.855.128 1.287l1.372-1.372a3 3 0 1 0-4.243-4.243L6.586 4.672z"/></svg>
                        </div>
                        <input
                            type="url"
                            name="product_link"
                            value="{{ old('product_link', $recipe->product_link) }}"
                            class="w-full rounded-xl border-zinc-200 bg-zinc-50 pl-10 pr-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                            placeholder="https://jurangan99.id/shop/..."
                        />
                    </div>
                    @error('product_link')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Teks Tombol') }}</label>
                    <input
                        type="text"
                        name="product_link_text"
                        value="{{ old('product_link_text', $recipe->product_link_text ?? 'Beli Bahan Sekarang') }}"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                        placeholder="Contoh: Beli Daging Ini"
                    />
                    @error('product_link_text')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function generateRecipeSlug() {
        const title = document.getElementById('titleInput').value;
        const slug = title.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes
        document.getElementById('slugInput').value = slug;
    }
</script>