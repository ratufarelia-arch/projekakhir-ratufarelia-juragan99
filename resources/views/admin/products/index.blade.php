@php
    use Illuminate\Support\Str;
@endphp

<x-layouts.app :title="__('Produk')">
    <div class="min-h-screen bg-zinc-50 font-sans text-zinc-900 p-4 lg:p-8 rounded-2xl">
        
        {{-- Header Section --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-zinc-900">{{ __('Katalog Produk') }}</h1>
                <p class="mt-1 text-sm text-zinc-500">{{ __('Kelola inventaris, harga, dan stok barang dagangan Anda.') }}</p>
            </div>
            
            <div class="flex flex-col sm:flex-row gap-3">
                {{-- Search Bar --}}
                <form method="GET" class="flex items-center gap-2">
                    <div class="relative">
                        <input
                            type="search"
                            name="search"
                            value="{{ $search ?? '' }}"
                            placeholder="{{ __('Cari nama produk, slug, atau kategori...') }}"
                            class="w-full sm:w-64 rounded-xl border border-zinc-200 bg-white px-4 py-2.5 text-sm text-zinc-700 shadow-sm focus:border-emerald-500 focus:outline-none focus:ring-1 focus:ring-emerald-500 transition"
                        >
                        <svg class="absolute right-3 top-3 h-4 w-4 text-zinc-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <button type="submit" class="rounded-xl bg-emerald-500 px-4 py-3 text-xs font-semibold uppercase tracking-[0.3em] text-white transition hover:bg-emerald-600">
                        {{ __('Search') }}
                    </button>
                </form>

                {{-- Add Button --}}
                <a
                    href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center justify-center gap-2 rounded-xl border border-emerald-500 bg-emerald-500 px-5 py-2.5 text-sm font-bold text-white shadow-md shadow-emerald-200 transition hover:bg-emerald-600 hover:-translate-y-0.5"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/></svg>
                    {{ __('Tambah Produk') }}
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="mb-6 flex items-center gap-2 rounded-xl border border-emerald-100 bg-emerald-50 px-5 py-4 text-sm font-medium text-emerald-800 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Table Card --}}
        <div class="overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-zinc-100 text-left text-sm">
                    <thead>
                        <tr class="bg-zinc-50/50">
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Nama Produk') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Harga Satuan') }}</th>
                            <th class="px-6 py-4 text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Stok') }}</th>
                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wider text-zinc-500">{{ __('Aksi') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 bg-white">
                        @forelse($products as $product)
                            <tr class="group transition hover:bg-zinc-50/80">
                                {{-- Product Info (Image + Name merged) --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-4">
                                        <div class="relative h-12 w-12 flex-shrink-0 overflow-hidden rounded-lg border border-zinc-100 bg-zinc-50">
                                            @if($product->image_url)
                                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="h-full w-full object-cover" />
                                            @else
                                                <div class="flex h-full w-full items-center justify-center text-[10px] font-bold text-zinc-400 bg-zinc-100">
                                                    {{ Str::substr($product->name, 0, 2) }}
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="font-bold text-zinc-900">{{ $product->name }}</div>
                                            <div class="text-xs text-zinc-500 font-mono">{{ $product->slug }}</div>
                                        </div>
                                    </div>
                                </td>

                                {{-- Price --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-bold text-zinc-700">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                </td>

                                {{-- Stock Badge --}}
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($product->stock <= 5)
                                        <span class="inline-flex items-center gap-1 rounded-md bg-rose-50 px-2.5 py-1 text-xs font-medium text-rose-700 ring-1 ring-inset ring-rose-600/20">
                                            {{ number_format($product->stock) }} Unit
                                            <span class="h-1.5 w-1.5 rounded-full bg-rose-500 animate-pulse"></span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-medium text-zinc-600 ring-1 ring-inset ring-zinc-500/10">
                                            {{ number_format($product->stock) }} Unit
                                        </span>
                                    @endif
                                </td>

                                {{-- Action Buttons --}}
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex items-center justify-end gap-2">
                                        <a 
                                            href="{{ route('admin.products.edit', $product) }}" 
                                            class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-500 transition hover:border-emerald-500 hover:text-emerald-600 hover:shadow-sm"
                                            title="Edit Produk"
                                        >
                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325"/></svg>
                                        </a>
                                        
                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button 
                                                type="submit" 
                                                class="inline-flex h-8 w-8 items-center justify-center rounded-lg border border-zinc-200 bg-white text-zinc-500 transition hover:border-rose-500 hover:bg-rose-50 hover:text-rose-600 hover:shadow-sm"
                                                title="Hapus Produk"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="currentColor" viewBox="0 0 16 16"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/><path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1 1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div class="rounded-full bg-zinc-50 p-4 mb-3">
                                            <svg class="h-8 w-8 text-zinc-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                            </svg>
                                        </div>
                                        <h3 class="text-sm font-bold text-zinc-900">{{ __('Katalog Kosong') }}</h3>
                                        <p class="text-xs text-zinc-500 mt-1 max-w-xs">{{ __('Belum ada produk. Klik tombol tambah di atas untuk memulai.') }}</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            @if($products->hasPages())
                <div class="border-t border-zinc-100 bg-zinc-50 px-6 py-4">
                    {{ $products->links() }}
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>