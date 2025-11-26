@php
    $product ??= null;
    $editing = isset($product);
    $imageUrl = $product?->image_url;
    $cutTypes ??= collect();
@endphp

<div class="grid grid-cols-1 gap-8 lg:grid-cols-3 items-start">
        
    {{-- KOLOM KIRI (UTAMA): Informasi Dasar, Deskripsi, Media --}}
    <div class="lg:col-span-2 space-y-8">
        
        {{-- Card 1: Informasi Dasar --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h3 class="mb-6 text-base font-bold text-zinc-900">{{ __('Informasi Dasar') }}</h3>
            
            <div class="space-y-6">
                {{-- Nama Produk --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Nama Produk') }}</label>
                    <input
                        type="text"
                        name="name"
                        id="nameInput"
                        value="{{ old('name', $product->name ?? '') }}"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                        placeholder="Contoh: Daging Rendang Premium"
                        oninput="generateSlug()"
                    >
                    @error('name')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>

                {{-- Slug & Kategori (Grid) --}}
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-zinc-700">{{ __('Slug URL') }}</label>
                        <div class="relative">
                            <input
                                type="text"
                                name="slug"
                                id="slugInput"
                                value="{{ old('slug', $product->slug ?? '') }}"
                                class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                                placeholder="daging-rendang-premium"
                            >
                           
                        </div>
                        @error('slug')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                    </div>

                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-zinc-700">{{ __('Kategori') }}</label>
                        <input
                            type="text"
                            name="category"
                            value="{{ old('category', $product->category ?? '') }}"
                            class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                            placeholder="Contoh: Daging Sapi"
                        >
                        @error('category')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>

                {{-- Deskripsi --}}
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Deskripsi Lengkap') }}</label>
                    <textarea
                        name="description"
                        rows="5"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition resize-none"
                        placeholder="Jelaskan detail produk, tekstur, aroma, dan keunggulannya..."
                    >{{ old('description', $product->description ?? '') }}</textarea>
                    @error('description')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>
                
                 {{-- Cooking Tips --}}
                 <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-semibold text-zinc-700">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="text-amber-500" viewBox="0 0 16 16"><path d="M11.251.068a.5.5 0 0 1 .227.58L9.677 6.5H13a.5.5 0 0 1 .364.843l-8 8.5a.5.5 0 0 1-.842-.49L6.323 9.5H3a.5.5 0 0 1-.364-.843l8-8.5a.5.5 0 0 1 .615-.09z"/></svg>
                        {{ __('Saran Penyajian / Tips Masak') }}
                    </label>
                    <textarea
                        name="cooking_tips"
                        rows="3"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition resize-none"
                        placeholder="Contoh: Cocok dimasak slow cook selama 2 jam..."
                    >{{ old('cooking_tips', $product->cooking_tips ?? '') }}</textarea>
                    @error('cooking_tips')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

        {{-- Card 2: Media / Gambar --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-base font-bold text-zinc-900">{{ __('Media Produk') }}</h3>
            
            <div class="flex flex-col sm:flex-row gap-6">
                {{-- Preview Area --}}
                <div class="flex-shrink-0">
                    <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-zinc-500">{{ __('Preview') }}</p>
                    <div class="relative h-40 w-40 overflow-hidden rounded-xl border border-zinc-200 bg-zinc-50">
                        <img 
                            id="imagePreview" 
                            src="{{ $imageUrl ?? 'https://placehold.co/400x400?text=No+Image' }}" 
                            alt="Preview" 
                            class="h-full w-full object-cover" 
                        />
                    </div>
                </div>

                {{-- Upload Area --}}
                <div class="flex-1">
                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wider text-zinc-500">{{ __('Upload Gambar Baru') }}</label>
                    <label for="imageUpload" class="flex w-full cursor-pointer flex-col items-center justify-center rounded-xl border-2 border-dashed border-zinc-300 bg-zinc-50 py-8 text-center transition hover:border-emerald-500 hover:bg-emerald-50/30">
                        <div class="flex flex-col items-center justify-center gap-2">
                            <div class="rounded-full bg-white p-2 shadow-sm ring-1 ring-zinc-200">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="text-zinc-400" viewBox="0 0 16 16"><path d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5"/><path d="M7.646 1.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 2.707V11.5a.5.5 0 0 1-1 0V2.707L5.354 4.854a.5.5 0 1 1-.708-.708z"/></svg>
                            </div>
                            <div class="text-sm font-medium text-zinc-600">
                                <span>Klik untuk upload</span> 
                                <span class="text-zinc-400">atau drag & drop</span>
                            </div>
                            <p class="text-xs text-zinc-400">PNG, JPG, WEBP (Max. 2MB)</p>
                        </div>
                        <input id="imageUpload" type="file" name="image" accept="image/*" class="hidden" onchange="previewImage(this)" />
                    </label>
                    @error('image')<p class="mt-2 text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>
    </div>


    {{-- KOLOM KANAN (SIDEBAR): Harga, Stok, Spesifikasi, Status --}}
    <div class="space-y-8">
        
        {{-- Card 3: Status & Organisasi --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h3 class="mb-4 text-base font-bold text-zinc-900">{{ __('Status') }}</h3>
            
            <div class="space-y-4">
                {{-- Toggle Active --}}
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-zinc-200 p-3 transition hover:bg-zinc-50">
                    <div class="flex items-center h-5">
                        <input type="hidden" name="is_active" value="0">
                        <input 
                            type="checkbox" 
                            name="is_active" 
                            value="1" 
                            class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-600"
                            @checked(old('is_active', $product->is_active ?? true))
                        >
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-zinc-900">{{ __('Aktif / Publik') }}</span>
                        <span class="block text-xs text-zinc-500">{{ __('Produk akan tampil di katalog.') }}</span>
                    </div>
                </label>

                {{-- Toggle Halal --}}
                <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-zinc-200 p-3 transition hover:bg-zinc-50">
                    <div class="flex items-center h-5">
                        <input type="hidden" name="halal_certified" value="0">
                        <input 
                            type="checkbox" 
                            name="halal_certified" 
                            value="1" 
                            class="h-4 w-4 rounded border-zinc-300 text-emerald-600 focus:ring-emerald-600"
                            @checked(old('halal_certified', $product->halal_certified ?? false))
                        >
                    </div>
                    <div>
                        <span class="block text-sm font-semibold text-zinc-900">{{ __('Sertifikasi Halal') }}</span>
                        <span class="block text-xs text-zinc-500">{{ __('Menampilkan badge halal.') }}</span>
                    </div>
                </label>
            </div>
        </div>

        {{-- Card 4: Harga & Stok --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h3 class="mb-6 text-base font-bold text-zinc-900">{{ __('Harga & Inventaris') }}</h3>
            
            <div class="space-y-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Harga Satuan (Rp)') }}</label>
                    <div class="relative">
                        <span class="absolute left-4 top-2.5 text-zinc-400 font-semibold">Rp</span>
                        <input
                            type="number"
                            name="price"
                            value="{{ old('price', $product->price ?? '') }}"
                            class="w-full rounded-xl border-zinc-200 bg-zinc-50 pl-10 pr-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                            placeholder="0"
                        >
                    </div>
                    @error('price')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-zinc-700">{{ __('Diskon') }}</label>
                        <input
                            type="number"
                            name="discount"
                            value="{{ old('discount', $product->discount ?? '') }}"
                            class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                            placeholder="0"
                        >
                         @error('discount')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                    <div class="space-y-2">
                        <label class="text-sm font-semibold text-zinc-700">{{ __('Stok Awal') }}</label>
                        <input
                            type="number"
                            name="stock"
                            value="{{ old('stock', $product->stock ?? '') }}"
                            class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                            placeholder="0"
                        >
                        @error('stock')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                    </div>
                </div>
            </div>
        </div>

        {{-- Card 5: Spesifikasi --}}
        <div class="rounded-2xl border border-zinc-200 bg-white p-6 shadow-sm">
            <h3 class="mb-6 text-base font-bold text-zinc-900">{{ __('Spesifikasi') }}</h3>
            
            <div class="space-y-5">
                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Jenis Potongan') }}</label>
                    <div class="relative">
                        <select
                            name="cut_type"
                            class="w-full appearance-none rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition cursor-pointer"
                        >
                            <option value="">{{ __('Pilih jenis potongan') }}</option>
                            @foreach($cutTypes as $cut)
                                <option value="{{ $cut->slug }}" @selected(old('cut_type', $product->cut_type ?? '') === $cut->slug)>{{ $cut->name }}</option>
                            @endforeach
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-zinc-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                        </div>
                    </div>
                     @error('cut_type')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Berat Dasar (Kg)') }}</label>
                    <input
                        type="number"
                        step="0.01"
                        name="weight"
                        value="{{ old('weight', $product->weight ?? '') }}"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                        placeholder="Contoh: 1.00"
                    >
                    @error('weight')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>

                <div class="space-y-2">
                    <label class="text-sm font-semibold text-zinc-700">{{ __('Opsi Varian Berat') }}</label>
                    <input
                        type="text"
                        name="weight_variant"
                        value="{{ old('weight_variant', $product->weight_variant ?? '') }}"
                        class="w-full rounded-xl border-zinc-200 bg-zinc-50 px-4 py-2.5 text-zinc-900 placeholder:text-zinc-400 focus:border-emerald-500 focus:bg-white focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                        placeholder="Dipisah koma (Cth: 250g, 500g)"
                    >
                    @error('weight_variant')<p class="text-xs text-rose-500 font-medium">{{ $message }}</p>@enderror
                </div>
            </div>
        </div>

    </div>
</div>

{{-- Helper Scripts --}}
<script>
    // Preview Image Logic
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imagePreview').src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Simple Slug Generator
    function generateSlug() {
        const name = document.getElementById('nameInput').value;
        const slug = name.toLowerCase()
            .replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, '-') // collapse whitespace and replace by -
            .replace(/-+/g, '-'); // collapse dashes
        document.getElementById('slugInput').value = slug;
    }
</script>